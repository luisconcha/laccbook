<?php
/**
 * File: BookService.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 04/02/17
 * Time: 17:16
 * Project: lacc_editora
 * Copyright: 2017
 */

namespace LaccBook\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use LACC\Services\BaseService;
use LaccBook\Repositories\BookRepository;

class BookService extends BaseService
{
    /**
     * @var \LaccBook\Repositories\BookRepository
     */
    private $bookRepository;

    public function __construct( BookRepository $bookRepository )
    {
        $this->bookRepository = $bookRepository;
    }

    public function verifyTheExistenceOfTheABook( $id )
    {
        if( !( $book =  $this->bookRepository->find( $id ) ) ){
            throw new modelnotfoundexception( 'Book not found' );
        }
        return $book;
    }
}