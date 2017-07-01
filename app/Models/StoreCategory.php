<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;

class StoreCategory extends AppBaseModel
{

	public $table = "store_categories";

	public $primaryKey = "id";

	public $timestamps = true;

	protected $morphClass = 'STORE_CATEGORY';

	public $fillable = [
		"name",
		"display_mode"
	];

	public static $rules = [
		"name" => "required",
		"display_mode" => "required|in:STORE,PRODUCT",
		"images" => "isImageListUpload|max:10000"
	];

	public function storeList()
	{
		return $this->hasMany('App\Models\Store','store_category_id','id');
	}

	public function mediaList()
	{
		return $this->morphMany('App\Models\Media', 'reference');
	}

	public static function withRelation(){
		return self::with([
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
		// delete the stores
		$this->storeList()->delete();
		// delete the store category
		return parent::delete();
	}
}
