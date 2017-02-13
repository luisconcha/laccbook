<?php

namespace LaccBook\Http\Controllers\Trashs;

use Illuminate\Http\Request;
use LaccBook\Http\Controllers\Controller;
use LaccBook\Repositories\BookRepository;
use LaccBook\Services\BookService;

class BooksTrashController extends Controller
{
    /**
     * @var BookService
     */
    protected $bookService;

    /**
     * @var \LaccBook\Repositories\BookRepository
     */
    protected $bookRepository;

    protected $urlDefault = 'books.index';

    public function __construct( BookService $bookService, BookRepository $bookRepository )
    {
        $this->bookService     = $bookService;
        $this->bookRepository  = $bookRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {
        $search = $request->get('search');
        $this->bookRepository->onlyTrashed();
        $books  = $this->bookRepository->paginate( 15 );

        return view( 'laccbook::trashs.books.index', compact( 'books','search' ) );
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( Request $request, $id)
    {
        $data = $request->all();
        $this->bookRepository->onlyTrashed();
        $this->bookRepository->restore( $id );

        $urlTo = $this->bookService->checksTheCurrentUrl( $data['redirect_to'], $this->urlDefault );

        $request->session()->flash('message', ['type' => 'success','msg'=> "Book successfully restored!"]);

        return redirect()->to( $urlTo );
    }
}
