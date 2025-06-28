<?php

use App\Http\Controllers\admin\ShiftController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');

    // Shifts
    Route::resource('shifts', ShiftController::class)->except(['show', 'create']);
    Route::get('get-shift-list', [ShiftController::class, 'getShitList'])->name('shifts.get-shift-List');
});
