<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Http\Traits\FileUpload;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderDetail;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PurchaseOrderRequest;
use App\Http\Repositories\Admin\ProductRepository;
use App\Http\Repositories\Admin\SupplierRepository;
use App\Http\Repositories\Admin\PurchaseOrderRepository;

class PurchaseOrderController extends BaseController
{
  protected $purchaseOrderRepository;
  protected $productRepository;
  protected $supplierRepository;
  
  public function __construct(PurchaseOrderRepository $purchaseOrderRepository, ProductRepository $productRepository, SupplierRepository $supplierRepository){
    $this->purchaseOrderRepository =  $purchaseOrderRepository;
    $this->productRepository =  $productRepository;
    $this->supplierRepository =  $supplierRepository;
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase_orders = $this->purchaseOrderRepository->listAllPurchaseOrderWithSupplier()->toArray();

        $this->setPageTitle('Purchase Orders', 'Purchase Orders Lists');

        return view('admin.purchaseorders.index', compact('purchase_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchase_order = new PurchaseOrder();
        
        $products = $this->productRepository->listAllProduct('name', 'asc', ['*']);

        $suppliers = $this->supplierRepository->listAllSupplier('name', 'asc', ['name', 'id'])->pluck('name', 'id')->toArray();
        
        $this->setPageTitle('Purchase Order', 'Add New Purchase Order');

        $contexts = [
          'purchase_order' => $purchase_order,
          'products'         => $products,
          'suppliers'     => $suppliers
        ];

        return view('admin.purchaseorders.create', $contexts); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderRequest $request)
    {
      $collection = $request->except('_token','products','product_id','quantity','price','tax_percent','tax_amount','amount');
      $collection['invoice_code'] = 'PO-'.time();
      DB::beginTransaction();
      $purchaseOrder = $this->purchaseOrderRepository->createPurchaseOrder($collection);
      $purchaseOrderId = $purchaseOrder->id;
      $collectionObjects = $request->only('product_id','quantity','price','tax_percent','tax_amount','amount');
      foreach($request->product_id as $index => $added_item){
        $qty = $request->quantity[$index];
        $price = $request->price[$index];
        $tax_percent = $request->tax_percent[$index];
        $tax_amount = $request->tax_amount[$index];
        $amount = $request->amount[$index];
        PurchaseOrderDetail::create([
          'purchase_order_id' => $purchaseOrderId,
          'product_id' => $added_item,
          'quantity' => $qty,
          'price' => $price,
          'tax_percent' => $tax_percent,
          'tax_amount' => $tax_amount,
          'amount' => $amount
        ]);        
      }
      DB::commit();

      if(!$purchaseOrder){
        return $this->responseRedirectBack('Error occurred while adding Purchase Order.', 'error', true, true);
      }

      return $this->responseRedirect('admin.purchase-orders.index', 'Purchase  Order added successfully.', 'success', false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchase_order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $purchase_order = $this->purchaseOrderRepository->findPurchaseOrderWithPurchaseDetailById($id);

      $this->setPageTitle('Purchase Order', 'Purchase Order Detail');     
      
      $contexts = [
        'purchase_order' => $purchase_order,
      ];

      return view('admin.purchaseorders.show', $contexts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseOrder  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase_order = $this->purchaseOrderRepository->findPurchaseOrderWithPurchaseDetailById($id);

        $products = $this->productRepository->listAllProduct('name', 'asc', ['*']);

        $suppliers = $this->supplierRepository->listAllSupplier('name', 'asc', ['name', 'id'])->pluck('name', 'id')->toArray();
        
        $this->setPageTitle('Purchase Order', 'Edit Purchase Order');     
        
        $contexts = [
          'purchase_order' => $purchase_order,
          'products'         => $products,
          'suppliers'     => $suppliers
        ];

        return view('admin.purchaseorders.edit', $contexts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseOrder  $purchase_order
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrderRequest $request, PurchaseOrder $purchase_order)
    {

      $collection = $request->except('_token','products', 'purchaseOrderDetail','product_id', 'quantity','price','tax_percent','tax_amount','amount');
      $collection['invoice_code'] = $purchase_order->invoice_code;
      DB::beginTransaction();
            
      $purchaseOrder = $this->purchaseOrderRepository->updatePurchaseOrder($collection);
      $collectionObjects = $request->only('product_id','quantity','price','tax_percent','tax_amount','amount');
      
      foreach($request->product_id as $index => $added_item){
        $qty = $request->quantity[$index];
        $price = $request->price[$index];
        $tax_percent = $request->tax_percent[$index];
        $tax_amount = $request->tax_amount[$index];
        $amount = $request->amount[$index];
        $existingId = null;
        if($request->has('purchaseOrderDetail')){
          if(array_key_exists($index, $request->purchaseOrderDetail)){
            $existingId = $request->purchaseOrderDetail[$index];
          }
        }
        PurchaseOrderDetail::updateorCreate( ['id' => $existingId] ,[
          'purchase_order_id' => $purchase_order->id,
          'product_id' => $added_item,
          'quantity' => $qty,
          'price' => $price,
          'tax_percent' => $tax_percent,
          'tax_amount' => $tax_amount,
          'amount' => $amount
        ]);        
      }
      DB::commit();

      return $this->responseRedirect('admin.purchase-orders.index', 'Purchase Order updated successfully.', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $supplier = $this->purchaseOrderRepository->deletePurchaseOrder($id);

      return $this->responseRedirect('admin.purchase-orders.index', 'Purchase Order deleted successfully.', 'success', false, false);
      
    }

    public function deletePurchaseOrderDetail(Request $request)
    {
      PurchaseOrderDetail::find($request->id)->delete();
      return response()->json([
        'message' => 'Deleted Successfully'
      ], 200);
      
    }
}
