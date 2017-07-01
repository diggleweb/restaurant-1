<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Libraries\Repositories\OrderDetailRepository;
use Response;

class OrderDetailAPIController extends AppApiBaseController
{

	/** @var  OrderDetailRepository */
	private $orderDetailRepository;

	function __construct(OrderDetailRepository $orderDetailRepo)
	{
		$this->orderDetailRepository = $orderDetailRepo;
	}

	/**
	 * Display a listing of the OrderDetail.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->orderDetailRepository->search($input);

		$orderDetails = $result[0]->get();

		return Response::json(ResponseManager::makeResult($orderDetails->toArray(), "OrderDetails retrieved successfully."));
	}

	/**
	 * Show the form for creating a new OrderDetail.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created OrderDetail in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(OrderDetail::$rules) > 0)
            $this->validateRequest($request, OrderDetail::$rules);

        $input = $request->all();

		$orderDetail = $this->orderDetailRepository->store($input);

		return Response::json(ResponseManager::makeResult($orderDetail->toArray(), "OrderDetail saved successfully."));
	}

	/**
	 * Display the specified OrderDetail.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$orderDetail = $this->orderDetailRepository->findOrderDetailById($id);

		if(empty($orderDetail))
			$this->throwRecordNotFoundException("OrderDetail not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($orderDetail->toArray(), "OrderDetail retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified OrderDetail.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified OrderDetail in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$orderDetail = $this->orderDetailRepository->findOrderDetailById($id);

		if(empty($orderDetail))
			$this->throwRecordNotFoundException("OrderDetail not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$orderDetail = $this->orderDetailRepository->update($orderDetail, $input);

		return Response::json(ResponseManager::makeResult($orderDetail->toArray(), "OrderDetail updated successfully."));
	}

	/**
	 * Remove the specified OrderDetail from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$orderDetail = $this->orderDetailRepository->findOrderDetailById($id);

		if(empty($orderDetail))
			$this->throwRecordNotFoundException("OrderDetail not found", ERROR_CODE_RECORD_NOT_FOUND);

		$orderDetail->delete();

		return Response::json(ResponseManager::makeResult($id, "OrderDetail deleted successfully."));
	}
}
