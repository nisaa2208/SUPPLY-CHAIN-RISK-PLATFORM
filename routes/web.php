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
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);

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
    | Reports
    |--------------------------------------------------------------------------
    */
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/report', [\App\Http\Controllers\ReportController::class, 'index'])
        ->name('report.index');

    /*
    |--------------------------------------------------------------------------
    | Admin Only Management Routes (PDF Spec Hal 6)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', [\App\Http\Controllers\AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::resource('users', UserController::class);

        Route::get('/ports/create', [\App\Http\Controllers\PortController::class, 'create'])->name('ports.create');
        Route::post('/ports', [\App\Http\Controllers\PortController::class, 'store'])->name('ports.store');
        Route::get('/ports/{port}/edit', [\App\Http\Controllers\PortController::class, 'edit'])->name('ports.edit');
        Route::put('/ports/{port}', [\App\Http\Controllers\PortController::class, 'update'])->name('ports.update');
        Route::delete('/ports/{port}', [\App\Http\Controllers\PortController::class, 'destroy'])->name('ports.destroy');

        Route::get('/articles/create', [\App\Http\Controllers\ArticleController::class, 'create'])->name('articles.create');
        Route::post('/articles', [\App\Http\Controllers\ArticleController::class, 'store'])->name('articles.store');
        Route::get('/articles/{article}/edit', [\App\Http\Controllers\ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('/articles/{article}', [\App\Http\Controllers\ArticleController::class, 'update'])->name('articles.update');
        Route::get('/admin/ai-sentiment', [\App\Http\Controllers\AiSentimentController::class, 'index'])->name('admin.ai.sentiment');
        Route::post('/admin/ai-sentiment/positive', [\App\Http\Controllers\AiSentimentController::class, 'addPositiveWord'])->name('admin.ai.positive.add');
        Route::delete('/admin/ai-sentiment/positive/{id}', [\App\Http\Controllers\AiSentimentController::class, 'deletePositiveWord'])->name('admin.ai.positive.delete');
        Route::post('/admin/ai-sentiment/negative', [\App\Http\Controllers\AiSentimentController::class, 'addNegativeWord'])->name('admin.ai.negative.add');
        Route::delete('/admin/ai-sentiment/negative/{id}', [\App\Http\Controllers\AiSentimentController::class, 'deleteNegativeWord'])->name('admin.ai.negative.delete');
    });

    Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

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
Route::get('/api/weather/data', [WeatherController::class, 'getWeatherData'])->name('weather.data');
Route::get('/api/weather/live', [WeatherController::class, 'getWeatherData'])->name('weather.live');

/*
|--------------------------------------------------------------------------
| Quick Logout Endpoint (GET /logout)
|--------------------------------------------------------------------------
*/
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('success', 'Anda telah berhasil logout.');
})->name('logout.get');

Route::fallback(function () {
    return redirect()->route('dashboard');
});

require __DIR__.'/auth.php';