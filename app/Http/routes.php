<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Home@index');

Route::get('/{route}/{api?}', 'Documentation@get');


Route::get('/{route}/{api}.{format}', 'API@get');
Route::post('/{route}/{api}', 'API@post');
Route::put('/{route}/{api}', 'API@put');
Route::delete('/{route}/{api}', 'API@delete');
