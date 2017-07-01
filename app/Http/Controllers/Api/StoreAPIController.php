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
	 * Show the form for creating a new Store.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created Store in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Store::$rules) > 0)
            $this->validateRequest($request, Store::$rules);

        $input = $request->all();

		$store = $this->storeRepository->store($input);

		return Response::json(ResponseManager::makeResult($store->toArray(), "Store saved successfully."));
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

	/**
	 * Show the form for editing the specified Store.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified Store in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$store = $this->storeRepository->findStoreById($id);

		if(empty($store))
			$this->throwRecordNotFoundException("Store not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$store = $this->storeRepository->update($store, $input);

		return Response::json(ResponseManager::makeResult($store->toArray(), "Store updated successfully."));
	}

	/**
	 * Remove the specified Store from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$store = $this->storeRepository->findStoreById($id);

		if(empty($store))
			$this->throwRecordNotFoundException("Store not found", ERROR_CODE_RECORD_NOT_FOUND);

		$store->delete();

		return Response::json(ResponseManager::makeResult($id, "Store deleted successfully."));
	}
	/**
	 * get all products from a Store.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function getProducts($id)
	{
		$products = $this->storeRepository->getProducts($id);

		if(empty($products))
			$this->throwRecordNotFoundException("no products found", ERROR_CODE_RECORD_NOT_FOUND);
		return Response::json(ResponseManager::makeResult($products->toArray(), "products retrieved successfully."));
	}
}
