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
	 * get all products from a StoreCategory.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function getProducts($id)
	{
		$products1 = $this->storeCategoryRepository->getProducts($id)->toArray();
		$newFormat = [];
		foreach ($products1 as $key1 => $p) {
			$products = $p['product_list'];
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
		}
		if(empty($newFormat))
			$this->throwRecordNotFoundException("no products found", ERROR_CODE_RECORD_NOT_FOUND);
		return Response::json(ResponseManager::makeResult($newFormat, "products retrieved successfully."));
	}
}
