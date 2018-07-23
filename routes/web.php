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



Route::get('/', 'RequestsController@reqChart')->name('/');

Route::group(['prefix' => 'request'], function(){
    Route::get('/', 'RequestsController@index')->name('request.index');
    Route::get('/create', 'RequestsController@create')->name('request.create');
    Route::post('/store', 'RequestsController@store')->name('request.store');
    Route::get('/show/{id}', 'RequestsController@show')->name('request.show');
    Route::get('/getService/{id}',array('as'=>'request.service','uses'=>'RequestsController@getService'));
});


Route::group(['middleware' => ['web', 'auth', 'admin']],function(){
   // Route::resource('department','DepartmentsController');
    Route::group(['prefix' => 'department'], function(){
        Route::get('/', 'DepartmentsController@index')->name('department.index');
        Route::get('/create', 'DepartmentsController@create')->name('department.create');
        Route::post('/store', 'DepartmentsController@store')->name('department.store');
        Route::get('/show/{id}', 'DepartmentsController@show')->name('department.show');
        Route::post('/active/{id}', 'DepartmentsController@active')->name('department.active');
        Route::post('/nonactive/{id}', 'DepartmentsController@nonactive')->name('department.nonactive');
        Route::post('/destroy/{id}', 'DepartmentsController@destroy')->name('department.destroy');
    });

});

Route::group(['middleware' => ['web', 'auth', 'operator']],function(){

    //Route::resource('service','ServicesController');
    Route::group(['prefix' => 'service'], function(){
        Route::get('/', 'ServicesController@index')->name('service.index');
        Route::get('/create', 'ServicesController@create')->name('service.create');
        Route::post('/store', 'ServicesController@store')->name('service.store');
        Route::get('/show/{id}', 'ServicesController@show')->name('service.show');
        Route::post('/update/{id}', 'ServicesController@update')->name('service.update');
        Route::post('/active/{id}', 'ServicesController@active')->name('service.active');
        Route::post('/nonactive/{id}', 'ServicesController@nonactive')->name('service.nonactive');
        Route::post('/destroy/{id}', 'ServicesController@destroy')->name('service.destroy');
    });

    Route::resource('user','UsersController');
    Route::group(['prefix' => 'user'], function(){
        Route::get('/', 'UsersController@index')->name('user.index');
        Route::get('/create', 'UsersController@create')->name('user.create');
        Route::post('/store', 'UsersController@store')->name('user.store');
        Route::get('/show/{id}', 'UsersController@show')->name('user.show');
        Route::post('/update/{id}', 'UsersController@update')->name('user.update');
        Route::post('/destroy/{id}', 'UsersController@destroy')->name('user.destroy');
    });
});

Route::group(['middleware' => ['web', 'auth', 'agent']],function(){
    //Route::resource('request','RequestsController');
    Route::group(['prefix' => 'request'], function(){
        Route::any('/export', 'RequestsController@export')->name('request.export');
        Route::get('/show/{id}', 'RequestsController@show')->name('request.show');
        Route::post('/update/{id}', 'RequestsController@update')->name('request.update');
        Route::post('/destroy/{id}', 'RequestsController@destroy')->name('request.destroy');
    });
});


Auth::routes();
Route::get('/home', 'RequestsController@reqChart')->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');