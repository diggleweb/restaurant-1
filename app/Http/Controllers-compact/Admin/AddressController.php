<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateAddressRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\AddressRepository;
use Flash;

class AddressController extends AppAdminBaseController
{
	const record_per_page = 20;
	
	/** @var  AddressRepository */
	private $addressRepository;

	function __construct(AddressRepository $addressRepo)
	{
		$this->addressRepository = $addressRepo;
	}

	/**
	 * Display a listing of the Address.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->addressRepository->search($input);

		$addresses = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('addresses.index')
		    ->with('addresses', $addresses)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new Address.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('addresses.create')->with(['reference_id'=>1,'reference_type'=>'STORE']);
	}

	/**
	 * Store a newly created Address in storage.
	 *
	 * @param CreateAddressRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateAddressRequest $request)
	{
        $input = $request->all();

		$address = $this->addressRepository->store($input);

		Flash::message('Address saved successfully.');

		return redirect(route('addresses.index'));
	}

	/**
	 * Display the specified Address.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$address = $this->addressRepository->findAddressById($id);

		if(empty($address))
		{
			Flash::error('Address not found');
			return redirect(route('addresses.index'));
		}

		return view('addresses.show')->with('address', $address);
	}

	/**
	 * Show the form for editing the specified Address.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$address = $this->addressRepository->findAddressById($id);

		if(empty($address))
		{
			Flash::error('Address not found');
			return redirect(route('addresses.index'));
		}

		return view('addresses.edit')->with('address', $address);
	}

	/**
	 * Update the specified Address in storage.
	 *
	 * @param  int    $id
	 * @param CreateAddressRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateAddressRequest $request)
	{
		$address = $this->addressRepository->findAddressById($id);

		if(empty($address))
		{
			Flash::error('Address not found');
			return redirect(route('addresses.index'));
		}

		$address = $this->addressRepository->update($address, $request->all());

		Flash::message('Address updated successfully.');

		return redirect(route('addresses.index'));
	}

	/**
	 * Remove the specified Address from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$address = $this->addressRepository->findAddressById($id);

		if(empty($address))
		{
			Flash::error('Address not found');
			return redirect(route('addresses.index'));
		}

		$address->delete();

		Flash::message('Address deleted successfully.');

		return redirect(route('addresses.index'));
	}

}
