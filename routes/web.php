<?php

use App\Http\Controllers\Child\BookController as ChildBookController;
use App\Http\Controllers\Parent\BookController as ParentBookController;
use App\Http\Controllers\Parent\BookPageController as ParentBookPageController;
use App\Http\Controllers\Parent\ExportController;
use App\Http\Controllers\RedirectController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

//Redirect Route
Route::get('/', [RedirectController::class, 'index'])->name('books');

//Child Panel
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:'.User::CHILD,
])->group(callback: function () {
    Route::prefix('books')->group(function () {
        //Home
        Route::get('/', [ChildBookController::class, 'index'])->name('child.books');
        //Cover, Page, Sound Serve
        Route::get('cover/{id}', [ChildBookController::class, 'cover'])->name('child.books.cover');
        Route::get('page/{id}', [ChildBookController::class, 'page'])->name('child.books.page');
        Route::get('sound/{id}', [ChildBookController::class, 'sound'])->name('child.books.sound');
        //Book Detail
        Route::get('{id}', [ChildBookController::class, 'show'])->name('child.books.show');
    });
});

//Parent Panel
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:'.User::PARENT,
])->prefix('admin')->group(callback: function () {

    //Books
    Route::prefix('books')->group(function () {
        Route::get('/', [ParentBookController::class, 'index'])->name('books');
        Route::get('data', [ParentBookController::class, 'data'])->name('books.data');
        Route::get('add', [ParentBookController::class, 'add'])->name('books.add');
        Route::post('save', [ParentBookController::class, 'save'])->name('books.save');
        Route::get('edit/{id}', [ParentBookController::class, 'edit'])->name('books.edit');
        Route::post('update/{id}', [ParentBookController::class, 'update'])->name('books.update');
        Route::post('delete/{id}', [ParentBookController::class, 'delete'])->name('books.delete');
        Route::get('serve/{id}', [ParentBookController::class, 'serve'])->name('books.serve');
    });

    //Book Pages
    Route::prefix('book-pages/{bookId}')->group(function () {
        Route::get('/', [ParentBookPageController::class, 'index'])->name('books.page');
        Route::get('data', [ParentBookPageController::class, 'data'])->name('books.page.data');
        Route::get('add', [ParentBookPageController::class, 'add'])->name('books.page.add');
        Route::post('save', [ParentBookPageController::class, 'save'])->name('books.page.save');
        Route::get('add/multiple', [ParentBookPageController::class, 'addMultiple'])->name('books.page.add.multiple');
        Route::post('save/multiple', [ParentBookPageController::class, 'saveMultiple'])->name('books.page.save.multiple');
        Route::get('edit/{id}', [ParentBookPageController::class, 'edit'])->name('books.page.edit');
        Route::post('update/{id}', [ParentBookPageController::class, 'update'])->name('books.page.update');
        Route::post('delete/{id}', [ParentBookPageController::class, 'delete'])->name('books.page.delete');
        Route::get('serve/{id}', [ParentBookPageController::class, 'serve'])->name('books.page.serve');
    });

    //Book Export
    Route::prefix('books/export')->group(function () {
        Route::get('/', [ExportController::class, 'index'])->name('export');
        Route::post('download', [ExportController::class, 'download'])->name('export.download');
    });

});
