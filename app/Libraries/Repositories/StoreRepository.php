<?php

namespace App\Libraries\Repositories;

use App\Models\Store;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Schema;
use App\Libraries\Repositories\MediaRepository;
use App\Libraries\Repositories\AddressRepository;

class StoreRepository
{
	private $store_id_for_product_list =null;
	/**
	 * Returns all Stores
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		// return Store::all();
		
	}
	
	public function getList($value ,$key = 'id'){
		return Store::lists($value, $key);
	}

	public function search($input)
    {
    	$lat = !empty($input['lat'])?$input['lat']:0.0;
    	$long = !empty($input['long'])?$input['long']:0.0;
    	$query = Store::nearbyLocation($lat,$long);
        $columns = Schema::getColumnListing('stores');
        $attributes = array();
        foreach($columns as $attribute){
            if(!empty($input[$attribute]))
            {
            	$input[$attribute] = trim(strip_tags($input[$attribute]));
            	if (in_array($attribute, ['name','description'])) {
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
	 * Stores Store into database
	 *
	 * @param array $input
	 *
	 * @return Store
	 */
	public function store($input)
	{
		$store = Store::create($input);
		$fileList = $input['images'];
		if (!empty($fileList) 
			&& count($fileList) > 0
			&& !empty($fileList[0])) {
			$mediaRepo = new MediaRepository();
        	$media = $mediaRepo->uploadFiles($store->id, 'STORE',$fileList);
		}
		if (count($input['address']>0)) {
			$addressRepo = new AddressRepository();
			$media = $addressRepo->saveAddresses($store->id, 'STORE',$input['address']);
		}
		return $store;
	}

	/**
	 * Find Store by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Store
	 */
	public function findStoreById($id)
	{
		return Store::withRelation()->find($id);
		// return Store::find($id);
	}

	/**
	 * Updates Store into database
	 *
	 * @param Store $store
	 * @param array $input
	 *
	 * @return Store
	 */
	public function update($store, $input)
	{
		$store->fill($input);
		if (!empty($input['images']) 
			&& count($input['images']) > 0 
			&& !empty($input['images'][0])) {
			$fileList = $input['images'];
			$mediaRepo = new MediaRepository();
        	$mediaRepo->uploadFiles($store->id, 'STORE',$fileList);
		}
		if (count($input['address']>0)) {
			$addressRepo = new AddressRepository();
			$addressRepo->saveAddresses($store->id, 'STORE',$input['address']);
		}
		$store->save();

		return $store;
	}

	/**
	 * Updates Store into database
	 *
	 * @param array $fileList
	 *
	 * @return Media
	 */
	public function storeImages($fileList)
	{
		
	}
}