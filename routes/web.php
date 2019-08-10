<?php
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\OrderController;

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.' ], function (){


    /**Login */

    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    /** Dashboard */
    Route::get('/home', 'AuthController@home')->name('home');


    /** Ordem de Serviço */
    Route::get('/ordem', 'OrderController@index')->name('order');
    Route::get('/ordem/novo', 'OrderController@create')->name('order.create');
    Route::get('/ordem/editar', 'OrderController@edit')->name('order.edit');


    /** Setores */
    Route::get('/setor', 'SectorController@index')->name('sector');

    Route::get('/setor/novo', 'SectorController@create')->name('sector.create');
    Route::post('/setor/store', 'SectorController@store')->name('sector.store');

    Route::get('/setor/editar/{id}', 'SectorController@edit')->name('sector.edit');
    Route::put('/setor/update/{id}', 'SectorController@update')->name('sector.update');


    Route::delete('/setor/destroy/{id}', 'SectorController@destroy')->name('sector.destroy');
    Route::get('/setor/desativar/{id}', 'SectorController@disable')->name('sector.disable');



});

