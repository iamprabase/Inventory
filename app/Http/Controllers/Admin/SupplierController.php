<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Traits\FileUpload;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SupplierRequest;
use App\Http\Repositories\Admin\SupplierRepository;

class SupplierController extends BaseController
{
  use FileUpload;
  protected $supplierRepository;
  
  public function __construct(SupplierRepository $supplierRepository){
    $this->supplierRepository =  $supplierRepository;
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = $this->supplierRepository->listAllSupplier()->toArray();
        
        $this->setPageTitle('Suppliers', 'Suppliers Lists');

        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = new Supplier();

        $this->setPageTitle('Supplier', 'Create Supplier');

        $contexts = [
          'supplier' => $supplier
        ];

        return view('admin.suppliers.create', $contexts); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {

      $collection = $request->except('_token','image_file');
      $image = $request->only('image_file')['image_file'];
      
      if(!empty($image)){
        $size = $image->getSize();
        $filename = time().$image->getClientOriginalName();
        $image_upload = $this->upload($image, $filename, 'public', '/suppliers');
        $collection['image_name'] = $filename;
        $collection['src'] = $image_upload;
        $collection['size'] = $size; 
      }
      $supplier = $this->supplierRepository->createSupplier($collection);
      
      if(!$supplier){
        return $this->responseRedirectBack('Error occurred while adding supplier.', 'error', true, true);
      }

      return $this->responseRedirect('admin.suppliers.index', 'Supplier added successfully.', 'success', false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = $this->supplierRepository->findSupplierById($id);

        $this->setPageTitle('Supplier', 'Edit Supplier');

        $contexts = [
          'supplier' => $supplier
        ];
        
        return view('admin.suppliers.edit', $contexts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
      $collection = $request->except('_token', 'image_file', 'files');
      $image = $request->only('image_file')?$request->only('image_file')['image_file']:null;
      
      if(!empty($image)){
        $size = $image->getSize();
        $filename = time().$image->getClientOriginalName();
        $image_upload = $this->upload($image, $filename, 'public', '/suppliers');
        $collection['image_name'] = $filename;
        $collection['src'] = $image_upload;
        $collection['size'] = $size; 
      }

      $supplier = $this->supplierRepository->updateSupplier($collection);

      return $this->responseRedirect('admin.suppliers.index', 'Supplier updated successfully.', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $supplier = $this->supplierRepository->deleteSupplier($id);

      return $this->responseRedirect('admin.suppliers.index', 'Supplier deleted successfully.', 'success', false, false);
      
    }
}
