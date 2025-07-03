<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ShiftController;
use App\Http\Controllers\admin\ShiftRotationController;
use App\Http\Controllers\admin\RotationSettingController;
use App\Models\ShiftRotation;

Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');

    // Shifts
    Route::resource('shifts', ShiftController::class)->except(['show', 'create']);
    Route::get('get-shift-list', [ShiftController::class, 'getShitList'])->name('shifts.get-shift-List');

    // Shift Rotations
    Route::get('shift-rotations', [ShiftRotationController::class, 'edit'])->name('shift-rotations.edit');
    Route::post('shift-rotations', [ShiftRotationController::class, 'update'])->name('shift-rotations.update');
    Route::get('check-shift', [ShiftRotationController::class, 'checkForm'])->name('rotation.check.form');
    Route::post('check-shift', [ShiftRotationController::class, 'checkResult'])->name('rotation.check.result');
    Route::get('list', [ShiftRotationController::class, 'showNextMonthSchedule'])->name('shift-rotations.next-month-schedule');

});
