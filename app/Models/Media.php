<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;
use Config;

class Media extends AppBaseModel
{

	public $table = "media";

	public $primaryKey = "id";

	public $timestamps = true;

	public $fillable = [
	    "reference_id",
		"reference_type",
		"media_type",
		"path"
	];

	public static $rules = [
	    "reference_id" => "required",
		"reference_type" => "required|in:STORE,PRODUCT,STORE_CATEGORY,PROMOTION",
		"media_type" => "required|max:100",
		"path" => "required|max:255"
	];

	public static $reference_types = ['PRODUCT', 'STORE', 'STORE_CATEGORY','PROMOTION'];
	
	public function getPathAttribute($value)
    {
    	if (empty($this->reference_type)) {
    		return $value;
    	}
    	return asset(Config::get('constant.site.upload_dir.'.strtolower($this->reference_type)).$value);
    }

	public function reference()
    {
        return $this->morphTo('reference', 'reference_type', 'reference_id');
    }
}
