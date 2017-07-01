<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;

class Uom extends AppBaseModel
{

	public $table = "uoms";

	public $primaryKey = "id";

	public $timestamps = true;

	public $fillable = [
	    "name"
	];

	public static $rules = [
	    "name" => "required"
	];

}
