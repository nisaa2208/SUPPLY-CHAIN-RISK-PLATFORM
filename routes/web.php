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
    | 1. Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | 2. Informasi Negara & 9. Perbandingan Negara
    |--------------------------------------------------------------------------
    */
    Route::get('/countries/compare', [CountryController::class, 'compare'])
        ->name('countries.compare');

    Route::post('/countries/sync-live', [CountryController::class, 'syncLiveApi'])
        ->name('countries.sync.live');

    Route::resource('countries', CountryController::class);

    /*
    |--------------------------------------------------------------------------
    | 3. Analisis Risiko
    |--------------------------------------------------------------------------
    */
    Route::get('/analytics', [DashboardController::class, 'analytics'])
        ->name('analytics');

    /*
    |--------------------------------------------------------------------------
    | 4. Monitoring Cuaca
    |--------------------------------------------------------------------------
    */
    Route::get('/weather', [WeatherController::class, 'index'])
        ->name('weather.index');

    Route::get('/api/weather/data', [WeatherController::class, 'getWeatherData'])
        ->name('weather.data');

    /*
    |--------------------------------------------------------------------------
    | 5. Nilai Tukar Mata Uang
    |--------------------------------------------------------------------------
    */
    Route::get('/exchange-rate', [ExchangeRateController::class, 'index'])
        ->name('exchange.index');

    /*
    |--------------------------------------------------------------------------
    | 6. Berita Global
    |--------------------------------------------------------------------------
    */
    Route::get('/news', [NewsController::class, 'index'])
        ->name('news.index');

    Route::get('/api/news/live', [NewsController::class, 'getLiveNews'])
        ->name('news.live');

    /*
    |--------------------------------------------------------------------------
    | 7. Lokasi Pelabuhan
    |--------------------------------------------------------------------------
    */
    Route::get('/ports', [\App\Http\Controllers\PortController::class, 'index'])
        ->name('ports.index');

    /*
    |--------------------------------------------------------------------------
    | 8. Visualisasi Data
    |--------------------------------------------------------------------------
    */
    Route::get('/world-map', [CountryController::class, 'map'])
        ->name('world.map');

    /*
    |--------------------------------------------------------------------------
    | 10. Daftar Favorit
    |--------------------------------------------------------------------------
    */
    Route::get('/favorites', [\App\Http\Controllers\WatchlistController::class, 'index'])
        ->name('favorites.index');

    Route::post('/favorites/toggle/{country}', [\App\Http\Controllers\WatchlistController::class, 'toggle'])
        ->name('favorites.toggle');

    /*
    |--------------------------------------------------------------------------
    | Secondary Resources & Management
    |--------------------------------------------------------------------------
    */
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('reports', ReportController::class);
    Route::get('/export/pdf', [ExportController::class, 'exportPDF'])->name('export.pdf');
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/global-alert', [GlobalAlertController::class, 'index'])->name('global.alert');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    Route::prefix('api')->group(function () {
        Route::get('/countries', [ApiController::class, 'countries'])->name('api.countries');
        Route::get('/weather', [WeatherController::class, 'index'])->name('api.weather');
        Route::get('/exchange-rate', [ExchangeRateController::class, 'index'])->name('api.exchange');
        Route::get('/world-bank', [WorldBankController::class, 'index'])->name('api.worldbank');
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
| Public REST API Endpoints (Project Final Specifications - PDF Page 9)
|--------------------------------------------------------------------------
*/
Route::get('/api/countries', [ApiController::class, 'apiCountries'])->name('rest.countries');
Route::get('/api/countries/compare/live', [CountryController::class, 'compareLive'])->name('countries.compare.live');
Route::get('/api/risk', [ApiController::class, 'apiRisk'])->name('rest.risk');
Route::get('/api/ports', [ApiController::class, 'apiPorts'])->name('rest.ports');
Route::get('/api/ports/live', [\App\Http\Controllers\PortController::class, 'getLivePorts'])->name('ports.live');
Route::get('/api/news', [ApiController::class, 'apiNews'])->name('rest.news');
Route::get('/api/news/live', [NewsController::class, 'getLiveNews'])->name('news.live');
Route::get('/api/currency', [ApiController::class, 'apiCurrency'])->name('rest.currency');
Route::get('/api/currency/live', [ExchangeRateController::class, 'getLiveRates'])->name('exchange.live');

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect()->route('dashboard');
});

require __DIR__.'/auth.php';