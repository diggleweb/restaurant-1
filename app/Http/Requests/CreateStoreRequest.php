<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Store;
use Validator;
use InvalidArgumentException;

class CreateStoreRequest extends Request {

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
		return Store::$rules;
	}

	/*
    public function validator($factory)
    { 
		$v = $factory->make($this->all(), $this->rules()); 
		
		$v->each('images', ['isImageUpload']);
		return $v;
    }
    */
}
