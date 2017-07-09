<?php

namespace App\Libraries\Repositories;


use App\Models\OrderDetail;
use Illuminate\Support\Facades\Schema;

class OrderDetailRepository
{

	/**
	 * Returns all OrderDetails
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return OrderDetail::all();
	}

	public function search($input)
    {
        $query = OrderDetail::query();

        $columns = Schema::getColumnListing('order_details');
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
	 * Stores OrderDetail into database
	 *
	 * @param array $input
	 *
	 * @return OrderDetail
	 */
	public function store($input)
	{
		return OrderDetail::create($input);
	}

	/**
	 * Stores OrderDetails into database
	 *
	 * @param array $input
	 *
	 * @return OrderDetail
	 */
	public function saveOrderDetails($order_id, $orderDetails)
	{
 		if (empty($order_id)) {
			throw new InvalidArgumentException("Invalid reference id");
		}
		$upCount = 0;
		$inCount = 0;
		foreach ($orderDetails as $key => $orderDetail) {

            $orderDetails[$key]['order_id'] = $order_id;
            $orderDetails[$key]['created_at'] = date('Y-m-d H:i:s');
            $orderDetails[$key]['updated_at'] = date('Y-m-d H:i:s');
            
            if (isset($orderDetails[$key]['id']) 
            	&& !empty($orderDetails[$key]['id'])) {
            	OrderDetail::where('id', $orderDetails[$key]['id'])
            		->update($orderDetails[$key]);
        		unset($orderDetails[$key]);
            	$upCount++;
            }
		}
		// dd(count($orderDetails));
		if (count($orderDetails) > 0) {
			OrderDetail::insert($orderDetails);
			$inCount++;
		}
		if($upCount > 0 || $inCount > 0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Find OrderDetail by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|OrderDetail
	 */
	public function findOrderDetailById($id)
	{
		return OrderDetail::find($id);
	}

	/**
	 * Updates OrderDetail into database
	 *
	 * @param OrderDetail $orderDetail
	 * @param array $input
	 *
	 * @return OrderDetail
	 */
	public function update($orderDetail, $input)
	{
		$orderDetail->fill($input);
		$orderDetail->save();

		return $orderDetail;
	}
}