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
    $clients = App\Client::where('estimated_visit_time', '>', Carbon\Carbon::now())->where('is_completed', '0')->orderBy('estimated_visit_time')->limit(5)->get();
    return view('welcome', compact('clients'));
});

Route::get('/client-register', 'ClientsController@create');

Route::post('/client-register', 'ClientsController@store');

Route::post('/time-remaining', 'ClientsController@timeleft');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
