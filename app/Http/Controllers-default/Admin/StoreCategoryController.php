<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateStoreCategoryRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\StoreCategoryRepository;
use Flash;

class StoreCategoryController extends AppAdminBaseController
{
	const record_per_page = 20;
	
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

		$storeCategories = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('storeCategories.index')
		    ->with('storeCategories', $storeCategories)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new StoreCategory.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('storeCategories.create');
	}

	/**
	 * Store a newly created StoreCategory in storage.
	 *
	 * @param CreateStoreCategoryRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateStoreCategoryRequest $request)
	{
        $input = $request->all();

		$storeCategory = $this->storeCategoryRepository->store($input);

		Flash::message('StoreCategory saved successfully.');

		return redirect(route('admin.storeCategories.index'));
	}

	/**
	 * Display the specified StoreCategory.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$storeCategory = $this->storeCategoryRepository->findStoreCategoryById($id);

		if(empty($storeCategory))
		{
			Flash::error('StoreCategory not found');
			return redirect(route('admin.storeCategories.index'));
		}

		return view('storeCategories.show')->with('storeCategory', $storeCategory);
	}

	/**
	 * Show the form for editing the specified StoreCategory.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$storeCategory = $this->storeCategoryRepository->findStoreCategoryById($id);

		if(empty($storeCategory))
		{
			Flash::error('StoreCategory not found');
			return redirect(route('admin.storeCategories.index'));
		}

		return view('storeCategories.edit')->with('storeCategory', $storeCategory);
	}

	/**
	 * Update the specified StoreCategory in storage.
	 *
	 * @param  int    $id
	 * @param CreateStoreCategoryRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateStoreCategoryRequest $request)
	{
		$storeCategory = $this->storeCategoryRepository->findStoreCategoryById($id);

		if(empty($storeCategory))
		{
			Flash::error('StoreCategory not found');
			return redirect(route('admin.storeCategories.index'));
		}

		$storeCategory = $this->storeCategoryRepository->update($storeCategory, $request->all());

		Flash::message('StoreCategory updated successfully.');

		return redirect(route('admin.storeCategories.index'));
	}

	/**
	 * Remove the specified StoreCategory from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$storeCategory = $this->storeCategoryRepository->findStoreCategoryById($id);

		if(empty($storeCategory))
		{
			Flash::error('StoreCategory not found');
			return redirect(route('admin.storeCategories.index'));
		}

		$storeCategory->delete();

		Flash::message('StoreCategory deleted successfully.');

		return redirect(route('admin.storeCategories.index'));
	}

}
