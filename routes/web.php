<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LicenseController;

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

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', function () {
		return view('dashboard');
	})->name('dashboard');
	Route::view('/pages/slick', 'pages.slick')->name('pages.slick');
	Route::view('/pages/datatables', 'pages.datatables')->name('pages.datatables');
	Route::view('/pages/blank', 'pages.blank')->name('pages.blank');

	// Клиенты
	Route::get('/clients/{client}', [ClientController::class, 'show'])->name(('clients.show'));
	Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name(('clients.edit'));
	Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
	// Контракты клиента
	Route::get('/clients/{client}/contracts/{contract}', [ContractController::class, 'show'])->name('clients.contracts.show');
	Route::get('/clients/{client}/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('clients.contracts.edit');
	Route::put('/clients/{client}/contracts/{contract}', [ContractController::class, 'update'])->name('clients.contracts.update');
	// Лицензии контракта
	Route::get('/contracts/{contract}/licenses', [LicenseController::class, 'index'])->name('contracts.licenses.index');
	Route::get('/contracts/{contract}/licenses.data', [LicenseController::class, 'getData'])->name('contracts.licenses.index.data');
	Route::post('/contracts/{contract}/licenses.export', [LicenseController::class, 'export'])->name('contracts.licenses.export');
	Route::post('/contracts/{contract}/licenses.repair', [LicenseController::class, 'repair'])->name('contracts.licenses.repair');
	Route::post('/contracts/{contract}/licenses.info', [LicenseController::class, 'info'])->name('contracts.licenses.info');
	// Результаты прохождения (история) тестирования
	Route::get('/contracts/{contract}/history', [HistoryController::class, 'index'])->name('contracts.history.index');
	Route::get('/contracts/{contract}/history.data', [HistoryController::class, 'getData'])->name('contracts.history.index.data');
	Route::post('/contracts/{contract}/history.export', [HistoryController::class, 'export'])->name('contracts.history.export');
});

Route::group(['middleware' => 'web'], function () {
	Route::get('register', [RegisteredUserController::class, 'create'])
		->name('register');

	Route::post('register', [RegisteredUserController::class, 'store']);

	Route::get('login', [AuthenticatedSessionController::class, 'create'])
		->name('login');

	Route::post('login', [AuthenticatedSessionController::class, 'store']);

	Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
		->name('password.request');

	Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
		->name('password.email');

	Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
		->name('password.reset');

	Route::post('reset-password', [NewPasswordController::class, 'store'])
		->name('password.update');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
		->name('verification.notice');

	Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
		->middleware(['signed', 'throttle:6,1'])
		->name('verification.verify');

	Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
		->middleware('throttle:6,1')
		->name('verification.send');

	Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
		->name('password.confirm');

	Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

	//    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
//                ->name('logout');

	Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
		->name('logout');
});