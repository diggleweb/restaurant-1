<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Mitul\Generator\Utils\ResponseManager;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Libraries\Repositories\MediaRepository;
use Response;

class MediaAPIController extends AppApiBaseController
{

	/** @var  MediaRepository */
	private $mediaRepository;

	function __construct(MediaRepository $mediaRepo)
	{
		$this->mediaRepository = $mediaRepo;
	}

	/**
	 * Display a listing of the Media.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->mediaRepository->search($input);

		$media = $result[0]->get();

		return Response::json(ResponseManager::makeResult($media->toArray(), "Media retrieved successfully."));
	}

	/**
	 * Show the form for creating a new Media.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created Media in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(sizeof(Media::$rules) > 0)
            $this->validateRequest($request, Media::$rules);

        $input = $request->all();

		$media = $this->mediaRepository->store($input);

		return Response::json(ResponseManager::makeResult($media->toArray(), "Media saved successfully."));
	}

	/**
	 * Display the specified Media.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$media = $this->mediaRepository->findMediaById($id);

		if(empty($media))
			$this->throwRecordNotFoundException("Media not found", ERROR_CODE_RECORD_NOT_FOUND);

		return Response::json(ResponseManager::makeResult($media->toArray(), "Media retrieved successfully."));
	}

	/**
	 * Show the form for editing the specified Media.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified Media in storage.
	 *
	 * @param  int    $id
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$media = $this->mediaRepository->findMediaById($id);

		if(empty($media))
			$this->throwRecordNotFoundException("Media not found", ERROR_CODE_RECORD_NOT_FOUND);

		$input = $request->all();

		$media = $this->mediaRepository->update($media, $input);

		return Response::json(ResponseManager::makeResult($media->toArray(), "Media updated successfully."));
	}

	/**
	 * Remove the specified Media from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$media = $this->mediaRepository->findMediaById($id);

		if(empty($media))
			$this->throwRecordNotFoundException("Media not found", ERROR_CODE_RECORD_NOT_FOUND);

		$media->delete();

		return Response::json(ResponseManager::makeResult($id, "Media deleted successfully."));
	}
}
