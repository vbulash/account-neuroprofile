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

// Example Routes
Route::view('/', 'landing')->name('home');
Route::match(['get', 'post'], '/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::view('/pages/slick', 'pages.slick')->name('pages.slick');
Route::view('/pages/datatables', 'pages.datatables')->name('pages.datatables');
Route::view('/pages/blank', 'pages.blank')->name('pages.blank');