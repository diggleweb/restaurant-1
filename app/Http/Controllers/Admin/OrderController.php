<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateOrderRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\OrderRepository;

use Flash;
use Response;

class OrderController extends AppAdminBaseController
{
	const record_per_page = 20;
	
	/** @var  OrderRepository */
	private $orderRepository;

	function __construct(OrderRepository $orderRepo)
	{
		$this->orderRepository = $orderRepo;
	}

	/**
	 * Display a listing of the Order.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->orderRepository->search($input);

		$orders = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('orders.index')
		    ->with('orders', $orders)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new Order.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('orders.create');
	}

	/**
	 * Store a newly created Order in storage.
	 *
	 * @param CreateOrderRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateOrderRequest $request)
	{
        $input = $request->all();

		$order = $this->orderRepository->store($input);

		Flash::message('Order saved successfully.');

		return redirect(route('admin.orders.index'));
	}

	/**
	 * Display the specified Order.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$order = $this->orderRepository->findOrderById($id);

		if(empty($order))
		{
			Flash::error('Order not found');
			return redirect(route('admin.orders.index'));
		}

		return view('orders.show')->with('order', $order);
	}

	/**
	 * Show the form for editing the specified Order.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$order = $this->orderRepository->findOrderById($id);

		if(empty($order))
		{
			Flash::error('Order not found');
			return redirect(route('admin.orders.index'));
		}

		return view('orders.edit')->with('order', $order);
	}

	/**
	 * Update the specified Order in storage.
	 *
	 * @param  int    $id
	 * @param CreateOrderRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateOrderRequest $request)
	{
		$order = $this->orderRepository->findOrderById($id);

		if(empty($order))
		{
			Flash::error('Order not found');
			return redirect(route('admin.orders.index'));
		}

		$order = $this->orderRepository->update($order, $request->all());

		Flash::message('Order updated successfully.');

		return redirect(route('admin.orders.index'));
	}

	/**
	 * Remove the specified Order from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$order = $this->orderRepository->findOrderById($id);

		if(empty($order))
		{
			Flash::error('Order not found');
			return redirect(route('admin.orders.index'));
		}

		$order->delete();

		Flash::message('Order deleted successfully.');

		return redirect(route('admin.orders.index'));
	}
	/**
	 * Check for new Order.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function checkNew($id)
	{
		$result = $this->orderRepository->search(null);
		$orders = $result[0]->where('id', '>', intval($id))->get();
		return Response::json($orders);
	}
}
