<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\StockTransfer;
use App\Http\Traits\FileUpload;
use Illuminate\Support\Facades\DB;
use App\Models\StockTransferDetail;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StockTransferRequest;
use App\Http\Repositories\Admin\ProductRepository;
use App\Http\Repositories\Admin\SupplierRepository;
use App\Http\Repositories\Admin\StockTransferRepository;

class StockTransferController extends BaseController
{
  protected $stockTransferRepository;
  protected $productRepository;
  
  public function __construct(StockTransferRepository $stockTransferRepository, ProductRepository $productRepository){
    $this->stockTransferRepository =  $stockTransferRepository;
    $this->productRepository =  $productRepository;
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_transfers = $this->stockTransferRepository->listAllStockTransferWithSourceDestination()->toArray();

        $this->setPageTitle('Stock Transfers', 'Stock Transfers Lists');

        return view('admin.stocktransfers.index', compact('stock_transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_transfer = new StockTransfer();
        
        $products = $this->productRepository->listAllProduct('name', 'asc', ['*']);

        $locations = Location::whereStatus('Active')->get()->pluck('name', 'id')->toArray();

        $this->setPageTitle('Stock Transfer', 'Add New Stock Transfer');

        $contexts = [
          'stock_transfer' => $stock_transfer,
          'products'       => $products,
          'locations'      => $locations,
          'transferToLocations' => array()
        ];

        return view('admin.stocktransfers.create', $contexts); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockTransferRequest $request)
    {
      $collection = $request->except('_token','products','product_id','quantity');
      DB::beginTransaction();
      $stockTransfer = $this->stockTransferRepository->createStockTransfer($collection);
      $stockTransferId = $stockTransfer->id;
      $collectionObjects = $request->only('product_id','quantity');
      foreach($request->product_id as $index => $added_item){
        $qty = $request->quantity[$index];
        StockTransferDetail::create([
          'stock_transfer_id' => $stockTransferId,
          'product_id' => $added_item,
          'quantity' => $qty,
        ]);        
      }
      DB::commit();

      if(!$stockTransfer){
        return $this->responseRedirectBack('Error occurred while adding Stock Transfer.', 'error', true, true);
      }

      return $this->responseRedirect('admin.stock-transfers.index', 'Stock Transfer added successfully.', 'success', false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StockTransfer  $stock_transfer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $stock_transfer = $this->stockTransferRepository->findStockTransferWithStockTransferDetailById($id);

      $this->setPageTitle('Stock Transfer', 'Edit Stock Transfer');     
      
      $contexts = [
        'stock_transfer' => $stock_transfer
      ];

      return view('admin.stocktransfers.show', $contexts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockTransfer  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stock_transfer = $this->stockTransferRepository->findStockTransferWithStockTransferDetailById($id);

        $products = $this->productRepository->listAllProduct('name', 'asc', ['*']);

        $locations = Location::whereStatus('Active')->get()->pluck('name', 'id')->toArray();

        $transferToLocations = collect($locations)->filter(function($location, $id) use($stock_transfer){
          return $id!=$stock_transfer->source_location_id;
        })->toArray();

        $this->setPageTitle('Stock Transfer', 'Edit Stock Transfer');     
        
        $contexts = [
          'stock_transfer' => $stock_transfer,
          'products'         => $products,
          'locations'     => $locations,
          'transferToLocations' => $transferToLocations
        ];

        return view('admin.stocktransfers.edit', $contexts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StockTransfer  $stock_transfer
     * @return \Illuminate\Http\Response
     */
    public function update(StockTransferRequest $request, StockTransfer $stock_transfer)
    {

      $collection = $request->except('_token','products','stockTransferDetail','product_id','quantity');
      DB::beginTransaction();
            
      $stockTransfer = $this->stockTransferRepository->updateStockTransfer($collection);
      $collectionObjects = $request->only('quantity');
      
      foreach($request->product_id as $index => $added_item){
        $qty = $request->quantity[$index];
        $existingId = null;
        if($request->has('stockTransferDetail')){
          if(array_key_exists($index, $request->stockTransferDetail)){
            $existingId = $request->stockTransferDetail[$index];
          }
        }
        StockTransferDetail::updateorCreate( ['id' => $existingId] ,[
          'stock_transfer_id' => $stock_transfer->id,
          'product_id' => $added_item,
          'quantity' => $qty
        ]);        
      }
      DB::commit();

      return $this->responseRedirect('admin.stock-transfers.index', 'Stock Transfer updated successfully.', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $supplier = $this->stockTransferRepository->deleteStockTransfer($id);

      return $this->responseRedirect('admin.stock-transfers.index', 'Stock Transfer deleted successfully.', 'success', false, false);
      
    }

    public function deleteStockTransferDetail(Request $request)
    {
      StockTransferDetail::find($request->id)->delete();
      return response()->json([
        'message' => 'Deleted Successfully'
      ], 200);
      
    }
}
