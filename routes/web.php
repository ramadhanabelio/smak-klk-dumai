<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('letters/incoming')
        ->name('letters.incoming.')
        ->controller(LetterController::class)
        ->group(function () {
            Route::get('/', 'incomingIndex')->name('index');
            Route::get('/create', 'createIncoming')->name('create');
            Route::post('/', 'storeIncoming')->name('store');
            Route::delete('/{id}', 'destroyIncoming')->name('destroy');
        });

    Route::prefix('letters/outgoing')
        ->name('letters.outgoing.')
        ->controller(LetterController::class)
        ->group(function () {
            Route::get('/', 'outgoingIndex')->name('index');
            Route::get('/create', 'createOutgoing')->name('create');
            Route::post('/', 'storeOutgoing')->name('store');
            Route::delete('/{id}', 'destroyOutgoing')->name('destroy');
        });

    Route::resource('employees', EmployeeController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('divisions', DivisionController::class);
});
