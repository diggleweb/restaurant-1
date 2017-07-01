<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Libraries\Repositories\PromotionRepository;
use Response;

class PromotionAPIController extends AppApiBaseController
{

	/** @var  PromotionRepository */
	private $promotionRepository;

	function __construct(PromotionRepository $promotionRepo)
	{
		$this->promotionRepository = $promotionRepo;
	}

	/**
	 * Display a listing of the Promotion.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->promotionRepository->search($input);

		$promotions = $result[0]->get();

		return Response::json(ResponseManager::makeResult($promotions->toArray(), "Promotions retrieved successfully."));
	}
}
