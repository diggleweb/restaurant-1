<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\CreatePromotionRequest;
use Illuminate\Http\Request;
use App\Libraries\Repositories\PromotionRepository;
use Flash;

class PromotionController extends AppAdminBaseController
{
	const record_per_page = 20;
	
	/** @var  PromotionRepository */
	private $promotionRepository;

	function __construct(PromotionRepository $promotionRepo)
	{
		$this->promotionRepository = $promotionRepo;
	}

	/**
	 * Display a listing of the Promotion.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $input = $request->all();

		$result = $this->promotionRepository->search($input);

		$promotions = $result[0]->paginate(self::record_per_page);

		$attributes = $result[1];

		return view('promotions.index')
		    ->with('promotions', $promotions)
		    ->with('attributes', $attributes);;
	}

	/**
	 * Show the form for creating a new Promotion.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('promotions.create');
	}

	/**
	 * Store a newly created Promotion in storage.
	 *
	 * @param CreatePromotionRequest $request
	 *
	 * @return Response
	 */
	public function store(CreatePromotionRequest $request)
	{
        $input = $request->all();

		$promotion = $this->promotionRepository->store($input);

		Flash::message('Promotion saved successfully.');

		return redirect(route('admin.promotions.index'));
	}

	/**
	 * Display the specified Promotion.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$promotion = $this->promotionRepository->findPromotionById($id);

		if(empty($promotion))
		{
			Flash::error('Promotion not found');
			return redirect(route('admin.promotions.index'));
		}

		return view('promotions.show')->with('promotion', $promotion);
	}

	/**
	 * Show the form for editing the specified Promotion.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$promotion = $this->promotionRepository->findPromotionById($id);

		if(empty($promotion))
		{
			Flash::error('Promotion not found');
			return redirect(route('admin.promotions.index'));
		}

		return view('promotions.edit')->with('promotion', $promotion);
	}

	/**
	 * Update the specified Promotion in storage.
	 *
	 * @param  int    $id
	 * @param CreatePromotionRequest $request
	 *
	 * @return Response
	 */
	public function update($id, CreatePromotionRequest $request)
	{
		$promotion = $this->promotionRepository->findPromotionById($id);

		if(empty($promotion))
		{
			Flash::error('Promotion not found');
			return redirect(route('admin.promotions.index'));
		}

		$promotion = $this->promotionRepository->update($promotion, $request->all());

		Flash::message('Promotion updated successfully.');

		return redirect(route('admin.promotions.index'));
	}

	/**
	 * Remove the specified Promotion from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$promotion = $this->promotionRepository->findPromotionById($id);

		if(empty($promotion))
		{
			Flash::error('Promotion not found');
			return redirect(route('admin.promotions.index'));
		}

		$promotion->delete();

		Flash::message('Promotion deleted successfully.');

		return redirect(route('admin.promotions.index'));
	}

}
