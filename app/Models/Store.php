<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;
use DB;

class Store extends AppBaseModel
{

	public $table = "stores";

	public $primaryKey = "id";

	public $timestamps = true;

	protected $morphClass = 'STORE';

	public $fillable = [
		"store_category_id",
		"name",
		"description",
		"start_time",
		"end_time",
		"delivery_time",
		"tax",
		"vat"
	];

	public static $rules = [
		"store_category_id" => "required|exists:store_categories,id",
		"name" => "required|max:255",
		"start_time" => "date_format:h:i a",
		"end_time" => "date_format:h:i a",
		"delivery_time" => "integer",
		"tax" => "numeric",
		"vat" => "numeric",
		"images" => "isImageListUpload|max:10000"
	];

	/**
	* Accessors & Mutators
	*/

	public function getTaxAttribute($value)
	{
		return number_format($value, 2, '.', ',');
	}
	public function getVatAttribute($value)
	{
		return number_format($value, 2, '.', ',');
	}
	
	public function getStartTimeAttribute($value)
	{
		return date_format(date_create($value), 'h:i a');
	}
	public function setStartTimeAttribute($value)
	{
		$this->attributes['start_time'] = date_format(date_create($value), 'H:i:s');
	}

	public function getEndTimeAttribute($value)
	{
		return date_format(date_create($value), 'h:i a');
	}
	public function setEndTimeAttribute($value)
	{
		$this->attributes['end_time'] = date_format(date_create($value), 'H:i:s');
	}
	/*public function getDeliveryTimeAttribute($value)
	{
		return gmdate("H : i", floor($value*60));
	}*/

	/**
	* relations
	*/
	public function category()
	{
		return $this->belongsTo('App\Models\StoreCategory','store_category_id','id');
	}

	public function addressList()
	{
		return $this->morphMany('App\Models\Address', 'reference');
	}

	public function mediaList()
	{
		return $this->morphMany('App\Models\Media', 'reference');
	}

	public function productList()
	{
		return $this->hasMany('App\Models\Product','store_id','id');
	}

	public static function withRelation(){
		return self::with([
				'addressList' => function($query)
				{
					$query->select('id', 'reference_id', 'address1', 'address2', 'city', 'state', 'country','pincode', 'lat', 'long');
				},
				'category' => function($query)
				{
					$query->select('id','name');
				},
				'mediaList' => function($query)
				{
					$query->select('id', 'reference_id','path', 'reference_type');
				}
			]);
	}

	public static function nearbyLocation($lat = 0.0, $long = 0.0){
		$orderBy = '111.1111 * DEGREES( ACOS( 
        	COS( RADIANS( addresses.lat ) ) 
        	* COS( RADIANS( ? ) ) 
        	* COS( RADIANS( addresses.long - ? ) ) 
        	+ SIN( RADIANS( addresses.lat ) ) 
        	* SIN( RADIANS( ? ) ) 
        	) ) ';
        return self::
        leftJoin('addresses', function($join)
        {
            $join->on('stores.id', '=', 'addresses.reference_id')
            ->where('addresses.reference_type', '=', 'STORE');
        })
        ->select('stores.*')
        ->orderByRaw($orderBy . " ASC", array($lat,$long,$lat))
        ->with([
				'addressList' => function($query)
				{
					$query->select('id', 'reference_id', 'address1', 'address2', 'city', 'state', 'country','pincode', 'lat', 'long');
				},
				'category' => function($query)
				{
					$query->select('id','name');
				},
				'mediaList' => function($query)
				{
					$query->select('id', 'reference_id','path', 'reference_type');
				}
			]);
	}
	/**
	* override default methodes
	*/
	public function delete()
	{
		// delete all related media 
		$this->mediaList()->delete();
		// delete all related address 
		$this->addressList()->delete();
		// delete all related products
		$this->productList()->delete();
		// delete the store
		return parent::delete();
	}

}
