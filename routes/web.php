<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/home', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/home/create', [UserController::class, 'create'])
    ->name('users.create');

Route::post('/home', [UserController::class, 'store'])
    ->name('users.store');

Route::get('/home/{id}', [UserController::class, 'show'])
    ->name('users.show');

Route::delete('/home/{id}', [UserController::class, 'destroy'])
    ->name('users.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
