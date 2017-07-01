<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Libraries\Repositories\StoreRepository;
use Response;

class StoreAPIController extends AppApiBaseController
{

	/** @var  StoreRepository */
	private $storeRepository;

	function __construct(StoreRepository $storeRepo)
	{
		$this->storeRepository = $storeRepo;
	}

	/**
	 * Display a listing of the Store.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->storeRepository->search($input);

		$stores = $result[0]->get();

		return Response::json(ResponseManager::makeResult($stores->toArray(), "Stores retrieved successfully."));
	}

	/**
	 * Display the specified Store.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$store = $this->storeRepository->findStoreById($id);

		if(empty($store))
			$this->throwRecordNotFoundException("Store not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($store->toArray(), "Store retrieved successfully."));
	}
}
