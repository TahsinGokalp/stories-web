<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookPageController;
use Illuminate\Support\Facades\Route;

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
        Route::get('serve/{id}', [BookController::class, 'serve'])->name('books.serve');
    });

    //Book Pages
    Route::prefix('book-pages/{bookId}')->group(function () {
        Route::get('/', [BookPageController::class, 'index'])->name('books.page');
        Route::get('add', [BookPageController::class, 'add'])->name('books.page.add');
        Route::post('save', [BookPageController::class, 'save'])->name('books.page.save');
        Route::get('edit/{id}', [BookPageController::class, 'edit'])->name('books.page.edit');
        Route::post('update/{id}', [BookPageController::class, 'update'])->name('books.page.update');
        Route::post('delete/{id}', [BookPageController::class, 'delete'])->name('books.page.delete');
        Route::get('serve/{id}', [BookPageController::class, 'serve'])->name('books.page.serve');
    });

});
