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

Route::get('/', ['as' => 'home',
    'uses' => 'IndexController@index']);
Route::get('/getTrends', ['as' => 'get.trends',
    'uses' => 'IndexController@getTrends']);
Route::get('/{id}-{slug}', ['as' => 'view.keyword',
    'uses' => 'IndexController@viewKeyword']);