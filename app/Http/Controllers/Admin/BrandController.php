<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\BrandRequest;
use App\Http\Repositories\Admin\BrandRepository;

class BrandController extends BaseController
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brandRepository->listAllBrand();

        $this->setPageTitle('Brands', 'List of all brands');
        
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = new Brand;

        $this->setPageTitle('Brands', 'Create Brands');
        
        return view('admin.brands.create', compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $params = $request->except('_token');

        $brand = $this->brandRepository->createBrand($params);

        if (!$brand) {
          return $this->responseRedirectBack('Error occurred while creating brand.', 'error', true, true);
        }
        return $this->responseRedirect('admin.brands.index', 'Brand added successfully.' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = $this->brandRepository->findBrandById($id);

        $this->setPageTitle('Brands', $brand->name);

        dd($brand);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = $this->brandRepository->findBrandById($id);

        $this->setPageTitle('Brands', $brand->name);
        
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = $this->brandRepository->updateBrand($request->toArray());

        return $this->responseRedirect('admin.brands.index', 'Brand updated successfully.' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = $this->brandRepository->deleteBrand($id);

        return $this->responseRedirect('admin.brands.index', 'Brand deleted successfully.', 'success', false, false);

    }
}
