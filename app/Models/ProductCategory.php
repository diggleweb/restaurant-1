<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;

class ProductCategory extends AppBaseModel
{

	public $table = "product_categories";

	public $primaryKey = "id";

	public $timestamps = true;

	public $fillable = [
		"name"
	];

	public static $rules = [
		"name" => "required"
	];

	public function productList()
	{
		return $this->hasMany('App\Models\Product','product_category_id','id');
	}

	public function productsCount()
	{
	  return $this->productList()
	    ->selectRaw('product_category_id, count(*) as count')
	    ->groupBy('product_category_id');
	}
  
	/**
	* override default methodes
	*/
	public function delete()
	{
		// delete the Products
		$this->productList()->delete();
		// delete the Product category
		return parent::delete();
	}
}
