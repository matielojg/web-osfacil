<?php

use App\Http\Controllers\Admin\AuthControler;

/** Editaer o nome na URI */
Route::resourceVerbs([
    'create' => 'cadastro',
    'edit' => 'editar',
    'assign' => 'atribuir',
    //'sectorproviders' => 'manutencao'
]);


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    /**Requisições Ajax */
    Route::post('main-filter/search', 'FilterController@search')->name('main-filter.search');

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
        Route::delete('/orders/image-remove', 'OrderController@imageRemove')->name('orders.image.remove');

        Route::get('/orders/assign', 'OrderController@assign')->name('orders.assign');
        Route::get('/orders/assign/technical/{id}', 'OrderController@assignTechnical')->name('orders.assign.technical');
        Route::patch('/orders/assign/update/technical/{id}',
            'OrderController@updateTechnical')->name('orders.assign.updateTechnical');

        Route::get('/orders/do', 'OrderController@servicesToDo')->name('orders.servicesToDo');
        Route::get('/orders/edit/technician/{id}', 'OrderController@editTechnician')->name('orders.editTechnician');
        Route::post('/orders/do/update/{id}', 'OrderController@updateServicesToDo')->name('orders.servicesToDo.update');

        Route::get('/orders/pending', 'OrderController@pending')->name('orders.pending');
        Route::get('/orders/{order}/editpending', 'OrderController@editPending')->name('orders.edit.pending');
        Route::post('/orders/pending/{id}', 'OrderController@updatePending')->name('orders.pending.update');

        Route::get('/orders/executed', 'OrderController@ordersExecuted')->name('orders.executed');
        Route::get('/orders/edit/executed/{id}', 'OrderController@editExecuted')->name('orders.editExecuted');
        Route::post('/orders/executed/{id}', 'OrderController@executedUpdate')->name('orders.executed.update');

        Route::get('/orders/toevaluate', 'OrderController@toEvaluate')->name('orders.toEvaluate');
        Route::get('/orders/evaluate/{id}', 'OrderController@editToEvaluate')->name('orders.edit.evaluate');
        Route::post('/orders/rate/{id}', 'OrderController@rate')->name('orders.rate');

        Route::post('/orders/action/{id}', 'OrderController@editActions')->name('orders.edit.action');

        Route::get('/orders/avaliate', 'OrderController@avaliate')->name('orders.avaliate');

        Route::get('/orders/rated', 'OrderController@rated')->name('orders.rated');

        Route::get('/orders/all', 'OrderController@allOrders')->name('orders.allOrders');

        Route::get('/orders/finished', 'OrderController@finished')->name('orders.finished');

        Route::get('/orders/completed', 'OrderController@completed')->name('orders.completed');

        Route::get('/orders/{order}/editopen', 'OrderController@editOpen')->name('orders.edit.open');



        Route::get('/orders/progress', 'OrderController@ordersInProgress')->name('orders.ordersInProgress');

        Route::resource('orders', 'OrderController');

        /** Setores */
        Route::get('/setor', 'SectorController@index')->name('sector.index');
        Route::get('/setor/novo', 'SectorController@create')->name('sector.create');
        Route::post('/setor/store', 'SectorController@store')->name('sector.store');
        Route::get('/setor/editar/{id}', 'SectorController@edit')->name('sector.edit');
        Route::put('/setor/update/{id}', 'SectorController@update')->name('sector.update');
        Route::delete('/setor/destroy/{id}', 'SectorController@destroy')->name('sector.destroy');
        Route::get('/setor/desativar/{id}', 'SectorController@disable')->name('sector.disable');

        /** Setores Manutenção */
        Route::get('/providers', 'SectorProviderController@index')->name('sectorsProvider.index');
        Route::get('/providers/editar/{id}', 'SectorProviderController@edit')->name('sectorsProvider.edit');
        Route::put('/providers/update/{id}', 'SectorProviderController@update')->name('sectorsProvider.update');
        //Route::resource('sectorproviders', 'SectorProviderController');

        /**Servicos */
        Route::put('/services/update/{id}', 'ServiceController@update')->name('service.update');
        Route::get('/services/editar/{id}', 'ServiceController@update')->name('services.edit');
        Route::resource('services', 'ServiceController');

        /** Logout */
        Route::get('logout', 'AuthController@logout')->name('logout');

    });


});
