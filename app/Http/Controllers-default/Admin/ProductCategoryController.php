<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateProductCategoryRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\ProductCategoryRepository;
use Flash;

class ProductCategoryController extends AppAdminBaseController
{
	const record_per_page = 20;
	
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

		$productCategories = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('productCategories.index')
		    ->with('productCategories', $productCategories)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new ProductCategory.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('productCategories.create');
	}

	/**
	 * Store a newly created ProductCategory in storage.
	 *
	 * @param CreateProductCategoryRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateProductCategoryRequest $request)
	{
        $input = $request->all();

		$productCategory = $this->productCategoryRepository->store($input);

		Flash::message('ProductCategory saved successfully.');

		return redirect(route('admin.productCategories.index'));
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
		{
			Flash::error('ProductCategory not found');
			return redirect(route('admin.productCategories.index'));
		}

		return view('productCategories.show')->with('productCategory', $productCategory);
	}

	/**
	 * Show the form for editing the specified ProductCategory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$productCategory = $this->productCategoryRepository->findProductCategoryById($id);

		if(empty($productCategory))
		{
			Flash::error('ProductCategory not found');
			return redirect(route('admin.productCategories.index'));
		}

		return view('productCategories.edit')->with('productCategory', $productCategory);
	}

	/**
	 * Update the specified ProductCategory in storage.
	 *
	 * @param  int    $id
	 * @param CreateProductCategoryRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateProductCategoryRequest $request)
	{
		$productCategory = $this->productCategoryRepository->findProductCategoryById($id);

		if(empty($productCategory))
		{
			Flash::error('ProductCategory not found');
			return redirect(route('admin.productCategories.index'));
		}

		$productCategory = $this->productCategoryRepository->update($productCategory, $request->all());

		Flash::message('ProductCategory updated successfully.');

		return redirect(route('admin.productCategories.index'));
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
		{
			Flash::error('ProductCategory not found');
			return redirect(route('admin.productCategories.index'));
		}

		$productCategory->delete();

		Flash::message('ProductCategory deleted successfully.');

		return redirect(route('admin.productCategories.index'));
	}

}
