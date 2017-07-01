<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use App\Libraries\Repositories\StoreCategoryRepository;
use Response;

class StoreCategoryAPIController extends AppApiBaseController
{

	/** @var  StoreCategoryRepository */
	private $storeCategoryRepository;

	function __construct(StoreCategoryRepository $storeCategoryRepo)
	{
		$this->storeCategoryRepository = $storeCategoryRepo;
	}

	/**
	 * Display a listing of the StoreCategory.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->storeCategoryRepository->search($input);

		$storeCategories = $result[0]->get();

		return Response::json(ResponseManager::makeResult($storeCategories->toArray(), "StoreCategories retrieved successfully."));
	}

	/**
	 * Show the form for creating a new StoreCategory.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created StoreCategory in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(StoreCategory::$rules) > 0)
            $this->validateRequest($request, StoreCategory::$rules);

        $input = $request->all();

		$storeCategory = $this->storeCategoryRepository->store($input);

		return Response::json(ResponseManager::makeResult($storeCategory->toArray(), "StoreCategory saved successfully."));
	}

	/**
	 * Display the specified StoreCategory.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$storeCategory = $this->storeCategoryRepository->findStoreCategoryById($id);

		if(empty($storeCategory))
			$this->throwRecordNotFoundException("StoreCategory not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($storeCategory->toArray(), "StoreCategory retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified StoreCategory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified StoreCategory in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$storeCategory = $this->storeCategoryRepository->findStoreCategoryById($id);

		if(empty($storeCategory))
			$this->throwRecordNotFoundException("StoreCategory not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$storeCategory = $this->storeCategoryRepository->update($storeCategory, $input);

		return Response::json(ResponseManager::makeResult($storeCategory->toArray(), "StoreCategory updated successfully."));
	}

	/**
	 * Remove the specified StoreCategory from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$storeCategory = $this->storeCategoryRepository->findStoreCategoryById($id);

		if(empty($storeCategory))
			$this->throwRecordNotFoundException("StoreCategory not found", ERROR_CODE_RECORD_NOT_FOUND);

		$storeCategory->delete();

		return Response::json(ResponseManager::makeResult($id, "StoreCategory deleted successfully."));
	}

	/**
	 * get all products from a StoreCategory.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function getProducts($id)
	{
		$products = $this->storeCategoryRepository->getProducts($id);

		if(empty($products))
			$this->throwRecordNotFoundException("no products found", ERROR_CODE_RECORD_NOT_FOUND);
		return Response::json(ResponseManager::makeResult($products->toArray(), "products retrieved successfully."));
	}
}
