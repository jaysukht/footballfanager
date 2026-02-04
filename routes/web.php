<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LeagueController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin/dashboard');
    }
    return redirect()->route('login');
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
        Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
        Route::get('/countries/data', [CountryController::class, 'data'])->name('countries.data');
        Route::get('/countries/create', [CountryController::class, 'create'])->name('countries.create');
        Route::post('/countries/store', [CountryController::class, 'store'])->name('countries.store');
        Route::get('/countries/edit/{id}', [CountryController::class, 'edit'])->name('countries.edit');
        Route::post('/countries/update/{id}', [CountryController::class, 'update'])->name('countries.update');
        Route::post('/countries/delete', [CountryController::class, 'delete'])->name('countries.delete');

        // Language Routes
        Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');
        Route::get('/languages/data', [LanguageController::class, 'data'])->name('languages.data');
        Route::get('/languages/create', [LanguageController::class, 'create'])->name('languages.create');
        Route::post('/languages/store', [LanguageController::class, 'store'])->name('languages.store');
        Route::get('/languages/edit/{id}', [LanguageController::class, 'edit'])->name('languages.edit');
        Route::post('/languages/update/{id}', [LanguageController::class, 'update'])->name('languages.update');
        Route::post('/languages/delete', [LanguageController::class, 'delete'])->name('languages.delete');

        // League Routes
        Route::get('/leagues', [LeagueController::class, 'index'])->name('leagues.index');
        Route::get('/leagues/data', [LeagueController::class, 'data'])->name('leagues.data');
        Route::get('/leagues/create', [LeagueController::class, 'create'])->name('leagues.create');
        Route::post('/leagues/store', [LeagueController::class, 'store'])->name('leagues.store');
        Route::get('/leagues/edit/{id}', [LeagueController::class, 'edit'])->name('leagues.edit');
        Route::post('/leagues/update/{id}', [LeagueController::class, 'update'])->name('leagues.update');
        Route::post('/leagues/delete', [LeagueController::class, 'delete'])->name('leagues.delete');
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cleared!";
});
