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

Auth::routes();

Route::get('/home', 'SubmissionController@live');
Route::get('/problem/{id}','ProblemController@index');
Route::get('/test','ProblemController@scatter');
Route::get('/test2','ProblemController@test');
Route::get('/prob','ProblemController@ProbAnalytics');
Route::get('/team/{id}','ProblemController@teamAnalytics');
