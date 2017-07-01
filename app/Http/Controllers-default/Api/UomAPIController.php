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
}
