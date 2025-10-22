<?php

use Illuminate\Support\Facades\Route;

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
    return view('front/index');
});


Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => false
]);

Route::get('/home', function () {
    return redirect('/admin/index');
});


Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/index', [App\Http\Controllers\Admin\IndexController::class, 'index']);
    Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('/admin/users/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'user']);
    Route::post('/admin/users/{user_id}/update', [App\Http\Controllers\Admin\UserController::class, 'update']);

    Route::get('/admin/orders', [App\Http\Controllers\Admin\OrderController::class, 'index']);
    Route::get('/admin/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show']);
    Route::post('/admin/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update']);
});
