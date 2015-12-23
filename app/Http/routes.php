<?php


Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['web']], function () {
    //
});


Route::get('vendors/',function (){
	$vendors = App\Vendor::all();
	return view('vendor.vendor')->with('vendors', $vendors);
});

Route::get('vendors/create',function (){
	return view('vendor.create');
});

Route::get('vendors/edit/{id}',function ($id){

	$vendor = App\Vendor::find($id);
	return view('vendor.edit')->with("vendor",$vendor);

});


Route::get('/api/brands',function (){

	return App\Brand::all();
});

Route::get('/api/categories',function (){

	return App\Category::all();
});




Route::post('/api/vendor',function (){

	$request = Request::json();

	$name = $request->get('name');
	$address = $request->get('address');
	$brands= $request->get('brands');
	$categories = $request->get('categories');

	DB::beginTransaction();
	try{
		$vendor = App\Vendor::create([
			'name'=> $name,
			'address'=> $address
		]);
		$vendor->brands()->attach($brands);
		$vendor->categories()->attach($categories);

		DB::commit();
	}catch(Exception $e){
		DB::rollback();
	}
});


Route::put('api/vendor/{id}',function ($id){

	$vendor= App\Vendor::find($id);
	$request = Request::json();
	$name = $request->get('name');
	$address = $request->get('address');
	$brands= $request->get('brands');
	$categories = $request->get('categories');

	DB::beginTransaction();
	try{
		$vendor->name = $name;
		$vendor->address=$address;
		$vendor->save();
		$vendor->brands()->sync($brands);
		$vendor->categories()->sync($categories);
		DB::commit();
	}catch(Exception $e){
		DB::rollback();
	}
});