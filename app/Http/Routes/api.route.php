<?php
/**
 * for api routes
*/

Route::group([
		'middleware' => ['api'],
		'namespace' => 'Api',
		// 'domain' => '{domainPrefix}.localhost',
		'prefix' => 'api/{version}',
		// 'prefix' => '{version}',
		'where' => ['version' => '^v[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2}'],
		
	], function($route) {
		Route::post('customers/login', [
		    'as' => 'customers.login',
		    'uses' => 'CustomerAPIController@login',
		]);
		Route::resource('customers', 'CustomerAPIController');

		Route::get('stores/getProducts/{id}', [
		    'as' => 'stores.getProducts',
		    'uses' => 'StoreAPIController@getProducts',
		]);
		Route::resource('stores', 'StoreAPIController');

		Route::get('storeCategories/getProducts/{id}', [
		    'as' => 'storeCategories.getProducts',
		    'uses' => 'StoreCategoryAPIController@getProducts',
		]);
		Route::get('fullTextSearch', [
		    'as' => 'products.fullTextSearch',
		    'uses' => 'ProductAPIController@fullTextSearch',
		])
		->where('id', '[0-9]+');
		Route::resource('storeCategories', 'StoreCategoryAPIController');
		Route::resource('productCategories', 'ProductCategoryAPIController');
		Route::resource('products', 'ProductAPIController');
		Route::resource('orders', 'OrderAPIController');
		Route::resource('promotions', 'PromotionAPIController');
		Route::get('delivery-charge-setup', function(){
			return DB::table('delivery_charge_setup')->get();
		});
});