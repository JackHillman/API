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

Route::get('/', 'Home@get');
Route::get('/search/{term}', function($term) {
  $search = new App\Http\Controllers\Search($term);
  return $search->results;
});

Route::get('/{route}', 'Listing@get');

Route::get('/{route}/{api}', 'Documentation@get');

Route::get('/{route}/{api}.{format}', 'API@get');
Route::get('/{route}/{api}/{param?}.{format}', 'API@get');
Route::post('/{route}/{api}/{param?}', 'API@post');
Route::put('/{route}/{api}/{param?}', 'API@put');
Route::delete('/{route}/{api}/{param?}', 'API@delete');
