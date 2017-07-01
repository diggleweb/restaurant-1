<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;

class Promotion extends AppBaseModel
{

	public $table = "promotions";

	public $primaryKey = "id";

	public $timestamps = true;

	protected $morphClass = 'PROMOTION';

	public $fillable = [
	    "description"
	];

	public static $rules = [
	    "description" => "required",
	    "images" => "isImageListUpload|max:10000"
	];
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
}
