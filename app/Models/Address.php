<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;

class Address extends AppBaseModel
{

	public $table = "addresses";

	public $primaryKey = "id";

	public $timestamps = true;

	protected $appends = ['full_address'];

	public $fillable = [
	    "reference_id",
		"reference_type",
		"lat",
		"long",
		"address1",
		"address2",
		"city",
		"state",
		"country",
		"pincode"
	];

	// protected $hidden = ['reference_id', 'reference_type','created_at', 'updated_at', 'deleted_at'];

	public static $rules = [
	    "reference_id" => "required",
		"reference_type" => "required|in:CUSTOMER, STORE, ORDER",
		"lat" => "required|numeric",
		"long" => "required|numeric",
		"address1" => "max:255",
		"address2" => "max:255",
		"city" => "max:100",
		"state" => "max:100",
		"country" => "max:100",
		"pincode" => "max:10"
	];

	public static $reference_types = ['CUSTOMER','STORE','ORDER'];

	public function __construct(){
		$this->hidden = array_merge($this->hidden,['reference_id', 'reference_type']);
	}

	public function reference()
    {
        return $this->morphTo('reference', 'reference_type', 'reference_id');
    }
    public function getFullAddressAttribute()
	{
		$full_address = '';
		if (!empty($this->attributes['address1'])) {
			$full_address .= $this->attributes['address1'] .' , ';
		}
		if (!empty($this->attributes['address2'])) {
			$full_address .= $this->attributes['address2'] .'\n';
		}
		if (!empty($this->attributes['city'])) {
			$full_address .= $this->attributes['city'] .'\n';
		}
		if (!empty($this->attributes['state'])) {
			$full_address .= $this->attributes['state'] .' , ';
		}
		if (!empty($this->attributes['pincode'])) {
			$full_address .= 'Pincode:'. $this->attributes['pincode'] .' \n';
		}
		if (!empty($this->attributes['country'])) {
			$full_address .= $this->attributes['country'] ;
		}
		return $full_address;
	}
}
