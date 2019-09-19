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

Route::get('/', function () {
    $clients = App\Client::where('estimated_visit_time', '>', Carbon\Carbon::now())->where('completed_at', null)->orderBy('estimated_visit_time')->limit(5)->get();
    return view('welcome', compact('clients'));
});

Route::patch('/clients/completed/{client}', 'ClientsController@update')->middleware('IsAdmin');

Route::delete('/clients/delete/{client}', 'ClientsController@destroy')->middleware('IsAdmin');

Route::get('/client/{key}', 'ClientsController@show');

Route::get('/client-register', 'ClientsController@create');

Route::post('/client-register', 'ClientsController@store');

Route::post('/time-remaining', 'ClientsController@timeleft');

Route::post('/clients/{id}/cancel', 'ClientsController@cancel');

Route::patch('/clients/{id}/delay', 'ClientsController@delay');

Auth::routes();

Route::get('/admin', 'HomeController@index')->name('admin');
