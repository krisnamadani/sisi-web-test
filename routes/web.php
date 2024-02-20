<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/login/post', 'App\Http\Controllers\AuthController@postLogin')->name('login.post');

Route::get('/register', 'App\Http\Controllers\AuthController@register')->name('register');
Route::post('/register/post', 'App\Http\Controllers\AuthController@postRegister')->name('register.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');

    Route::get('/user', 'App\Http\Controllers\UserController@index')->name('user');
    Route::get('/user/get', 'App\Http\Controllers\UserController@get')->name('user.get');
    Route::post('/user/store', 'App\Http\Controllers\UserController@store')->name('user.store');
    Route::get('/user/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('user.edit');
    Route::put('/user/update', 'App\Http\Controllers\UserController@update')->name('user.update');
    Route::delete('/user/{id}/destroy', 'App\Http\Controllers\UserController@destroy')->name('user.destroy');

    Route::get('/menu-level', 'App\Http\Controllers\MenuLevelController@index')->name('menu-level');
    Route::get('/menu-level/get', 'App\Http\Controllers\MenuLevelController@get')->name('menu-level.get');
    Route::post('/menu-level/store', 'App\Http\Controllers\MenuLevelController@store')->name('menu-level.store');
    Route::get('/menu-level/{id}/edit', 'App\Http\Controllers\MenuLevelController@edit')->name('menu-level.edit');
    Route::put('/menu-level/update', 'App\Http\Controllers\MenuLevelController@update')->name('menu-level.update');
    Route::delete('/menu-level/{id}/destroy', 'App\Http\Controllers\MenuLevelController@destroy')->name('menu-level.destroy');

    Route::get('/menu', 'App\Http\Controllers\MenuController@index')->name('menu');
    Route::get('/menu/get', 'App\Http\Controllers\MenuController@get')->name('menu.get');
    Route::post('/menu/store', 'App\Http\Controllers\MenuController@store')->name('menu.store');
    Route::get('/menu/{id}/edit', 'App\Http\Controllers\MenuController@edit')->name('menu.edit');
    Route::put('/menu/update', 'App\Http\Controllers\MenuController@update')->name('menu.update');
    Route::delete('/menu/{id}/destroy', 'App\Http\Controllers\MenuController@destroy')->name('menu.destroy');

    Route::get('/menu-user', 'App\Http\Controllers\MenuUserController@index')->name('menu-user');
    Route::get('/menu-user/get', 'App\Http\Controllers\MenuUserController@get')->name('menu-user.get');
    Route::post('/menu-user/store', 'App\Http\Controllers\MenuUserController@store')->name('menu-user.store');
    Route::get('/menu-user/{id}/edit', 'App\Http\Controllers\MenuUserController@edit')->name('menu-user.edit');
    Route::put('/menu-user/update', 'App\Http\Controllers\MenuUserController@update')->name('menu-user.update');
    Route::delete('/menu-user/{id}/destroy', 'App\Http\Controllers\MenuUserController@destroy')->name('menu-user.destroy');
});