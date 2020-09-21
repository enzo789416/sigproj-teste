<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();



Route::middleware('can:vote')->group(function () {
    Route::resource('/home', 'HomeController')->except([
        'create', 'edit', 'store', 'destroy'
    ]);
});
// Route::get('/enquete/{enquete}', 'HomeController@show')->name('enquete');


Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function () {
    Route::resource('/user', 'UserController', ['except' => ['show', 'create', 'store']]);
});

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-polls')->group(function () {
    Route::get('poll/nao_iniciadas', 'PollController@listNaoInciadas')->name('poll.naoIniciada');
    Route::get('poll/emAndamento', 'PollController@emAndamento')->name('poll.emAndamento');
    Route::get('poll/finalizadas', 'PollController@finalizadas')->name('poll.finalizadas');
    // Route::get('poll/{poll}/options/{options}/edit', 'PollController@edit')->name('poll.edit');
    Route::resource('/poll', 'PollController');
});
