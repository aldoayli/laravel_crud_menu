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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index')->name('home');


Auth::routes();

// -- manage menu
Route::resource('manage-menu', 'ManageMenuController');
Route::post('manage-menu-data', 'ManageMenuController@datatables');
Route::post('manage-menu-edit', 'ManageMenuController@postdata');
Route::post('manage-menu-delete', 'ManageMenuController@removedata'); 
Route::post('get-parent-menu', 'ManageMenuController@getparent');

// -- assign menu
Route::resource('assign-menu', 'AssignMenuController');
Route::post('assign-menu-data', 'AssignMenuController@datatables');
Route::post('assign-menu-edit', 'AssignMenuController@postdata');
Route::post('assign-menu-delete', 'AssignMenuController@removedata');
Route::post('get-unassign-id', 'AssignMenuController@getunassign'); 
Route::post('get-tree-menu', 'AssignMenuController@gettreemenu');


// - Homepage
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
});
