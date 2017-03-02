<?php
namespace LaccBook\Http\Controllers;

use Illuminate\Http\Request;
use LaccBook\Http\Requests\BookRequest;
use LaccBook\Repositories\BookRepository;
use LaccBook\Repositories\CategoryRepository;
use LaccUser\Repositories\UserRepository;
use LaccBook\Services\BookService;
use LaccBook\Services\CategoryService;
use LaccUser\Services\UserService;

use LaccUser\Annotations\Mapping as Permission;

/**
 * Class Bookscontroller
 * @package LaccBook\Http\Controllers
 * @Permission\Controller(name="books-admin", description="Book administration")
 */
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
    ) {
        $this->userService        = $userService;
        $this->userRepository     = $userRepository;
        $this->categoryService    = $categoryService;
        $this->bookService        = $bookService;
        $this->bookRepository     = $bookRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @Permission\Action(name="list-books", description="View book list")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {
        $search = $request->get( 'search' );
        $books  = $this->bookRepository->with( $this->with )->paginate( 15 );

        return view( 'laccbook::books.index', compact( 'books', 'search' ) );
    }

    /**
     * @Permission\Action(name="store-books", description="Store books")
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //call BaseRepositoryTrait
        $categories = $this->categoryRepository->lists( 'name', 'id' );
        $users      = $this->userRepository->lists( 'name', 'id' );

        return view( 'laccbook::books.create', compact( 'users', 'categories' ) );
    }

    /**
     * @param BookRequest $request
     * @Permission\Action(name="store-books", description="Store books")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( BookRequest $request )
    {
        $data = $request->all();
        //@seed call method in BooRepositoryEloquent - create
        $this->bookRepository->create( $data );
        $request->session()->flash( 'message',
          [ 'type' => 'success', 'msg' => "Book '{$data['title']}' successfully registered!" ] );

        return redirect()->route( 'books.index' );
    }

    /**
     * @param $id
     * @Permission\Action(name="view-book-detail", description="View book detail")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail( $id )
    {
        $book = $this->bookService->verifyTheExistenceOfObject( $this->bookRepository, $id, $this->with );

        return view( 'laccbook::books.detail', compact( 'book' ) );
    }

    /**
     * @param $id
     * @Permission\Action(name="update-books", description="Update books")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( $id )
    {
        $book  = $this->bookService->verifyTheExistenceOfObject( $this->bookRepository, $id, $this->with );
        $users = $this->userRepository->lists( 'name', 'id' );
        $this->categoryRepository->withTrashed();
        $categories = $this->categoryRepository->listsWithMutators( 'name', 'id' );

        return view( 'laccbook::books.edit', compact( 'book', 'users', 'categories' ) );
    }

    /**
     * @param BookRequest $request
     * @param             $id
     * @Permission\Action(name="update-books", description="Update books")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( Bookrequest $request, $id )
    {
        $this->bookService->verifyTheExistenceOfObject( $this->bookRepository, $id, $this->with );
        $data = $request->all();
        //@seed call method in BookRepositoryEloquent - update
        $this->bookRepository->update( $data, $id );
        $urlTo = $this->bookService->checksTheCurrentUrl( $data[ 'redirect_to' ], $this->urlDefault );
        $request->session()->flash( 'message',
          [ 'type' => 'success', 'msg' => "Book '{$data['title']}' successfully update!" ] );

        return redirect()->to( $urlTo );
    }

    /**
     * @param         $id
     * @param Request $request
     * @Permission\Action(name="destroy-book", description="Destroy book data")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( $id, Request $request )
    {
        $this->bookService->verifyTheExistenceOfObject( $this->bookRepository, $id, $this->with );
        $this->bookRepository->delete( $id );
        $request->session()->flash( 'message', [ 'type' => 'success', 'msg' => 'Book deleted successfully!' ] );

        return redirect()->route( 'books.index' );
    }
}
