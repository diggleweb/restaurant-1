<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Order;

class CreateOrderRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		// return Order::$rules;
		$validationRules = Order::$rules;
		if (isset($validationRules['order_ref_id'])) {
			if(is_string($validationRules['order_ref_id'])){
				$id = $this->route('orders');
				// dd($validationRules['order_ref_id']);
				$validationRules['order_ref_id'] = preg_replace('/{id}/', "$id", $validationRules['order_ref_id']);				
			}
		}
		return $validationRules;
	}
}
