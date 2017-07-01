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

		$products = $result[0]->get()->toArray();
		$newFormat =[];
		foreach ($products as $key => $value) {
			$exist = -1;
			foreach ($newFormat as $k => $val) {
				if ($val['id']==$value['product_category_id']) {
					$exist = $k;
					break;
				}
			}
			if ($exist != -1) {
				$newFormat[$exist]['product_list'][]=$value;
			}else{
				$cat = $value['category'];
				$cat['product_list'][] = $value;
				$newFormat[] = $cat;
			}
		}
		// return Response::json(ResponseManager::makeResult($newFormat, "Products retrieved successfully."));
		return Response::json(ResponseManager::makeResult($products, "Products retrieved successfully."));
	}
}
