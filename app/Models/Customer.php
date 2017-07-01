<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;

class Customer extends AppBaseModel
{

	public $table = "customers";

	public $primaryKey = "id";

    protected $morphClass = 'CUSTOMER';

	public $timestamps = true;

	public $fillable = [
	    "name",
		"phone_no"
	];

	public static $rules = [
	    "name" => "required|max:15",
		"phone_no" => "required|unique:customers,phone_no,{id}|max:15"
	];
	
	protected $appends = ['access_token'];

	public function getAccessTokenAttribute($value)
    {
        return md5($value);
    }
	/**
	* relations
	*/
	public function addressList()
    {
        return $this->morphMany('App\Models\Address', 'reference');
    }

	public function orderList()
	{
		return $this->hasMany('App\Models\Order','customer_id','id');
	}

    public static function withRelation(){
    	return self::with([
	  		'addressList' => function($query)
			{
			    $query->select('id', 'reference_id', 'address1', 'address2', 'city', 'state', 'country','pincode', 'lat', 'long');
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
		// delete all related orders
		$this->orderList()->delete();
		// delete the store
		return parent::delete();
	}
}
