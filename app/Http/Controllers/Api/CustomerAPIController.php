<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Libraries\Repositories\CustomerRepository;
use Response;

class CustomerAPIController extends AppApiBaseController
{

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

		$customers = $result[0]->get();

		return Response::json(ResponseManager::makeResult($customers->toArray(), "Customers retrieved successfully."));
	}

	/**
	 * Show the form for creating a new Customer.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created Customer in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Customer::$rules) > 0)
            $this->validateRequest($request, Customer::$rules);

        $input = $request->all();

		$customer = $this->customerRepository->store($input);

		return Response::json(ResponseManager::makeResult($customer->toArray(), "Customer saved successfully."));
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
			$this->throwRecordNotFoundException("Customer not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($customer->toArray(), "Customer retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified Customer.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified Customer in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$customer = $this->customerRepository->findCustomerById($id);
		if(empty($customer)){
			$this->throwRecordNotFoundException("Customer not found", ERROR_CODE_RECORD_NOT_FOUND);
		}

		$input = $request->all();
		$customer = $this->customerRepository->update($customer, $input);

		return Response::json(ResponseManager::makeResult($customer->toArray(), "Customer updated successfully."));
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
			$this->throwRecordNotFoundException("Customer not found", ERROR_CODE_RECORD_NOT_FOUND);

		$customer->delete();

		return Response::json(ResponseManager::makeResult($id, "Customer deleted successfully."));
	}
	
	/**
	 * Customer Login
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function login(Request $request)
	{
		$phone_no = $request->input("phone_no");
		$name = $request->input("name");
		if (empty($phone_no)) {
			$this->throwRecordNotFoundException("Invalid Login", ERROR_CODE_RECORD_NOT_FOUND);
		}
		try{
			$customer = $this->customerRepository->login($phone_no, $name);
			return Response::json(ResponseManager::makeResult($customer->toArray(), "Customer Loggedin successfully."));
		}
		catch(\Exception $e){
			$this->throwRecordNotFoundException("Failed to Login".$e->getMessage(), $e->getCode());
		}
	}
}
