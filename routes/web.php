<?php

use App\Http\Controllers\Admin\AuthControler;

/** Editaer o nome na URI */
Route::resourceVerbs([
    'create' => 'cadastro',
    'edit' => 'editar',
    'assign' => 'atribuir'
]);

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    /** Formulário de Login */
    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    /** Rotas Protegidas */
    Route::group(['middleware' => ['auth']], function () {

        /** Dashboard*/
        Route::get('home', 'DashboardController@home')->name('home');

        /** User */
        Route::get('/users/trashed', 'UserController@trashed')->name('users.trashed');
        Route::get('/users/{id}/restore', 'UserController@restore')->name('users.restore');
        Route::resource('users', 'UserController');

        /** Ordem de Serviço */
        Route::post('/orders/action/{id}', 'OrderController@editActions')->name('orders.edit.action');
        Route::get('/orders/assign', 'OrderController@assign')->name('orders.assign');
        Route::get('/orders/assign/technical/{id}', 'OrderController@assignTechnical')->name('orders.assign.technical');
        Route::patch('/orders/assign/update/technical/{id}',
            'OrderController@updateTechnical')->name('orders.assign.updateTechnical');
        Route::resource('orders', 'OrderController');

        /** Setores */
        Route::get('/setor', 'SectorController@index')->name('sector');
        Route::get('/setor/novo', 'SectorController@create')->name('sector.create');
        Route::post('/setor/store', 'SectorController@store')->name('sector.store');
        Route::get('/setor/editar/{id}', 'SectorController@edit')->name('sector.edit');
        Route::put('/setor/update/{id}', 'SectorController@update')->name('sector.update');
        Route::delete('/setor/destroy/{id}', 'SectorController@destroy')->name('sector.destroy');
        Route::get('/setor/desativar/{id}', 'SectorController@disable')->name('sector.disable');

        /**Servicos */
        Route::put('/services/update/{id}', 'ServiceController@update')->name('service.update');
        Route::resource('services', 'ServiceController');

        /** Logout */
        Route::get('logout', 'AuthController@logout')->name('logout');

    });

});
