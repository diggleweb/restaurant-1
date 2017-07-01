<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Libraries\Repositories\ProductCategoryRepository;
use Response;

class ProductCategoryAPIController extends AppApiBaseController
{

	/** @var  ProductCategoryRepository */
	private $productCategoryRepository;

	function __construct(ProductCategoryRepository $productCategoryRepo)
	{
		$this->productCategoryRepository = $productCategoryRepo;
	}

	/**
	 * Display a listing of the ProductCategory.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->productCategoryRepository->search($input);

		$productCategories = $result[0]->get();

		return Response::json(ResponseManager::makeResult($productCategories->toArray(), "ProductCategories retrieved successfully."));
	}

	/**
	 * Show the form for creating a new ProductCategory.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created ProductCategory in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(ProductCategory::$rules) > 0)
            $this->validateRequest($request, ProductCategory::$rules);

        $input = $request->all();

		$productCategory = $this->productCategoryRepository->store($input);

		return Response::json(ResponseManager::makeResult($productCategory->toArray(), "ProductCategory saved successfully."));
	}

	/**
	 * Display the specified ProductCategory.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$productCategory = $this->productCategoryRepository->findProductCategoryById($id);

		if(empty($productCategory))
			$this->throwRecordNotFoundException("ProductCategory not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($productCategory->toArray(), "ProductCategory retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified ProductCategory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified ProductCategory in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$productCategory = $this->productCategoryRepository->findProductCategoryById($id);

		if(empty($productCategory))
			$this->throwRecordNotFoundException("ProductCategory not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$productCategory = $this->productCategoryRepository->update($productCategory, $input);

		return Response::json(ResponseManager::makeResult($productCategory->toArray(), "ProductCategory updated successfully."));
	}

	/**
	 * Remove the specified ProductCategory from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$productCategory = $this->productCategoryRepository->findProductCategoryById($id);

		if(empty($productCategory))
			$this->throwRecordNotFoundException("ProductCategory not found", ERROR_CODE_RECORD_NOT_FOUND);

		$productCategory->delete();

		return Response::json(ResponseManager::makeResult($id, "ProductCategory deleted successfully."));
	}
}
