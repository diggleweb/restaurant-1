<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateStoreRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\StoreRepository;
use App\Libraries\Repositories\StoreCategoryRepository;

use Flash;

class StoreController extends AppAdminBaseController
{
	const record_per_page = 20;
	
	/** @var  StoreRepository */
	private $storeRepository;

	function __construct(StoreRepository $storeRepo)
	{
		$this->storeRepository = $storeRepo;
	}

	/**
	 * Display a listing of the Store.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request,StoreCategoryRepository $storeCategoryRepository)
	{
	    $input = $request->all();

		$result = $this->storeRepository->search($input);

		$stores = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];
		$storeCategoryList = [''=>'by Category'] + $storeCategoryRepository->getList('name', 'id');
		return view('stores.index')
		    ->with('stores', $stores)
		    ->with('attributes', $attributes)
		    ->with('storeCategoryList', $storeCategoryList);
	}

	/**
	 * Show the form for creating a new Store.
	 *
	 * @return Response
	 */
	public function create(StoreCategoryRepository $storeCategoryRepository)
	{
		$storeCategoryList = [''=>'Select Category'] + $storeCategoryRepository->getList('name', 'id');
		return view('stores.create')
		    ->with('storeCategoryList', $storeCategoryList);
	}

	/**
	 * Store a newly created Store in storage.
	 *
	 * @param CreateStoreRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateStoreRequest $request)
	{
        $input = $request->all();

        $store = $this->storeRepository->store($input);

		Flash::message('Store saved successfully.');

		return redirect(route('admin.stores.index'));
	}

	/**
	 * Display the specified Store.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$store = $this->storeRepository->findStoreById($id);

		if(empty($store))
		{
			Flash::error('Store not found');
			return redirect(route('admin.stores.index'));
		}

		return view('stores.show')->with('store', $store);
	}

	/**
	 * Show the form for editing the specified Store.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(StoreCategoryRepository $storeCategoryRepository, $id)
	{
		$store = $this->storeRepository->findStoreById($id);

		if(empty($store))
		{
			Flash::error('Store not found');
			return redirect(route('admin.stores.index'));
		}
		// dd($store);
		$storeCategoryList = [''=>'Select Category'] + $storeCategoryRepository->getList('name', 'id');
		return view('stores.edit')
			->with('store', $store)
			->with('storeCategoryList', $storeCategoryList);
	}

	/**
	 * Update the specified Store in storage.
	 *
	 * @param  int    $id
	 * @param CreateStoreRequest $request
	 *
	 * @return Response
	 */
	public function update(CreateStoreRequest $request, $id)
	{
		$store = $this->storeRepository->findStoreById($id);

		if(empty($store))
		{
			Flash::error('Store not found');
			return redirect(route('admin.stores.index'));
		}
		$input = $request->all();
		$store = $this->storeRepository->update($store, $input);

		Flash::message('Store updated successfully.');

		return redirect(route('admin.stores.index'));
	}

	/**
	 * Remove the specified Store from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$store = $this->storeRepository->findStoreById($id);

		if(empty($store))
		{
			Flash::error('Store not found');
			return redirect(route('admin.stores.index'));
		}

		$store->delete();

		Flash::message('Store deleted successfully.');

		return redirect(route('admin.stores.index'));
	}

}
