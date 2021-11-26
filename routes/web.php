<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

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
    return view('welcome', [
        'books' => Book::get()
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class)->only(['index', 'store','update','destroy'])->names('categories');
Route::post('list-category-filter', [CategoryController::class, 'listCategoryFilter'])->name('list-category-filter');
Route::post('banned-category/{id}', [CategoryController::class, 'banned'])->name('banned-category');

Route::resource('books', BookController::class)->only(['index', 'store','update','destroy'])->names('books');
Route::post('list-book-filter', [BookController::class, 'listBookFilter'])->name('list-book-filter');
Route::post('banned-book/{id}', [BookController::class, 'banned'])->name('banned-book');
Route::post('borrow-book', [BookController::class, 'borrow'])->name('borrow-book');
Route::post('return-book/{id}', [BookController::class, 'returnBook'])->name('return-book');