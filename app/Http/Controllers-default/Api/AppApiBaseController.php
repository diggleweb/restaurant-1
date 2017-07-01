<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Exception\HttpResponseException;
use Mitul\Generator\Utils\ResponseManager;
use App\Http\Controllers\AppBaseController;

use Response;

abstract class AppApiBaseController extends AppBaseController {

	public function validateRequest($request, $rules)
	{
		$validator = $this->getValidationFactory()->make($request->all(), $rules);

		if($validator->fails())
		{
			$msg = "";

			foreach($validator->errors()->getMessages() as $field => $errorMsg)
			{
				$msg .= $errorMsg[0] . ". ";
			}

			$msg = substr($msg, 0, strlen($msg) - 1);

			throw new HttpResponseException(Response::json(ResponseManager::makeError(ERROR_CODE_VALIDATION_FAILED, $msg)));
		}
	}

	public function throwRecordNotFoundException($message, $code = 0)
	{
		throw new HttpResponseException(Response::json(ResponseManager::makeError($code, $message)));
	}
}
