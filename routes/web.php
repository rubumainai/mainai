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
Route::get('/login', function () {
    return view('login');
});
Route::get('/viewItem', function () {
    return view('viewItem');
});
Route::get('/tagsList', function () {
    return view('tagsList');
});
Route::get('/registrationStatistic', function () {
    return view('registrationStatistic');
});
Route::get('/registrationList', function () {
    return view('registrationList');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/problemsList', function () {
    return view('problemsList');
});
Route::get('/personalHistory', function () {
    return view('personalHistory');
});
Route::get('/otherProfile', function () {
    return view('otherProfile');
});
Route::get('/newItem', function () {
    return view('newItem');
});
Route::get('/myProfile', function () {
    return view('myProfile');
});
Route::get('/myCatalog', function () {
    return view('myCatalog');
});
Route::get('/catalog', function () {
    return view('catalog');
});
Route::get('/blockedUsersList', function () {
    return view('blockedUsersList');
});
Route::post('/logs', 'UserController@logs');

Route::post('/store', 'UserController@store');

Route::get('/logout', 'UserController@logout');

Route::post('/editClient', 'UserController@editClient');

Route::post('/unblock', 'AdminController@unblock');

Route::post('/block', 'AdminController@block');

Route::post('/addNew', [
    'as'=>'image.add',
    'uses'=>'ImageController@addNew'
]);

Route::post('/removeItem', 'ItemController@removeItem');

Route::post('/addTag', 'ItemController@addTag');

Route::post('/removeTag', 'ItemController@removeTag');

Route::post('/addToBasket', 'ItemController@addToBasket');

Route::post('/search', 'ItemController@search');

Route::post('/filter', 'ItemController@filter');

Route::post('/reservations', 'ItemController@reservations');

Route::post('/addRecomendation', 'UserController@addRecomendation');

Route::post('/addProblem', 'UserController@addProblem');

Route::post('/deleteUser', 'UserController@deleteUser');