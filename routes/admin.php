<?php

use App\Http\Controllers\admin\BoardController;
use App\Http\Controllers\admin\CrossCriteriaController;
use App\Http\Controllers\admin\FatalityControlController;
use App\Http\Controllers\admin\FatalityRiskControlController;
use App\Http\Controllers\admin\FatalityRiskController;
use App\Http\Controllers\admin\HealthSafetyReviewController;
use App\Http\Controllers\admin\RosterController;
use App\Http\Controllers\admin\ShiftController;
use App\Http\Controllers\admin\ShiftRotationController;
use App\Http\Controllers\admin\SiteCommunicationController;
use Illuminate\Support\Facades\Route;

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
    Route::get('health-safety-review', [
        HealthSafetyReviewController::class, 'index'
    ])->name('health-safety-review.index');
    Route::post('health-safety-review',
        [HealthSafetyReviewController::class, 'store'])->name('health-safety-review.store');
    Route::resource('cross-criteria', CrossCriteriaController::class);
    Route::resource('fatality-risks', FatalityRiskController::class);
    Route::resource('fatality-controls', FatalityControlController::class);
    Route::get('get-fatality-risk-list',
        [FatalityRiskController::class, 'getFatalityRisksList'])->name('fatality-risks.get-list');
    Route::get('hazard-controls',
        [BoardController::class, 'getHazardControlList'])->name('hazard-controls.index');
    Route::post('hazard-controls',
        [BoardController::class, 'storeHazardControl'])->name('hazard-controls.store');
    Route::post('delete-hazard-controls',
        [BoardController::class, 'destroyHazardControl'])->name('hazard-controls.destroy');
    Route::get('get-fatality-controls-list',
        [BoardController::class, 'getFatalityControlList'])->name('get-fatality-controls-list');
    Route::post('store-fatality-control',
        [BoardController::class, 'storeFatalityControl'])->name('store-fatality-control');

    Route::get('boards', [BoardController::class, 'index'])->name('boards.index');
    Route::post('update-supervisor-name',
        [BoardController::class, 'updateSupervisorName'])->name('boards.updateSupervisorName');
    Route::post('show-board', [BoardController::class, 'show'])->name('boards.show.board');
    Route::post('store-health-safety-review',
        [BoardController::class, 'storeHealthSafetyReview'])->name('boards.store.health-safety-review');
    Route::post('store-health-safety-cross-criteria',
        [BoardController::class, 'storeHealthSafetyCrossCriteria'])->name('boards.store.health-safety-cross-criteria');
    Route::post('reset-safety-calendar',
        [BoardController::class, 'resetSafetyCalendar'])->name('boards.reset.safety-calendar');
    Route::post('store-productive-question',
        [BoardController::class, 'storeProductiveQuestion'])->name('boards.store.productive-question');
    Route::post('store-celebrate-success',
        [BoardController::class, 'storeCelebrateSuccess'])->name('boards.store.celebrate-success');
    Route::post('store-site-communication',
        [BoardController::class, 'storeSiteCommunication'])->name('boards.store.site-communication');
    Route::resource('fatality-risk-controls', FatalityRiskControlController::class);
    Route::get('get-supervisor-and-labour-list/{shift_type}',
        [BoardController::class, 'getSupervisorAndLabourList'])->name('boards.get-supervisor-and-labour-list');
    Route::post('assign-fatality-risk-control',
        [BoardController::class, 'assignFatalityRiskControl'])->name('fatality-risk-controls.assign');
    Route::post('delete-fatality-risk-control-image',
        [BoardController::class, 'deleteFatalityRiskControlImage'])->name('fatality-risk-controls.delete-image');
    Route::post('store-improve-performance',
        [BoardController::class, 'storeImprovePerformance'])->name('boards.store.improve-performance');
    Route::post('store-health-safety-focus',
        [BoardController::class, 'storeSafetyFocuses'])->name('boards.store.health-safety-focus');
    Route::post('store-fatal-risk-to-discuss',
        [BoardController::class, 'storeFatalRiskToDiscuss'])->name('boards.store.fatal-risk-to-discuss');
    Route::get('get-control-list-for-fatal-risk-to-discuss', [
        BoardController::class, 'getControlListForFatalRiskToDiscuss'
    ])->name('get-control-list-for-fatal-risk-to-discuss');
    Route::get('view-all-discuss-list', [BoardController::class, 'getAllDiscussList'])->name('boards.view-all-discuss-list');
    Route::post('delete-today-discuss-list', [BoardController::class, 'deleteTodayDiscussList'])->name('boards.delete-today-discuss-list');

    Route::resource('site-communications', SiteCommunicationController::class);
    Route::get('preview-site-communication/{path}',
        [SiteCommunicationController::class, 'preview'])->name('site-communications.preview');
});
