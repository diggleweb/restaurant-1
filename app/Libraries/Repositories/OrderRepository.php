<?php

namespace App\Libraries\Repositories;


use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use App\Libraries\Repositories\OrderDetailRepository;
use App\Libraries\Repositories\AddressRepository;

class OrderRepository
{

	/**
	 * Returns all Orders
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Order::all();
	}

	public function search($input)
    {
        $query = Order::withRelation();

        $columns = Schema::getColumnListing('orders');
        $attributes = array();

        foreach($columns as $attribute){
            if(!empty($input[$attribute]))
            {
            	$input[$attribute] = trim(strip_tags($input[$attribute]));
            	if (in_array($attribute, ['order_ref_id'])) {
            		$query->where($attribute,'like' ,'%'.$input[$attribute].'%');
            	}else{
                	$query->where($attribute, $input[$attribute]);
            	}
                $attributes[$attribute] =  $input[$attribute];
            }else{
                $attributes[$attribute] =  null;
            }
        };

        return [$query->orderBy('created_at', 'desc'), $attributes];

    }

	/**
	 * Stores Order into database
	 *
	 * @param array $input
	 *
	 * @return Order
	 */
	public function store($input)
	{
		$input['order_ref_id'] = $input['customer_id'].'-'.time().'-'.str_random(10);
		$input['order_status'] = 'PENDING';
		$order = Order::create($input);
		if (isset($input['order_detail']) && count($input['order_detail']>0)) {
			$orderDetailRepo = new OrderDetailRepository();
        	$orderDetail = $orderDetailRepo->saveOrderDetails($order->id, $input['order_detail']);
		}
		if (isset($input['address']) && count($input['address']>0)) {
			$addressRepo = new AddressRepository();
			$media = $addressRepo->saveAddresses($order->id, 'ORDER',$input['address']);
		}
		return $order;
	}

	/**
	 * Find Order by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Order
	 */
	public function findOrderById($id)
	{
		// return Order::find($id);
		return Order::withRelation()->find($id);
		// $a = Order::withRelation()->find($id)->toArray();
		// dd($a);
	}

	/**
	 * Updates Order into database
	 *
	 * @param Order $order
	 * @param array $input
	 *
	 * @return Order
	 */
	public function update($order, $input)
	{
		$order->fill($input);
		$order->save();
		if (!empty($input['orderDetail'])
			&& count($input['orderDetail']>0)) {
			$orderDetailRepo = new OrderDetailRepository();
        	$orderDetail = $orderDetailRepo->saveOrderDetails($order->id, $input['orderDetail']);
		}
		if (!empty($input['address'])
			&& count($input['address']>0)) {
			$addressRepo = new AddressRepository();
			$media = $addressRepo->saveAddresses($order->id, 'ORDER',$input['address']);
		}
		return $order;
	}
}