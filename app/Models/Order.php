<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;
use DB;
use Config;

class Order extends AppBaseModel
{

	public $table = "orders";

	public $primaryKey = "id";

	public $timestamps = true;

    protected $morphClass = 'ORDER';

	public $fillable = [
	    "order_ref_id",
		"customer_id",
		"tax",
		"vat",
		"total_price",
		"remarks",
		"deliver_at",
		"order_status"
	];

	public static $rules = [
	    // "order_ref_id" => "required|unique:orders,order_ref_id,{id}|max:100",
		"customer_id" => "required|exists:customers,id",
		"tax" => "numeric",
		"vat" => "numeric",
		"total_price" => "required|numeric",
		"remarks" => "max:255",
		"deliver_at" => "date_format:Y-m-d h:i:s",
		"order_status" => "in:PENDING,DELIVERED,PROCESSING,CANCELED"
	];
	public function customer()
    {
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }
	public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail','order_id','id');
    }
	public function addressList()
    {
        return $this->morphMany('App\Models\Address', 'reference');
    }
    public static function withRelation(){
		$base_path = asset(Config::get('constant.site.upload_dir.product')) . "/";
    	return self::with([
		  		'addressList' => function($query)
				{
				    $query->select('id', 'reference_id', 'address1', 'address2', 'city', 'state', 'country','pincode');
				},
		  		'orderDetails' => function($query) use($base_path)
				{
				    $query->leftJoin('products', 'order_details.product_id', '=', 'products.id')
						->leftJoin('media', function ($join) {
							$join->on('media.reference_id', '=', 'products.id')->on('media.reference_type', '=', DB::raw("'PRODUCT'"));
						})
				    	->leftJoin('uoms', 'order_details.uom_id', '=', 'uoms.id')
						 ->groupBy('order_details.order_id', 'products.id')
				    	->select('order_details.*', 'products.name as product_name', 'uoms.name as uom')
						->addSelect(DB::raw("CONCAT('$base_path', media.path) as product_image"));
				},
		  		'customer' => function($query)
				{
				    $query->select('id', 'phone_no','name');
				}
			]);
    }	
    /**
	* override default methodes
	*/
	public function delete()
	{
		// delete all related address 
		$this->addressList()->delete();
		// delete all related orderDetails
		$this->orderDetails()->delete();
		// delete the store
		return parent::delete();
	}
}
