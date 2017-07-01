<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\ProductRepository;
use App\Libraries\Repositories\ProductCategoryRepository;
use App\Libraries\Repositories\UomRepository;
use App\Libraries\Repositories\StoreCategoryRepository;

use Flash;
use Excel;
class ProductController extends AppAdminBaseController
{
	const record_per_page = 20;
	
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
	public function index(Request $request, 
		ProductCategoryRepository $productCategoryRepo, 
		StoreCategoryRepository $storeCategoryRepo)
	{
	    $input = $request->all();

		$result = $this->productRepository->search($input);

		$products = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];
		$storeList = [''=>'by Store'] + $storeCategoryRepo->getListWithStore('name', 'id');
		$productCategoryList = [''=>'by Category'] + $productCategoryRepo->getList('name', 'id');
		return view('products.index')
		    ->with('products', $products)
		    ->with('attributes', $attributes)
		    ->with('productCategoryList', $productCategoryList)
		    ->with('storeList', $storeList);
	}

	/**
	 * Show the form for creating a new Product.
	 *
	 * @return Response
	 */
	public function create(
		ProductCategoryRepository $productCategoryRepo, 
		UomRepository $uomRepo,
		StoreCategoryRepository $storeCategoryRepo)
	{
		$productCategoryList = [''=>'Select Category'] + $productCategoryRepo->getList('name', 'id');
		$uomList = [''=>'Select UOM'] + $uomRepo->getList('name', 'id');
		$storeList = [''=>'Select Store'] + $storeCategoryRepo->getListWithStore('name', 'id');
		return view('products.create')
		    ->with('productCategoryList', $productCategoryList)
		    ->with('uomList', $uomList)
		    ->with('storeList', $storeList);
	}

	/**
	 * Store a newly created Product in storage.
	 *
	 * @param CreateProductRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateProductRequest $request)
	{
        $input = $request->all();
		$product = $this->productRepository->store($input);

		Flash::message('Product saved successfully.');

		return redirect(route('admin.products.index'));
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
		{
			Flash::error('Product not found');
			return redirect(route('admin.products.index'));
		}

		return view('products.show')->with('product', $product);
	}

	/**
	 * Show the form for editing the specified Product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(
		ProductCategoryRepository $productCategoryRepo,
		UomRepository $uomRepo,
		StoreCategoryRepository $storeCategoryRepo,
		$id)
	{
		$product = $this->productRepository->findProductById($id);
		if(empty($product))
		{
			Flash::error('Product not found');
			return redirect(route('admin.products.index'));
		}
		$productCategoryList = [''=>'Select Category'] + $productCategoryRepo->getList('name', 'id');
		$uomList = [''=>'Select UOM'] + $uomRepo->getList('name', 'id');
		$storeList = [''=>'Select Store'] + $storeCategoryRepo->getListWithStore('name', 'id');		return view('products.edit')
			->with('product', $product)
			->with('productCategoryList', $productCategoryList)
		    ->with('uomList', $uomList)
		    ->with('storeList', $storeList);
	}

	/**
	 * Update the specified Product in storage.
	 *
	 * @param  int    $id
	 * @param CreateProductRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateProductRequest $request)
	{
		$product = $this->productRepository->findProductById($id);

		if(empty($product))
		{
			Flash::error('Product not found');
			return redirect(route('admin.products.index'));
		}

		$product = $this->productRepository->update($product, $request->all());

		Flash::message('Product updated successfully.');

		return redirect(route('admin.products.index'));
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
		{
			Flash::error('Product not found');
			return redirect(route('admin.products.index'));
		}

		$product->delete();

		Flash::message('Product deleted successfully.');

		return redirect(route('admin.products.index'));
	}

	/**
	 * Store Product form excel.
	 *
	 * @param CreateProductRequest $request
	 *
	 * @return Response
	 */
	public function upload(
		ProductCategoryRepository $productCategoryRepo, 
		UomRepository $uomRepo,
		StoreCategoryRepository $storeCategoryRepo,
		Request $request)
	{
		$this->validate($request, [
	        'excel' => 'required|mimes:xls,xlsx,ods,xmlx'
	    ]);
        $input = $request->all();
		$request->file('excel')->move(public_path('upload/'), 'excel.xls');
		$product_data = Excel::load(public_path('upload/').'excel.xls', function($reader) {
		})->get()->toArray();
		if($this->productRepository->bulkInsert($product_data))
		{
			Flash::message('Product uploaded successfully.');
		}
		else{
			Flash::error('Error in  Product upload');
		}
		return redirect(route('admin.products.index'));
	}
}
