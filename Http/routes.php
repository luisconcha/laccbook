<?php

Route::group( [ 'middleware' => 'auth' ], function () {
    //Categories
    Route::resource( '/categories', 'CategoriesController', [ 'except' => [ 'show' ] ] );
    Route::get( 'categories/{id}', [ 'as' => 'categories.destroy', 'uses' => 'CategoriesController@destroy' ] );

    Route::group(['prefix' => 'trashed', 'as' => 'trashed.'], function (){
        Route::resource( 'categories', 'Trashs\CategoriesTrashController',
            [ 'except' => [ 'show','create', 'store','edit', 'update', 'destroy' ] ]  );
        Route::get( 'categories/{id}', [ 'as' => 'categories.restore', 'uses' => 'Trashs\CategoriesTrashController@update' ] );
    });
} );