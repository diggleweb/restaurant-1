<?php

namespace App\Libraries\Repositories;


use App\Models\ProductCategory;
use Illuminate\Support\Facades\Schema;

class ProductCategoryRepository
{

	/**
	 * Returns all ProductCategories
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return ProductCategory::all();
	}
	
	public function getList($value ,$key = 'id'){
		return ProductCategory::lists($value, $key);
	}
	
	public function search($input)
    {
        // $query = ProductCategory::query();
        $query = ProductCategory::with('productsCount');

        $columns = Schema::getColumnListing('product_categories');
        $attributes = array();

        foreach($columns as $attribute){
            if(!empty($input[$attribute]))
            {
                $input[$attribute] = trim(strip_tags($input[$attribute]));
            	if (in_array($attribute, ['name'])) {
            		$query->where($attribute,'like' ,'%'.$input[$attribute].'%');
            	}else{
                	$query->where($attribute, $input[$attribute]);
            	}
                $attributes[$attribute] =  $input[$attribute];
            }else{
                $attributes[$attribute] =  null;
            }
        };

        return [$query, $attributes];

    }

	/**
	 * Stores ProductCategory into database
	 *
	 * @param array $input
	 *
	 * @return ProductCategory
	 */
	public function store($input)
	{
		return ProductCategory::create($input);
	}

	/**
	 * Find ProductCategory by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|ProductCategory
	 */
	public function findProductCategoryById($id)
	{
		return ProductCategory::find($id);
	}

	/**
	 * Updates ProductCategory into database
	 *
	 * @param ProductCategory $productCategory
	 * @param array $input
	 *
	 * @return ProductCategory
	 */
	public function update($productCategory, $input)
	{
		$productCategory->fill($input);
		$productCategory->save();

		return $productCategory;
	}
}