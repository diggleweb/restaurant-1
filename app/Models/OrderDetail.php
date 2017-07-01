<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;

class OrderDetail extends AppBaseModel
{

	public $table = "order_details";

	public $primaryKey = "id";

	public $timestamps = true;

	public $fillable = [
	    "order_id",
		"product_id",
		"qty",
		"uom_id",
		"price"
	];

	public static $rules = [
	    "order_id" => "required|exists:orders,id",
		"product_id" => "required|exists:products,id",
		"qty" => "required|numeric",
		"uom_id" => "required|exists:uoms,id",
		"price" => "required|numeric"
	];
	public function order()
    {
        return $this->belongsTo('App\Models\Product','order_id','id');
    }
	public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
	public function uom()
    {
        return $this->belongsTo('App\Models\Uom','uom_id','id');
    }
}
