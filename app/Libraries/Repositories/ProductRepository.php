<?php

namespace App\Libraries\Repositories;


use App\Models\Product;
use Illuminate\Support\Facades\Schema;

use App\Libraries\Repositories\MediaRepository;
use App\Libraries\Repositories\ProductCategoryRepository;
use App\Libraries\Repositories\UomRepository;
use App\Libraries\Repositories\StoreRepository;

class ProductRepository
{

	/**
	 * Returns all Products
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Product::all();
	}

	public function search($input)
    {
        $query = Product::withRelation();

        $columns = Schema::getColumnListing('products');
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

        return [$query->orderBy('updated_at', 'desc'), $attributes];

    }
	public function fullTextSearch($input)
    {
    	$query = Product::withRelation()
	    	->leftJoin('product_categories','products.product_category_id' ,'=', "product_categories.id")
	    	->leftJoin('stores','products.store_id' ,'=', "stores.id")
	    	->select(
				"products.id",
				"products.name",
				"products.store_id",
				"products.product_category_id"
			);
		    if (!empty($input["searchTerm"])) {
		    	$query->where(function($query) use ($input){
			    	$query->orWhere('products.name','like' ,'%'.$input["searchTerm"].'%');
			    	$query->orWhere('product_categories.name','like' ,'%'.$input["searchTerm"].'%');
			    	$query->orWhere('stores.name','like' ,'%'.$input["searchTerm"].'%');

		    	});
		    }
		    if (!empty($input["category"])) {
		    	$query->where('product_categories.name','like' ,'%'.$input["category"].'%');
		    }
		    if (!empty($input["store"])) {
		    	$query->where('stores.name','like' ,'%'.$input["store"].'%');
		    }
		    return $query;
    }

	/**
	 * Stores Product into database
	 *
	 * @param array $input
	 *
	 * @return Product
	 */
	public function store($input)
	{
		$product = Product::create($input);
		$fileList = !empty($input['images']) ? $input['images'] : null;


		if (!empty($fileList) 
			&& count($fileList) > 0
			&& !empty($fileList[0]) ) {
			$mediaRepo = new MediaRepository();
        	$media = $mediaRepo->uploadFiles($product->id, 'PRODUCT',$fileList);
        	// dd($media);
		}
		$this->push($product->id, $product->name);
		return $product;
	}

	public function push(int $product_id, string $product_name)
	{
		$curl = curl_init();
		$push_data = [
			"profile" => env("PUSH_API_PROFILE"),
			"send_to_all" => true,
			"priority" => 2,
			"content-available" => 1,
			"notification" => [
				"title" => "New Food",
				"message" => "A new food - $product_name ready to order",
				"payload" => [
					"product_id" => $product_id
				]
			]
		];
		curl_setopt_array(
			$curl, [
				CURLOPT_URL => env("PUSH_API_ENDPOINT"),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($push_data),
				CURLOPT_HTTPHEADER => [
					"authorization: Bearer " . env("PUSH_API_TOKEN"),
					"cache-control: no-cache",
					"content-type: application/json",
				],
			]
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}

	/**
	 * Find Product by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Product
	 */
	public function findProductById($id)
	{
		// return Product::find($id);
		return Product::withRelation()->find($id);

	}

	/**
	 * Updates Product into database
	 *
	 * @param Product $product
	 * @param array $input
	 *
	 * @return Product
	 */
	public function update($product, $input)
	{
		$product->fill($input);
		if (!empty($input['images']) 
			&& count($input['images']) > 0 
			&& !empty($input['images'][0])) {
			$fileList = $input['images'];
			$mediaRepo = new MediaRepository();
        	$mediaRepo->uploadFiles($product->id, 'PRODUCT',$fileList);
		}
		$product->save();

		return $product;
	}
	public function bulkInsert($data){
		$productCategoryRepo = new ProductCategoryRepository();
		$uomRepo = new UomRepository();
		$storeCategoryRepo = new StoreRepository();
		$productCategoryList = $productCategoryRepo->getList( 'name','id' );
		$uomList = $uomRepo->getList( 'name','id' );
		$storeList = $storeCategoryRepo->getList( 'name','id' );
		foreach ($data as $key => $value) {
			foreach ($storeList as $key1 => $value1) {
				if (trim($value1) == trim($value['store'])) {
					$store_id =  $key1;
					break;
				}
			}
			foreach ($productCategoryList as $key1 => $value1) {
				if (trim($value1) == trim($value['category'])) {
					$product_category_id =  $key1;
					break;
				}
			}
			foreach ($uomList as $key1 => $value1) {
				if (trim($value1) == trim($value['uom'])) {
					$uom_id =  $key1;
					break;
				}
			}
			if (empty($store_id) 
				|| empty($product_category_id) 
				|| empty($uom_id) 
				|| empty($value['name'])) {
				continue;
			}
			$product_data[$key]["store_id"] = $store_id;
			$product_data[$key]["product_category_id"] = $product_category_id;
			$product_data[$key]["uom_id"] = $uom_id;
			$product_data[$key]["description"] = $value['description'];
			$product_data[$key]["name"] = $value['name'];
			$product_data[$key]["price"] = $value['price'];
		}
		return Product::insert($product_data);
	}
}