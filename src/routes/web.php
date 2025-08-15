<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserRegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/thanks', fn () => view('thanks'))->name('contacts.thanks');

Route::get('/register', [UserRegistrationController::class, 'create'])->name('register');
Route::post('/register', [UserRegistrationController::class, 'store'])->name('register.store');

Route::post('/sessions', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout',   [LoginController::class, 'destroy'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('contacts.index');

    Route::get('/contacts/export', [AdminController::class, 'export'])->name('contacts.export');

    Route::get('/contacts/{contact}', [AdminController::class, 'show'])->name('contacts.show');

    Route::delete('/contacts/{contact}', [AdminController::class, 'destroy'])->name('contacts.destroy');
});
Route::get('/login', fn () => view('auth.login'))->name('login');
