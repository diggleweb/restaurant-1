<?php
/**
 * for admin routes
 */
Route::group(['middleware' => ['auth','csrf']], function()
{
	Route::get('home', 'HomeController@index');

	Route::get('user/{id}', 'UserController@showProfile');

	Route::group([ 'prefix' => 'admin', 'namespace' => 'Admin'], function()
	{
		
		Route::get('/', [
		    'as' => 'admin',
		    'uses' => 'StoreController@index',
		]);

		Route::resource('customers', 'CustomerController');
		Route::get('customers/{id}/delete', [
		    'as' => 'admin.customers.delete',
		    'uses' => 'CustomerController@destroy',
		]);

		Route::resource('addresses', 'AddressController');
		Route::get('addresses/{id}/delete', [
		    'as' => 'addresses.delete',
		    'uses' => 'AddressController@destroy',
		]);

		Route::resource('media', 'MediaController');
		Route::get('media/{id}/delete', [
		    'as' => 'admin.media.delete',
		    'uses' => 'MediaController@destroy',
		]);

		Route::resource('stores', 'StoreController');
		Route::get('stores/{id}/delete', [
				'as' => 'admin.stores.delete',
				'uses' => 'StoreController@destroy',
		]);

		Route::resource('storeCategories', 'StoreCategoryController');
		Route::get('storeCategories/{id}/delete', [
				'as' => 'admin.storeCategories.delete',
				'uses' => 'StoreCategoryController@destroy',
		]);
		Route::get('products/{id}/delete', [
		    'as' => 'admin.products.delete',
		    'uses' => 'ProductController@destroy',
		]);
		Route::post('products/upload', [
		    'as' => 'admin.products.upload',
		    'uses' => 'ProductController@upload',
		]);
		Route::get('products/sample-excel-download', [
		    'as' => 'admin.products.sample_excel_download',
		    'uses' => 'ProductController@sample_excel_download',
		]);
		Route::resource('products', 'ProductController');
		Route::resource('productCategories', 'ProductCategoryController');
		Route::get('productCategories/{id}/delete', [
		    'as' => 'admin.productCategories.delete',
		    'uses' => 'ProductCategoryController@destroy',
		]);

		Route::resource('uoms', 'UomController');
		Route::get('uoms/{id}/delete', [
		    'as' => 'admin.uoms.delete',
		    'uses' => 'UomController@destroy',
		]);

		Route::resource('orders', 'OrderController');
		Route::get('orders/{id}/delete', [
		    'as' => 'admin.orders.delete',
		    'uses' => 'OrderController@destroy',
		]);	
		Route::get('orders/check-new/{id}', [
		    'as' => 'admin.orders.check_new',
		    'uses' => 'OrderController@checkNew',
		]);
		Route::resource('promotions', 'PromotionController');

		Route::get('promotions/{id}/delete', [
		    'as' => 'admin.promotions.delete',
		    'uses' => 'PromotionController@destroy',
		]);
	});
});
