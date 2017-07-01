<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateOrderDetailRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\OrderDetailRepository;
use Flash;

class OrderDetailController extends AppAdminBaseController
{
	const record_per_page = 20;
	
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

		$orderDetails = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('orderDetails.index')
		    ->with('orderDetails', $orderDetails)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new OrderDetail.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('orderDetails.create');
	}

	/**
	 * Store a newly created OrderDetail in storage.
	 *
	 * @param CreateOrderDetailRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateOrderDetailRequest $request)
	{
        $input = $request->all();

		$orderDetail = $this->orderDetailRepository->store($input);

		Flash::message('OrderDetail saved successfully.');

		return redirect(route('orderDetails.index'));
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
		{
			Flash::error('OrderDetail not found');
			return redirect(route('orderDetails.index'));
		}

		return view('orderDetails.show')->with('orderDetail', $orderDetail);
	}

	/**
	 * Show the form for editing the specified OrderDetail.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$orderDetail = $this->orderDetailRepository->findOrderDetailById($id);

		if(empty($orderDetail))
		{
			Flash::error('OrderDetail not found');
			return redirect(route('orderDetails.index'));
		}

		return view('orderDetails.edit')->with('orderDetail', $orderDetail);
	}

	/**
	 * Update the specified OrderDetail in storage.
	 *
	 * @param  int    $id
	 * @param CreateOrderDetailRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateOrderDetailRequest $request)
	{
		$orderDetail = $this->orderDetailRepository->findOrderDetailById($id);

		if(empty($orderDetail))
		{
			Flash::error('OrderDetail not found');
			return redirect(route('orderDetails.index'));
		}

		$orderDetail = $this->orderDetailRepository->update($orderDetail, $request->all());

		Flash::message('OrderDetail updated successfully.');

		return redirect(route('orderDetails.index'));
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
		{
			Flash::error('OrderDetail not found');
			return redirect(route('orderDetails.index'));
		}

		$orderDetail->delete();

		Flash::message('OrderDetail deleted successfully.');

		return redirect(route('orderDetails.index'));
	}

}
