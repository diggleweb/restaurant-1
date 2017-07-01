<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateUomRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\UomRepository;
use Flash;

class UomController extends AppAdminBaseController
{
	const record_per_page = 20;
	
	/** @var  UomRepository */
	private $uomRepository;

	function __construct(UomRepository $uomRepo)
	{
		$this->uomRepository = $uomRepo;
	}

	/**
	 * Display a listing of the Uom.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->uomRepository->search($input);

		$uoms = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('uoms.index')
		    ->with('uoms', $uoms)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new Uom.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('uoms.create');
	}

	/**
	 * Store a newly created Uom in storage.
	 *
	 * @param CreateUomRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateUomRequest $request)
	{
        $input = $request->all();

		$uom = $this->uomRepository->store($input);

		Flash::message('Uom saved successfully.');

		return redirect(route('admin.uoms.index'));
	}

	/**
	 * Display the specified Uom.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$uom = $this->uomRepository->findUomById($id);

		if(empty($uom))
		{
			Flash::error('Uom not found');
			return redirect(route('admin.uoms.index'));
		}

		return view('uoms.show')->with('uom', $uom);
	}

	/**
	 * Show the form for editing the specified Uom.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$uom = $this->uomRepository->findUomById($id);

		if(empty($uom))
		{
			Flash::error('Uom not found');
			return redirect(route('admin.uoms.index'));
		}

		return view('uoms.edit')->with('uom', $uom);
	}

	/**
	 * Update the specified Uom in storage.
	 *
	 * @param  int    $id
	 * @param CreateUomRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateUomRequest $request)
	{
		$uom = $this->uomRepository->findUomById($id);

		if(empty($uom))
		{
			Flash::error('Uom not found');
			return redirect(route('admin.uoms.index'));
		}

		$uom = $this->uomRepository->update($uom, $request->all());

		Flash::message('Uom updated successfully.');

		return redirect(route('admin.uoms.index'));
	}

	/**
	 * Remove the specified Uom from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$uom = $this->uomRepository->findUomById($id);

		if(empty($uom))
		{
			Flash::error('Uom not found');
			return redirect(route('admin.uoms.index'));
		}

		$uom->delete();

		Flash::message('Uom deleted successfully.');

		return redirect(route('admin.uoms.index'));
	}

}
