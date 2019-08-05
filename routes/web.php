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
    Route::patch('/setor/edit', 'sectorController@edit');
    Route::get('/setor', 'sectorController@index')->name('sector');
    Route::get('/setor/novo', 'sectorController@create')->name('sectorCreate');
    Route::post('/setor/store', 'sectorController@store')->name('sectorStore');
    Route::delete('/setor/destroy', 'sectorController@destroy');

//    Route::group(['prefix' => 'sector', 'namespace' => 'Sector', 'as' => 'sector.' ], function (){
//        Route::get('/', 'sectorController@index')->name('create');
//    });

});


