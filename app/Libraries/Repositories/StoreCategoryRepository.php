<?php

namespace App\Libraries\Repositories;


use App\Models\StoreCategory;
use App\Models\Store;

use Illuminate\Support\Facades\Schema;
use App\Libraries\Repositories\MediaRepository;

class StoreCategoryRepository
{

	/**
	 * Returns all StoreCategories
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return StoreCategory::all();
	}
	
	public function getList($value ,$key = 'id'){
		return StoreCategory::lists($value, $key);
	}

	public function getListWithStore($value ,$key = 'id'){
		$listWithStore = StoreCategory::with([
			'storeList' => function($query)
			{
			    $query->select('id', 'store_category_id', 'name');
			}])->get()->toArray();
		$list = [];
		foreach ($listWithStore as $value1) {
			foreach ($value1['store_list'] as $value2) {
				$list[$value1['name']][$value2['id']] = $value2['name'];
			}
		}
		return $list;
	}


	public function search($input)
    {
        $query = StoreCategory::withRelation();

        $columns = Schema::getColumnListing('store_categories');

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

	public function getProducts($id)
	{
		return Store::with([
            'productList' => function($query)
            {
                $query->with([
					'uom' => function($query)
					{
					    $query->select('id','name');
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
        ])->where('stores.store_category_id', '=', $id)->get();
	}

	/**
	 * Stores StoreCategory into database
	 *
	 * @param array $input
	 *
	 * @return StoreCategory
	 */
	public function store($input)
	{
		$storeCategory = StoreCategory::create($input);
		$fileList = $input['images'];
		if (!empty($fileList) 
			&& count($fileList) > 0
			&& !empty($fileList[0])) {
			$mediaRepo = new MediaRepository();
        	$media = $mediaRepo->uploadFiles($storeCategory->id, 'STORE_CATEGORY',$fileList);
		}
		return $storeCategory;
	}

	/**
	 * Find StoreCategory by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|StoreCategory
	 */
	public function findStoreCategoryById($id)
	{
		return StoreCategory::withRelation()->find($id);
	}

	/**
	 * Updates StoreCategory into database
	 *
	 * @param StoreCategory $storeCategory
	 * @param array $input
	 *
	 * @return StoreCategory
	 */
	public function update($storeCategory, $input)
	{
		$storeCategory->fill($input);
		if (!empty($input['images']) 
			&& count($input['images']) > 0 
			&& !empty($input['images'][0])) {
			$fileList = $input['images'];
			$mediaRepo = new MediaRepository();
        	$mediaRepo->uploadFiles($storeCategory->id, 'STORE_CATEGORY',$fileList);
		}
		$storeCategory->save();

		return $storeCategory;
	}
}