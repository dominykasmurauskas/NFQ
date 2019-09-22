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

//view main dashboard
Route::get('/', function () {
    $clients = App\Client::where('estimated_visit_time', '>', Carbon\Carbon::now())
                ->where('completed_at', null)->orderBy('estimated_visit_time')
                ->limit(5)->get();
    return view('welcome', compact('clients'));
});

//admin mark client as completed
Route::patch('/clients/completed/{client}', 'HomeController@update'); 

//admin delete client
Route::delete('/clients/delete/{client}', 'HomeController@destroy');

//admin delete all completed clients
Route::delete('/admin/delete-completed', 'HomeController@deleteCompleted');

//client dashboard
Route::get('/client/{key}', 'ClientsController@show');

//specialist's dashboard
Route::get('/specialist/{id}', function($id) {
    $specialist = \App\User::findOrFail($id);
    return view('specialist-show', compact('specialist'));
});

//client register page
Route::get('/client-register', 'ClientsController@create');

//client register post request with data
Route::post('/client-register', 'ClientsController@store');

//client post request to check time remaining until the visit
Route::post('/time-remaining', 'ClientsController@timeleft');

//client self-cancel
Route::post('/clients/{id}/cancel', 'ClientsController@cancel');

//client delay his visit
Route::patch('/clients/{id}/delay', 'ClientsController@delay');

//authtentication routes
Auth::routes();

//get admin dashboard
Route::get('/admin', 'HomeController@index')->name('admin');

//view statistics page
Route::get('/statistika', function() {
    $users = \App\User::where('is_admin', true)->orderBy('served_clients')
                ->limit(5)->get();
    return view('statistics', compact('users'));
});
