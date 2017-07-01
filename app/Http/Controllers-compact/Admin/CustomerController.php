<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateCustomerRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\CustomerRepository;
use Flash;

class CustomerController extends AppAdminBaseController
{
	const record_per_page = 20;
	
	/** @var  CustomerRepository */
	private $customerRepository;

	function __construct(CustomerRepository $customerRepo)
	{
		$this->customerRepository = $customerRepo;
	}

	/**
	 * Display a listing of the Customer.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->customerRepository->search($input);

		$customers = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('customers.index')
		    ->with('customers', $customers)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new Customer.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('customers.create');
	}

	/**
	 * Store a newly created Customer in storage.
	 *
	 * @param CreateCustomerRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateCustomerRequest $request)
	{
        $input = $request->all();

		$customer = $this->customerRepository->store($input);

		Flash::message('Customer saved successfully.');

		return redirect(route('admin.customers.index'));
	}

	/**
	 * Display the specified Customer.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$customer = $this->customerRepository->findCustomerById($id);

		if(empty($customer))
		{
			Flash::error('Customer not found');
			return redirect(route('admin.customers.index'));
		}

		return view('customers.show')->with('customer', $customer);
	}

	/**
	 * Show the form for editing the specified Customer.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$customer = $this->customerRepository->findCustomerById($id);

		if(empty($customer))
		{
			Flash::error('Customer not found');
			return redirect(route('admin.customers.index'));
		}

		return view('customers.edit')->with('customer', $customer);
	}

	/**
	 * Update the specified Customer in storage.
	 *
	 * @param  int    $id
	 * @param CreateCustomerRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateCustomerRequest $request)
	{
		$customer = $this->customerRepository->findCustomerById($id);
		
		if(empty($customer))
		{
			Flash::error('Customer not found');
			return redirect(route('admin.customers.index'));
		}

		$customer = $this->customerRepository->update($customer, $request->all());

		Flash::message('Customer updated successfully.');

		return redirect(route('admin.customers.index'));
	}

	/**
	 * Remove the specified Customer from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$customer = $this->customerRepository->findCustomerById($id);

		if(empty($customer))
		{
			Flash::error('Customer not found');
			return redirect(route('admin.customers.index'));
		}

		$customer->delete();

		Flash::message('Customer deleted successfully.');

		return redirect(route('admin.customers.index'));
	}

}
