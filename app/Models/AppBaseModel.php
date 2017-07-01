<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AppBaseModel extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

	public $timestamps = true;

	protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}