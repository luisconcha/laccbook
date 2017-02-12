<?php
namespace LaccBook\Http\Controllers\Trashs;

use Illuminate\Http\Request;
use LACC\Http\Controllers\Controller;
use LaccBook\Repositories\CategoryRepository;
use LACC\Services\CategoryService;

class CategoriesTrashController extends Controller
{
    /**
     * @var \LaccBook\Repositories\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var CategoryService
     */
    protected $categoryService;

    protected $urlDefault = 'trashed.books.index';

    public function __construct(CategoryRepository $categoryRepository, CategoryService $categoryService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService    = $categoryService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search     = $request->get( 'search' );
        $this->categoryRepository->onlyTrashed();
        $categories = $this->categoryRepository->paginate( 4 );

        return view( 'laccbook::trashs.categories.index', compact( 'categories', 'search' ) );
    }

    public function update( Request $request, $id )
    {
        $data = $request->all();
        $this->categoryRepository->onlyTrashed();
        $this->categoryRepository->restore( $id );

        $urlTo = $this->categoryService->checksTheCurrentUrl( $data['redirect_to'], $this->urlDefault );

        $request->session()->flash('message', ['type' => 'success','msg'=> "Category successfully restored!"]);

        return redirect()->to( $urlTo );
    }
}
