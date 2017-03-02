<?php

Route::group( [ 'middleware' => ['auth', config('laccuser.middleware.isVerified') ] ], function () {

    Route::group( [ 'prefix' => 'admin', 'middleware' => 'auth.resource' ], function () {
        //Categories
        Route::resource( '/categories', 'CategoriesController', [ 'except' => [ 'show' ] ] );
        Route::get( 'categories/{id}', [ 'as' => 'categories.destroy', 'uses' => 'CategoriesController@destroy' ] );

        //Books
        Route::resource( '/books', 'BooksController', [ 'except' => [ 'show' ] ]  );
        Route::get( 'books/{id}', [ 'as' => 'books.destroy', 'uses' => 'BooksController@destroy' ] );
        Route::get( 'books-detail/{id}', [ 'as' => 'books.detail', 'uses' => 'BooksController@detail' ] );

        //Trashed
        Route::group(['prefix' => 'trashed', 'as' => 'trashed.'], function (){
            Route::resource( 'categories', 'Trashs\CategoriesTrashController',
              [ 'except' => [ 'show','create', 'store','edit', 'update', 'destroy' ] ]  );
            Route::get( 'categories/{id}', [ 'as' => 'categories.restore', 'uses' => 'Trashs\CategoriesTrashController@update' ] );

            Route::resource( 'books', 'Trashs\BooksTrashController',
              [ 'except' => [ 'show','create', 'store','edit', 'update', 'destroy' ] ]  );
            Route::get( 'books/{id}', [ 'as' => 'books.restore', 'uses' => 'Trashs\BooksTrashController@update' ] );
        });
    } );
} );