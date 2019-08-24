<?php

use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AuthControler;

/** Edita o nome na URI */
Route::resourceVerbs([
   'create' => 'cadastro',
   'edit' => 'editar',
]);

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    /** Formulário de Login */
    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    /** Rotas Protegidas */
    //Route::group(['middleware' => ['auth']], function () {

        /** Dashboard Home */
        Route::get('home', 'AuthController@home')->name('home');

        /** User */
        Route::resource('users', 'UserController');
        Route::put('/users/update/{id}', 'UserController@update')->name('user.update');
        Route::get('/users', 'UserController@index')->name('users');

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


    //});

    /** Logout */
    Route::get('logout', 'AuthController@logout')->name('logout');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
