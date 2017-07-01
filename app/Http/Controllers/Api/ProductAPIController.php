<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Libraries\Repositories\ProductRepository;
use Response;

class ProductAPIController extends AppApiBaseController
{

	/** @var  ProductRepository */
	private $productRepository;

	function __construct(ProductRepository $productRepo)
	{
		$this->productRepository = $productRepo;
	}

	/**
	 * Display a listing of the Product.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->productRepository->search($input);
		$products = !empty($input["no_pagination"])?$result[0]->get():$result[0]->paginate();

		return Response::json(ResponseManager::makeResult($products->toArray(), "Products retrieved successfully."));
	}

	/**
	 * Show the form for creating a new Product.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
	/**
	 * Show the form for creating a new Product.
	 *
	 * @return Response
	 */
	public function fullTextSearch(Request $request)
	{
	    $input = $request->all();

		$result = $this->productRepository->fullTextSearch($input);

		$products = $result->get();

		return Response::json(ResponseManager::makeResult($products->toArray(), "Products retrieved successfully."));
	}

	/**
	 * Store a newly created Product in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Product::$rules) > 0)
            $this->validateRequest($request, Product::$rules);

        $input = $request->all();

		$product = $this->productRepository->store($input);

		return Response::json(ResponseManager::makeResult($product->toArray(), "Product saved successfully."));
	}

	/**
	 * Display the specified Product.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$product = $this->productRepository->findProductById($id);

		if(empty($product))
			$this->throwRecordNotFoundException("Product not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($product->toArray(), "Product retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified Product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified Product in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$product = $this->productRepository->findProductById($id);

		if(empty($product))
			$this->throwRecordNotFoundException("Product not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$product = $this->productRepository->update($product, $input);

		return Response::json(ResponseManager::makeResult($product->toArray(), "Product updated successfully."));
	}

	/**
	 * Remove the specified Product from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$product = $this->productRepository->findProductById($id);

		if(empty($product))
			$this->throwRecordNotFoundException("Product not found", ERROR_CODE_RECORD_NOT_FOUND);

		$product->delete();

		return Response::json(ResponseManager::makeResult($id, "Product deleted successfully."));
	}
}
