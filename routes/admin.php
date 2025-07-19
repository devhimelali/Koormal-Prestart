<?php

use App\Http\Controllers\admin\BoardController;
use App\Http\Controllers\admin\CrossCriteriaController;
use App\Http\Controllers\admin\HealthSafetyReviewController;
use App\Http\Controllers\admin\RosterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ShiftController;
use App\Http\Controllers\admin\ShiftRotationController;

Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');

    // Shifts
    Route::resource('shifts', ShiftController::class)->except(['show', 'create']);
    Route::get('get-shift-list', [ShiftController::class, 'getShiftList'])->name('shifts.get-shift-List');

    // Shift Rotations
    Route::get('shift-rotations', [ShiftRotationController::class, 'edit'])->name('shift-rotations.edit');
    Route::post('shift-rotations', [ShiftRotationController::class, 'update'])->name('shift-rotations.update');
    Route::get('stop-rotation', [ShiftRotationController::class, 'stop'])->name('shift-rotations.stop');
    Route::get('check-shift', [ShiftRotationController::class, 'checkForm'])->name('rotation.check.form');
    Route::post('check-shift', [ShiftRotationController::class, 'checkResult'])->name('rotation.check.result');
    Route::get('rosters', [RosterController::class, 'showNextMonthSchedule'])->name('rosters.index');
    Route::get('roster-fetch', [ShiftRotationController::class, 'applyDataRangeFilter'])->name('roster.fetch');
    Route::get('health-safety-review', [HealthSafetyReviewController::class, 'index'])->name('health-safety-review.index')->middleware('daily.shift.entry');
    Route::post('health-safety-review', [HealthSafetyReviewController::class, 'store'])->name('health-safety-review.store');
    Route::resource('cross-criteria', CrossCriteriaController::class);



    Route::get('boards', [BoardController::class, 'index'])->name('boards.index')->middleware('daily.shift.entry');
    Route::post('update-supervisor-name', [BoardController::class, 'updateSupervisorName'])->name('boards.updateSupervisorName');
    Route::post('show-board', [BoardController::class, 'show'])->name('boards.show.board');
    Route::post('store-health-safety-review', [BoardController::class, 'storeHealthSafetyReview'])->name('boards.store.health-safety-review');
    Route::post('store-health-safety-cross-criteria', [BoardController::class, 'storeHealthSafetyCrossCriteria'])->name('boards.store.health-safety-cross-criteria');
});
