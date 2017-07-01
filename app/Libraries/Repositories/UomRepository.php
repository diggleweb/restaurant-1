<?php

namespace App\Libraries\Repositories;


use App\Models\Uom;
use Illuminate\Support\Facades\Schema;

class UomRepository
{

	/**
	 * Returns all Uoms
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Uom::all();
	}
	
	public function getList($value ,$key = 'id'){
		return Uom::lists($value, $key);
	}
	
	public function search($input)
    {
        $query = Uom::query();

        $columns = Schema::getColumnListing('uoms');
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
	 * Stores Uom into database
	 *
	 * @param array $input
	 *
	 * @return Uom
	 */
	public function store($input)
	{
		return Uom::create($input);
	}

	/**
	 * Find Uom by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Uom
	 */
	public function findUomById($id)
	{
		return Uom::find($id);
	}

	/**
	 * Updates Uom into database
	 *
	 * @param Uom $uom
	 * @param array $input
	 *
	 * @return Uom
	 */
	public function update($uom, $input)
	{
		$uom->fill($input);
		$uom->save();

		return $uom;
	}
}