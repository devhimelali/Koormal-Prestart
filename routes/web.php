<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\RedirectController;

Route::get('/redirect', [RedirectController::class, 'redirect'])->name('redirect')->middleware('auth');
Route::get('{role}/profile', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/', function () {
    return view('auth.login');
})->middleware('auth.redirect')->name('login');

Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload')->middleware('auth');


Route::get('clear-cache', function () {
    Artisan::call('optimize:clear');
    $output = Artisan::output();
    return redirect()->back()->with('status', 'Cache cleared successfully! Output: '.$output);
})->name('clear.cache');


Route::get('storage-link', function () {
    Artisan::call('storage:link');
    $output = Artisan::output();
    return redirect()->back()->with('status', 'Storage linked successfully! Output: '.$output);
});

Route::get('/archived-board', [\App\Http\Controllers\admin\ArchiveController::class, 'archivedAllBoards'])->name('archived-board');
