<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoController;

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

Route::get('/', [ToDoController::class, 'index']);
Route::post('/add', [ToDoController::class, 'addData'])->name('add');
Route::post('/del', [ToDoController::class, 'delData'])->name('del');
Route::post('/list', [ToDoController::class, 'listData'])->name('list');

