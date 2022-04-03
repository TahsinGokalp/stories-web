<?php

use App\Http\Controllers\BookController;
use App\Http\Livewire\Book;
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

Route::get('/', static function () {
    return view('welcome');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(callback: function () {
    Route::get('/dashboard', static function () {return view('dashboard');})->name('dashboard');

    //Books
    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('books');
        Route::get('add', [BookController::class, 'add'])->name('books.add');
        Route::post('save', [BookController::class, 'save'])->name('books.save');
        Route::get('edit/{id}', [BookController::class, 'edit'])->name('books.edit');
        Route::post('update/{id}', [BookController::class, 'update'])->name('books.update');
        Route::post('delete/{id}', [BookController::class, 'delete'])->name('books.delete');
    });


});
