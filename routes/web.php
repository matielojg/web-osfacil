<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.' ], function (){


    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    Route::get('/home', 'AuthController@home')->name('home');
    Route::get('/setor', 'SectorController@index')->name('sector');

    Route::get('/setor/novo', 'SectorController@create')->name('sectorCreate');
    Route::post('/setor/store', 'SectorController@store')->name('sectorStore');

    Route::get('/setor/editar/{id}', 'SectorController@edit')->name('sectorEdit');
    Route::put('/setor/update/{id}', 'SectorController@update')->name('sectorUpdate');

    Route::get('/setor/trashed','SectorController@trashed')->name('sectorTrashed');

               //https://www.youtube.com/watch?v=X3HJRyQZJUs
//    Route::group(['prefix' => 'sector', 'namespace' => 'Sector', 'as' => 'sector.' ], function (){
//        Route::get('/', 'sectorController@index')->name('create');
//    });

});


