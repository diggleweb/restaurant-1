<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreateMediaRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\MediaRepository;
use Flash;

class MediaController extends AppAdminBaseController
{
	const record_per_page = 20;
	
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

		$media = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('media.index')
		    ->with('media', $media)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new Media.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('media.create');
	}

	/**
	 * Store a newly created Media in storage.
	 *
	 * @param CreateMediaRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateMediaRequest $request)
	{
        $input = $request->all();
		$media = $this->mediaRepository->store($input);

		Flash::message('Media saved successfully.');

		return redirect(route('media.index'));
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
		{
			Flash::error('Media not found');
			return redirect(route('media.index'));
		}

		return view('media.show')->with('media', $media);
	}

	/**
	 * Show the form for editing the specified Media.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$media = $this->mediaRepository->findMediaById($id);

		if(empty($media))
		{
			Flash::error('Media not found');
			return redirect(route('media.index'));
		}

		return view('media.edit')->with('media', $media);
	}

	/**
	 * Update the specified Media in storage.
	 *
	 * @param  int    $id
	 * @param CreateMediaRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreateMediaRequest $request)
	{
		$media = $this->mediaRepository->findMediaById($id);

		if(empty($media))
		{
			Flash::error('Media not found');
			return redirect(route('media.index'));
		}

		$media = $this->mediaRepository->update($media, $request->all());

		Flash::message('Media updated successfully.');

		return redirect(route('media.index'));
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
		{
			Flash::error('Media not found');
			return redirect(route('media.index'));
		}

		$media->delete();

		Flash::message('Media deleted successfully.');

		// return redirect(route('media.index'));
		return redirect()->back();
	}

}
