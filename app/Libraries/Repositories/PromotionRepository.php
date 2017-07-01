<?php

namespace App\Libraries\Repositories;


use App\Models\Promotion;
use Illuminate\Support\Facades\Schema;

class PromotionRepository
{

	/**
	 * Returns all Promotions
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Promotion::all();
	}

	public function search($input)
    {
        $query = Promotion::withRelation();

        $columns = Schema::getColumnListing('promotions');
        $attributes = array();

        foreach($columns as $attribute){
            if(!empty($input[$attribute]))
            {
                $query->where($attribute, $input[$attribute]);
                $attributes[$attribute] =  $input[$attribute];
            }else{
                $attributes[$attribute] =  null;
            }
        };

        return [$query, $attributes];

    }

	/**
	 * Stores Promotion into database
	 *
	 * @param array $input
	 *
	 * @return Promotion
	 */
	public function store($input)
	{
		$Promotion = Promotion::create($input);
		$fileList = $input['images'];
		if (!empty($fileList) 
			&& count($fileList) > 0
			&& !empty($fileList[0])) {
			$mediaRepo = new MediaRepository();
        	$media = $mediaRepo->uploadFiles($Promotion->id, 'PROMOTION',$fileList);
		}
		return $Promotion;
	}

	/**
	 * Find Promotion by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Promotion
	 */
	public function findPromotionById($id)
	{
		return Promotion::withRelation()->find($id);
	}

	/**
	 * Updates Promotion into database
	 *
	 * @param Promotion $promotion
	 * @param array $input
	 *
	 * @return Promotion
	 */
	public function update($promotion, $input)
	{
		$promotion->fill($input);
		if (!empty($input['images']) 
			&& count($input['images']) > 0 
			&& !empty($input['images'][0])) {
			$fileList = $input['images'];
			$mediaRepo = new MediaRepository();
        	$mediaRepo->uploadFiles($promotion->id, 'PROMOTION',$fileList);
		}
		$promotion->save();

		return $promotion;
	}
}