<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\Uom;
use Illuminate\Http\Request;
use App\Libraries\Repositories\UomRepository;
use Response;

class UomAPIController extends AppApiBaseController
{

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

		$uoms = $result[0]->get();

		return Response::json(ResponseManager::makeResult($uoms->toArray(), "Uoms retrieved successfully."));
	}

	/**
	 * Show the form for creating a new Uom.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created Uom in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Uom::$rules) > 0)
            $this->validateRequest($request, Uom::$rules);

        $input = $request->all();

		$uom = $this->uomRepository->store($input);

		return Response::json(ResponseManager::makeResult($uom->toArray(), "Uom saved successfully."));
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
			$this->throwRecordNotFoundException("Uom not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($uom->toArray(), "Uom retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified Uom.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified Uom in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$uom = $this->uomRepository->findUomById($id);

		if(empty($uom))
			$this->throwRecordNotFoundException("Uom not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$uom = $this->uomRepository->update($uom, $input);

		return Response::json(ResponseManager::makeResult($uom->toArray(), "Uom updated successfully."));
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
			$this->throwRecordNotFoundException("Uom not found", ERROR_CODE_RECORD_NOT_FOUND);

		$uom->delete();

		return Response::json(ResponseManager::makeResult($id, "Uom deleted successfully."));
	}
}
