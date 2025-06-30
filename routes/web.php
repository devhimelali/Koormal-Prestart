<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/redirect', [RedirectController::class, 'redirect'])->name('redirect')->middleware('auth');
Route::get('{role}/profile', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/', function () {
    return view('auth.login');
})->middleware('auth.redirect')->name('login');

Route::get('clear-cache', function () {
    Artisan::call('optimize:clear');
    $output = Artisan::output();
    return redirect()->back()->with('status', 'Cache cleared successfully! Output: ' . $output);
})->name('clear.cache');
