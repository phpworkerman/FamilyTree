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
    return view('welcome');
});

Route::get('family', 'FamilyController@index');
Route::get('family/create', 'FamilyController@create');
Route::post('family', 'FamilyController@store')->name('create');
Route::get('family/{id}/edit', 'FamilyController@edit')->name('edit');
Route::put('family/{id}', 'FamilyController@update')->name('update');
Route::delete('family/{id}', 'FamilyController@destroy')->name('delete');
Route::get('family/title', 'FamilyController@title')->name('title');

