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

	/**
	 * Show the form for creating a new Promotion.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created Promotion in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Promotion::$rules) > 0)
            $this->validateRequest($request, Promotion::$rules);

        $input = $request->all();

		$promotion = $this->promotionRepository->store($input);

		return Response::json(ResponseManager::makeResult($promotion->toArray(), "Promotion saved successfully."));
	}

	/**
	 * Display the specified Promotion.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$promotion = $this->promotionRepository->findPromotionById($id);

		if(empty($promotion))
			$this->throwRecordNotFoundException("Promotion not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($promotion->toArray(), "Promotion retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified Promotion.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified Promotion in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$promotion = $this->promotionRepository->findPromotionById($id);

		if(empty($promotion))
			$this->throwRecordNotFoundException("Promotion not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$promotion = $this->promotionRepository->update($promotion, $input);

		return Response::json(ResponseManager::makeResult($promotion->toArray(), "Promotion updated successfully."));
	}

	/**
	 * Remove the specified Promotion from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$promotion = $this->promotionRepository->findPromotionById($id);

		if(empty($promotion))
			$this->throwRecordNotFoundException("Promotion not found", ERROR_CODE_RECORD_NOT_FOUND);

		$promotion->delete();

		return Response::json(ResponseManager::makeResult($id, "Promotion deleted successfully."));
	}
}
