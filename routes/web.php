<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LanguageController;

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
        Route::get('/countries/edit/{id}/{language_id}/{default_language_post_id}', [CountryController::class, 'edit'])->name('countries.edit');
        Route::post('/countries/update/{id}/{language_id}/{default_language_post_id}', [CountryController::class, 'update'])->name('countries.update');
        Route::get('/sub-country/add/{id}/{language_id}', [CountryController::class, 'addSubCountry'])->name('sub-country.add');
        Route::post('/sub-country/store/{id}/{language_id}', [CountryController::class, 'storeSubCountry'])->name('sub-country.store');
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
        Route::get('/leagues/edit/{id}/{language_id}/{default_language_post_id}', [LeagueController::class, 'edit'])->name('leagues.edit');
        Route::post('/leagues/update/{id}/{language_id}/{default_language_post_id}', [LeagueController::class, 'update'])->name('leagues.update');
        Route::get('/sub-league/add/{id}/{language_id}', [LeagueController::class, 'addSubLeague'])->name('sub-league.add');
        Route::post('/sub-league/store/{id}/{language_id}', [LeagueController::class, 'storeSubLeague'])->name('sub-league.store');
        Route::post('/leagues/delete', [LeagueController::class, 'delete'])->name('leagues.delete');

        //Season
        Route::get('/seasons', [SeasonController::class, 'index'])->name('seasons.index');
        Route::get('/seasons/data', [SeasonController::class, 'data'])->name('seasons.data');
        Route::get('/seasons/create', [SeasonController::class, 'create'])->name('seasons.create');
        Route::post('/seasons/store', [SeasonController::class, 'store'])->name('seasons.store');
        Route::get('/seasons/edit/{id}', [SeasonController::class, 'edit'])->name('seasons.edit');
        Route::post('/seasons/update/{id}', [SeasonController::class, 'update'])->name('seasons.update');
        Route::post('/seasons/delete', [SeasonController::class, 'delete'])->name('seasons.delete');

        //Team
        Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
        Route::get('/teams/data', [TeamController::class, 'data'])->name('teams.data');
        Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
        Route::post('/teams/store', [TeamController::class, 'store'])->name('teams.store');
        Route::get('/teams/edit/{id}/{language_id}/{default_language_post_id}', [TeamController::class, 'edit'])->name('teams.edit');
        Route::post('/teams/update/{id}/{language_id}/{default_language_post_id}', [TeamController::class, 'update'])->name('teams.update');
        Route::get('/sub-team/add/{id}/{language_id}', [TeamController::class, 'addSubTeam'])->name('sub-team.add');
        Route::post('/sub-team/store/{id}/{language_id}', [TeamController::class, 'storeSubTeam'])->name('sub-team.store');
        Route::post('/teams/delete', [TeamController::class, 'delete'])->name('teams.delete');

        //Round
        Route::get('/rounds', [RoundController::class, 'index'])->name('rounds.index');
        Route::get('/rounds/data', [RoundController::class, 'data'])->name('rounds.data');
        Route::get('/rounds/create', [RoundController::class, 'create'])->name('rounds.create');
        Route::post('/rounds/store', [RoundController::class, 'store'])->name('rounds.store');
        Route::get('/rounds/edit/{id}/{language_id}/{default_language_post_id}', [RoundController::class, 'edit'])->name('rounds.edit');
        Route::post('/rounds/update/{id}/{language_id}/{default_language_post_id}', [RoundController::class, 'update'])->name('rounds.update');
        Route::get('/sub-round/add/{id}/{language_id}', [RoundController::class, 'addSubRound'])->name('sub-round.add');
        Route::post('/sub-round/store/{id}/{language_id}', [RoundController::class, 'storeSubRound'])->name('sub-round.store');
        Route::post('/rounds/delete', [RoundController::class, 'delete'])->name('rounds.delete');

        //Match
        Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
        Route::get('/matches/data', [MatchController::class, 'data'])->name('matches.data');
        Route::get('/matches/create', [MatchController::class, 'create'])->name('matches.create');
        Route::post('/matches/create', [MatchController::class, 'store'])->name('matches.store');
        Route::get('/matches/edit/{id}/{language_id}/{default_language_post_id}', [MatchController::class, 'edit'])->name('matches.edit');
        Route::get('/matches/add/{id}/{language_id}', [MatchController::class, 'addSubRound'])->name('sub-match.add');
        Route::post('/matches/delete', [MatchController::class, 'delete'])->name('matches.delete');
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
