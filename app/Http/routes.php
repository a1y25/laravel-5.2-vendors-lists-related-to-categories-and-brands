<?php


Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['web']], function () {
    //
});


Route::get('vendors',function (){

	return view('vendor');
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
	$brands = $request->get('categories');

	$vendor = App\Vendor::create([
		'name'=> $name,
		'address'=> $address
	]);

	$vendor->brands()->attach($brands);

});
