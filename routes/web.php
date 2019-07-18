<?php
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;

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

Route::post('/home', 'HomeController@find');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/itemlist', 'ItemlistController@index');
Route::get('/profile', 'ProfileController@index');
//Route::get('/home', 'TokopediaController@index');
//Route::get('/home', 'TokopediaController@search');

Route::post('/searchdata', function(){
    if(Request::ajax()){
        //return Response::json(Request::all());
        return response(Request::all())->header('Content-type', 'text/plain');
    }
});