<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BookingController;
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

Route::prefix('bookings')->name('bookings.')->group(function () {
    Route::get('/', [BookingController::class, 'stepOne'])->name('step.one');
    Route::post('/', [BookingController::class, 'handleStepOne'])->name('handle.step.one');

    Route::get('/details', [BookingController::class, 'stepTwo'])->name('step.two');
    Route::post('/complete', [BookingController::class, 'completeBooking'])->name('complete');

    Route::get('/success', [BookingController::class, 'success'])->name('success');
});

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

    Route::prefix('letters/booking')
        ->name('letters.booking.')
        ->controller(LetterController::class)
        ->group(function () {
            Route::get('/', 'bookingIndex')->name('index');
        });

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/download', [ReportController::class, 'download'])->name('reports.download');

    Route::resource('employees', EmployeeController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('divisions', DivisionController::class);
});

Route::get('/tes-bot', function () {
    \App\Services\Telegram::sendMessage("Bot Telegram SMaK KLK Dumai aktif");
    return 'Bot Telegram SMaK KLK Dumai aktif!';
});
