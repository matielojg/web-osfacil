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

        /** Dashboards*/
        Route::get('home', 'DashboardController@home')->name('home');

        /** User */
        Route::get('/users/trashed', 'UserController@trashed')->name('users.trashed');
        Route::get('/users/{id}/restore', 'UserController@restore')->name('users.restore');
        Route::resource('users', 'UserController');

        /** Ordem de Serviço */
        Route::post('/orders/action/{id}', 'OrderController@editActions')->name('orders.edit.action');
        Route::resource('orders', 'OrderController');
//        Route::get('/ordem', 'OrderController@index')->name('order');
//        Route::get('/ordem/novo', 'OrderController@create')->name('order.create');


        /** Setores */
        Route::get('/setor', 'SectorController@index')->name('sector');
        Route::get('/setor/novo', 'SectorController@create')->name('sector.create');
        Route::post('/setor/store', 'SectorController@store')->name('sector.store');
        Route::get('/setor/editar/{id}', 'SectorController@edit')->name('sector.edit');
        Route::put('/setor/update/{id}', 'SectorController@update')->name('sector.update');
        Route::delete('/setor/destroy/{id}', 'SectorController@destroy')->name('sector.destroy');
        Route::get('/setor/desativar/{id}', 'SectorController@disable')->name('sector.disable');

        /**Servicos */
        Route::resource('services', 'ServiceController');
        Route::put('/services/update/{id}', 'ServiceController@update')->name('service.update');

    /** Logout */
        Route::get('logout', 'AuthController@logout')->name('logout');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/session',function() {

    session([
        'function' =>'supervisor'
    ]);
    session()->put('name','Matielo');
    var_dump(session()->all());
});
