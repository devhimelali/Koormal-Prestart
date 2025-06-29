<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ShiftController;
use App\Http\Controllers\admin\ShiftRotationController;
use App\Http\Controllers\admin\RotationSettingController;

Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');

    // Shifts
    Route::resource('shifts', ShiftController::class)->except(['show', 'create']);
    Route::get('get-shift-list', [ShiftController::class, 'getShitList'])->name('shifts.get-shift-List');

    // Rotation Settings
    Route::resource('rotation-settings', RotationSettingController::class)
        ->except(['show', 'create']);

    // Shift Rotations
    Route::resource('shift-rotations', ShiftRotationController::class)
        ->except(['show', 'create']);
});
