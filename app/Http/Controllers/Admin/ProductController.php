<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\FileUpload;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Repositories\Admin\BrandRepository;
use App\Http\Repositories\Admin\ProductRepository;
use App\Http\Repositories\Admin\CategoryRepository;

class ProductController extends BaseController
{
  use FileUpload;
  protected $productRepository;
  protected $brandRepository;
  protected $categoryRepository;
  
  public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository, CategoryRepository $categoryRepository){
    $this->productRepository =  $productRepository;
    $this->brandRepository =  $brandRepository;
    $this->categoryRepository =  $categoryRepository;
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->listAllProductWithBrandAndCategory()->toArray();

        $this->setPageTitle('Products', 'Products Lists');

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();

        $brands = $this->brandRepository->listAllBrand('name', 'asc', ['name', 'id'])->pluck('name', 'id')->toArray();

        $categories = $this->categoryRepository->listAllCategory('name', 'asc', ['name', 'id'])->pluck('name', 'id')->toArray();
        
        $this->setPageTitle('Products', 'Create Products');

        $contexts = [
          'brands' => $brands,
          'categories' => $categories,
          'product' => $product
        ];

        return view('admin.products.create', $contexts); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

      $collection = $request->except('_token', 'category_id', 'image_file');
      $images = !empty($request->only('image_file'))?$request->only('image_file')['image_file']:array();
      $categories = $request->category_id;
      DB::beginTransaction();
      $product = $this->productRepository->createProduct($collection);
      if($product){
        $product->category()->attach($categories);
        DB::commit();
        if(!empty($images)){
          foreach($images as $image){
            $size = $image->getSize();
            $filename = time().$image->getClientOriginalName();
            $image_upload = $this->upload($image, $filename, 'public', '/products');
            $save_image = $this->productRepository->saveImage($image_upload, $filename, $product->id, $size);
          }
        }
      }

      if(!$product){
        return $this->responseRedirectBack('Error occurred while creating product.', 'error', true, true);
      }

      return $this->responseRedirect('admin.products.index', 'Product added successfully.', 'success', false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->findProductById($id);

        $category_id = $product->category->pluck('id')->toArray();

        $images = $product->image()->get(['name', 'id', 'src']);

        $brands = $this->brandRepository->listAllBrand('name', 'asc', ['name', 'id'])->pluck('name', 'id')->toArray();

        $categories = $this->categoryRepository->listAllCategory('name', 'asc', ['name', 'id'])->pluck('name', 'id')->toArray();
        
        $this->setPageTitle('Products', 'Edit Products');

        $contexts = [
          'brands' => $brands,
          'categories' => $categories,
          'category_id' => $category_id,
          'images' => $images,
          'product' => $product
        ];
        
        return view('admin.products.edit', $contexts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
      $collection = $request->except('_token', 'category_id', 'image_file', 'files');
      $images = $request->only('image_file')?$request->only('image_file')['image_file']:null;
      $categories = $request->category_id;
      $product = $this->productRepository->updateProduct($collection);
      DB::beginTransaction();

      $product->category()->sync($categories);
      DB::commit();
      if(!empty($images)){
        $product->image()->delete();
        foreach($images as $image){
          $size = $image->getSize();
          $filename = time().$image->getClientOriginalName();
          $image_upload = $this->upload($image, $filename, 'public', '/products');
          $save_image = $this->productRepository->saveImage($image_upload, $filename, $product->id, $size);
        }
      }

      return $this->responseRedirect('admin.products.index', 'Product updated successfully.', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $product = $this->productRepository->deleteProduct($id);

      return $this->responseRedirect('admin.products.index', 'Product deleted successfully.', 'success', false, false);
    }
}
