<?php namespace App\Models;

use App\Models\AppBaseModel as AppBaseModel;

class Product extends AppBaseModel
{

	public $table = "products";

	public $primaryKey = "id";

	public $timestamps = true;

    protected $morphClass = 'PRODUCT';


	public $hidden = [];
	public $fillable = [
	    "store_id",
		"product_category_id",
		"name",
		"description",
		"price",
		"uom_id"
	];

	public static $rules = [
	    "store_id" => "required|exists:stores,id",
		"product_category_id" => "required|exists:product_categories,id",
		"name" => "required|max:255",
		"price" => "required|numeric",
		"uom_id" => "required|exists:uoms,id",
		"images" => "isImageListUpload|max:10000",
	];
	/**
	* relations
	*/
	public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory','product_category_id','id');
    }
	public function uom()
    {
        return $this->belongsTo('App\Models\Uom','uom_id','id');
    }
	public function store()
    {
        return $this->belongsTo('App\Models\Store','store_id','id');
    }
    public function mediaList()
    {
        return $this->morphMany('App\Models\Media', 'reference');
    }

    public static function withRelation(){
    	return self::with([
		  		'category' => function($query)
				{
				    $query->select('id','name');
				},
				'store' => function($query)
				{
				    $query->with(['mediaList' => function($query)
    					{
    						$query->select('id', 'reference_id','path', 'reference_type');
    					}])->select('id','name');
				},
				'uom' => function($query)
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
        // delete the product
        return parent::delete();
    }
}
