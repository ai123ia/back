<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('/test', function () {
  return [
    'user' => [
      'first_name' => 'first_name',
      'last_name' => 'last_name',
    ]
  ];
});


Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('products', 'ProductsController');
});
