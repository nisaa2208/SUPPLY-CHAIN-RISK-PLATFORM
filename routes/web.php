<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GlobalAlertController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\WorldBankController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/dashboard');

/*
|--------------------------------------------------------------------------
| Authentication Required
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/analytics', [DashboardController::class, 'analytics'])
        ->name('analytics');

    Route::get('/api/dashboard-data', [DashboardController::class, 'dashboardData'])
        ->name('dashboard.data');

    /*
    |--------------------------------------------------------------------------
    | About
    |--------------------------------------------------------------------------
    */

    Route::get('/about', [AboutController::class, 'index'])
        ->name('about');

    /*
    |--------------------------------------------------------------------------
    | Master Data
    |--------------------------------------------------------------------------
    */

    Route::resource('countries', CountryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | Monitoring & World Map
    |--------------------------------------------------------------------------
    */

    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring');

    Route::get('/world-map', [CountryController::class, 'map'])
        ->name('world.map');

    Route::get('/api/world-map', [CountryController::class, 'mapData'])
        ->name('api.world.map');

    Route::get('/global-alert', [GlobalAlertController::class, 'index'])
        ->name('global.alert');

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications');

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::resource('reports', ReportController::class);

    Route::get('/export/pdf', [ExportController::class, 'exportPDF'])
        ->name('export.pdf');

    Route::get('/export/excel', [ExportController::class, 'exportExcel'])
        ->name('export.excel');

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    Route::get('/search', [SearchController::class, 'index'])
        ->name('search');

    /*
    |--------------------------------------------------------------------------
    | News
    |--------------------------------------------------------------------------
    */

    Route::get('/news', [NewsController::class, 'index'])
        ->name('news.index');

    /*
    |--------------------------------------------------------------------------
    | External API
    |--------------------------------------------------------------------------
    */

    Route::prefix('api')->group(function () {

        Route::get('/countries', [ApiController::class, 'countries'])
            ->name('api.countries');

        Route::get('/weather', [WeatherController::class, 'index'])
            ->name('api.weather');

        Route::get('/exchange-rate', [ExchangeRateController::class, 'index'])
            ->name('api.exchange');

        Route::get('/world-bank', [WorldBankController::class, 'index'])
            ->name('api.worldbank');
    });

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Development
    |--------------------------------------------------------------------------
    */

    Route::get('/health', function () {

        return response()->json([
            'status'      => 'OK',
            'application' => config('app.name'),
            'laravel'     => app()->version(),
            'php'         => PHP_VERSION,
            'time'        => now()->toDateTimeString(),
        ]);

    })->name('health');

    Route::get('/clear-cache', function () {

        Artisan::call('optimize:clear');

        return back()->with(
            'success',
            'Application cache cleared successfully.'
        );

    })->name('clear.cache');

});

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';