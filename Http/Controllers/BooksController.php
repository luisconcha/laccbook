<?php

namespace LaccBook\Http\Controllers;

use Illuminate\Http\Request;
use LACC\Http\Controllers\Controller;
use LaccBook\Http\Requests\BookRequest;
use LaccBook\Repositories\BookRepository;
use LaccBook\Repositories\CategoryRepository;
use LACC\Repositories\UserRepository;
use LaccBook\Services\BookService;
use LaccBook\Services\CategoryService;
use LACC\Services\UserService;

class Bookscontroller extends Controller
{
    private $with = [ 'author' ];

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var \LaccBook\Services\CategoryService
     */
    protected $categoryService;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var \LaccBook\Services\BookService
     */
    protected $bookService;

    /**
     * @var BookRepository
     */
    protected $bookRepository;
    /**
     * @var \LaccBook\Repositories\CategoryRepository
     */
    protected $categoryRepository;

    protected $urlDefault = 'books.index';

    public function __construct(
        UserService $userService,
        UserRepository $userRepository,
        BookService $bookService,
        CategoryService $categoryService,
        CategoryRepository $categoryRepository,
        BookRepository $bookRepository
    )
    {
        $this->userService     = $userService;
        $this->userRepository  = $userRepository;
        $this->categoryService = $categoryService;
        $this->bookService     = $bookService;
        $this->bookRepository  = $bookRepository;
        $this->categoryRepository  = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {
        $search = $request->get('search');
        $books  = $this->bookRepository->with( $this->with )->paginate( 15 );

        return view( 'laccbook::books.index', compact( 'books','search' ) );
    }

    /**
     * show the form for creating a new resource.
     *
     * @return \illuminate\http\response
     */
    public function create()
    {
        //call BaseRepositoryTrait
        $categories = $this->categoryRepository->lists('name','id');
        $users      = $this->userRepository->lists( 'name', 'id' );

        return view( 'laccbook::books.create', compact( 'users', 'categories' ) );
    }

    /**
     * @param BookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BookRequest $request)
    {
        $data = $request->all();
        //@seed call method in BooRepositoryEloquent - create
        $this->bookRepository->create( $data );

        $request->session()->flash('message', ['type' => 'success','msg'=> "Book '{$data['title']}' successfully registered!"]);

        return redirect()->route( 'books.index' );
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $book = $this->bookService->verifyTheExistenceOfObject( $this->bookRepository, $id, $this->with );

        return view( 'laccbook::books.detail',compact( 'book' ) );
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $book       = $this->bookService->verifyTheExistenceOfObject( $this->bookRepository, $id, $this->with );
        $users      = $this->userRepository->lists( 'name', 'id' );
        $this->categoryRepository->withTrashed();
        $categories = $this->categoryRepository->listsWithMutators('name_trashed','id');

        return view( 'laccbook::books.edit',compact( 'book', 'users','categories' ) );
    }

    /**
     * @param \LaccBook\Http\Requests\BookRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Bookrequest $request, $id)
    {
        $this->bookService->verifyTheExistenceOfObject( $this->bookRepository, $id, $this->with);
        $data = $request->all();

        //@seed call method in BookRepositoryEloquent - update
        $this->bookRepository->update( $data, $id );

        $urlTo = $this->bookService->checksTheCurrentUrl( $data['redirect_to'], $this->urlDefault );

        $request->session()->flash('message', ['type' => 'success','msg'=> "Book '{$data['title']}' successfully update!"]);

        return redirect()->to( $urlTo );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        $this->bookService->verifyTheExistenceOfObject( $this->bookRepository, $id, $this->with );
        $this->bookRepository->delete( $id );

        $request->session()->flash('message', ['type' => 'success','msg'=> 'Book deleted successfully!']);

        return redirect()->route( 'books.index' );
    }
}
