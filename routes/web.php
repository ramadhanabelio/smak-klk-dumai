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

    Route::resource('employees', EmployeeController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('divisions', DivisionController::class);
});

Route::prefix('letters')->controller(LetterController::class)->group(function () {
    Route::get('outgoing', 'outgoingIndex')->name('letters.outgoing.index');
    Route::get('outgoing/create', 'createOutgoing')->name('letters.outgoing.create');
    Route::post('outgoing', 'storeOutgoing')->name('letters.outgoing.store');
    Route::get('outgoing/{id}/edit', 'editOutgoing')->name('letters.outgoing.edit');
    Route::put('outgoing/{id}', 'updateOutgoing')->name('letters.outgoing.update');
    Route::delete('outgoing/{id}', 'destroyOutgoing')->name('letters.outgoing.destroy');
});
