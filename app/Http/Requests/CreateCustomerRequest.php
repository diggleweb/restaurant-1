<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Customer;
use Request as Req;
class CreateCustomerRequest extends Request {

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
		$validationRules = Customer::$rules;
		if (isset($validationRules['phone_no'])) {
			if(is_string($validationRules['phone_no'])){
				$id = $this->route('customers');
				$validationRules['phone_no'] = preg_replace('/{id}/', "$id", $validationRules['phone_no']);				
			}
		}
		return $validationRules;
	}

}
