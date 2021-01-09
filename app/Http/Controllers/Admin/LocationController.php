<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class LocationController extends BaseController
{
  public function __construct(){
    
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();

        $this->setPageTitle('Locations', 'Locations Lists');

        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = new Location();

        $this->setPageTitle('Location', 'Add Location');

        $contexts = [
          'location' => $location
        ];

        return view('admin.locations.create', $contexts); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'name' => 'required| unique:locations| max:191',
        'manager' => 'required| max:191',
        'location_code' => 'required| unique:locations',
        'email' => 'nullable| unique:locations',
        'phone_number' => 'nullable| unique:locations',
      ]);

      $collection = $request->except('_token');
      $location = Location::create($collection);
      
      if(!$location){
        return $this->responseRedirectBack('Error occurred while adding location.', 'error', true, true);
      }

      return $this->responseRedirect('admin.locations.index', 'Location added successfully.', 'success', false, false);
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
        $location = Location::findOrFail($id);

        $this->setPageTitle('Location', 'Edit Location');

        $contexts = [
          'location' => $location
        ];

        return view('admin.locations.edit', $contexts); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
      $this->validate($request,[
        'name' => 'required| unique:locations,name,'. $location->id.',id| max:191',
        'manager' => 'required| max:191',
        'location_code' => 'required| unique:locations,name,'. $location->id.',id',
        'email' => 'nullable| unique:locations,name,'. $location->id.',id',
        'phone_number' => 'nullable| unique:locations,name,'. $location->id.',id',
      ]);

      $collection = $request->except('_token');
      $location->update($collection);

      return $this->responseRedirect('admin.locations.index', 'Location updated successfully.', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
      $location->delete();

      return $this->responseRedirect('admin.locations.index', 'Location deleted successfully.', 'success', false, false);
    }
}
