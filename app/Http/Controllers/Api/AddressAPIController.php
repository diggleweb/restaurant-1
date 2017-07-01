<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Libraries\Repositories\AddressRepository;
use Response;

class AddressAPIController extends AppApiBaseController
{

	/** @var  AddressRepository */
	private $addressRepository;

	function __construct(AddressRepository $addressRepo)
	{
		$this->addressRepository = $addressRepo;
	}

	/**
	 * Display a listing of the Address.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->addressRepository->search($input);

		$addresses = $result[0]->get();

		return Response::json(ResponseManager::makeResult($addresses->toArray(), "Addresses retrieved successfully."));
	}

	/**
	 * Show the form for creating a new Address.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created Address in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Address::$rules) > 0)
            $this->validateRequest($request, Address::$rules);

        $input = $request->all();

		$address = $this->addressRepository->store($input);

		return Response::json(ResponseManager::makeResult($address->toArray(), "Address saved successfully."));
	}

	/**
	 * Display the specified Address.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$address = $this->addressRepository->findAddressById($id);

		if(empty($address))
			$this->throwRecordNotFoundException("Address not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($address->toArray(), "Address retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified Address.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified Address in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$address = $this->addressRepository->findAddressById($id);

		if(empty($address))
			$this->throwRecordNotFoundException("Address not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$address = $this->addressRepository->update($address, $input);

		return Response::json(ResponseManager::makeResult($address->toArray(), "Address updated successfully."));
	}

	/**
	 * Remove the specified Address from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$address = $this->addressRepository->findAddressById($id);

		if(empty($address))
			$this->throwRecordNotFoundException("Address not found", ERROR_CODE_RECORD_NOT_FOUND);

		$address->delete();

		return Response::json(ResponseManager::makeResult($id, "Address deleted successfully."));
	}
}
