<?php

namespace App\Libraries\Repositories;


use App\Models\Customer;
use Illuminate\Support\Facades\Schema;
use App\Libraries\Repositories\AddressRepository;

class CustomerRepository
{

	/**
	 * Returns all Customers
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Customer::all();
	}

	public function search($input)
    {
        $query = Customer::withRelation();

        $columns = Schema::getColumnListing('customers');
        $attributes = array();

        foreach($columns as $attribute){
            if(!empty($input[$attribute]))
            {
            	$input[$attribute] = trim(strip_tags($input[$attribute]));
            	if (in_array($attribute, ['name','phone_no'])) {
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
	 * Stores Customer into database
	 *
	 * @param array $input
	 *
	 * @return Customer
	 */
	public function store($input)
	{
		return Customer::create($input);
	}

	/**
	 * Find Customer by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Customer
	 */
	public function findCustomerById($id)
	{
		return Customer::withRelation()->find($id);
		// return Customer::find($id);
	}

	/**
	 * Updates Customer into database
	 *
	 * @param Customer $customer
	 * @param array $input
	 *
	 * @return Customer
	 */
	public function update($customer, $input)
	{
		$customer->fill($input);
		if(!empty($input['lat']) && !empty($input['long'])){
			$addressRepo = new AddressRepository();
			$addressRepo->saveAddressesFromLatLong($customer->id, 'CUSTOMER',$input['lat'], $input['long']);
		}
		$customer->save();
		return $customer;
	}
	
	/**
	 * Customer Login
	 *
	 * @param varchar $phone_no
	 *
	 * @return Customer
	 */
	public function login($phone_no,$name = null)
	{
		// return Customer::firstOrCreate(['phone_no' => $phone_no]);
		$customer = Customer::where('phone_no', '=', $phone_no)->first();
		if(!empty($customer)){
			if ($name != null) {
				$customer->name = $name;
				$customer->save();
			}
		}else{
			$customer = Customer::create(['phone_no' => $phone_no, 'name' => $name]);
		}
		return $customer;
	}
}