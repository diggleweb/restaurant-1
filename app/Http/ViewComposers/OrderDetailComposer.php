<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Libraries\Repositories\UomRepository as UomRepository;

class OrderDetailComposer {

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $uomRepo;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(UomRepository $uomRepo)
    {
        // Dependencies automatically resolved by service container...
        $this->uomRepo = $uomRepo;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('uomList', [''=>'Select UOM'] + $this->uomRepo->getList('name','id'));
    }

}