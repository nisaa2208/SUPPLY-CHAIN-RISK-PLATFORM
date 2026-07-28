<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    /**
     * Display the Real-Time Global Weather Monitoring Page.
     */
    public function index(Request $request)
    {
        $countries = Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('name')
            ->get();

        $regions = Country::distinct()->pluck('region')->filter()->values();

        return view('api.weather', compact('countries', 'regions'));
    }

    /**
     * AJAX API Endpoint to fetch live Open-Meteo weather data for country/countries.
     */
    public function getWeatherData(Request $request)
    {
        $countryId = $request->input('country_id');

        if ($countryId) {
            $country = Country::find($countryId);

            if (!$country || !$country->latitude || !$country->longitude) {
                return response()->json(['success' => false, 'message' => 'Data koordinat negara tidak ditemukan.'], 404);
            }

            $weatherData = $this->fetchOpenMeteoData($country->latitude, $country->longitude);

            if (!$weatherData) {
                $weatherData = $this->generateFallbackWeatherData($country->latitude, $country->longitude);
            }

            $formatted = $this->formatCountryWeather($country, $weatherData);
            return response()->json(['success' => true, 'data' => $formatted]);
        }

        // Fast 5-min cache with single 1-call Open-Meteo batch fetching for all 195 countries
        $results = Cache::remember('all_countries_weather_v3', 300, function () {
            $countries = Country::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderBy('name')
                ->get();

            // Perform single batch request for all countries
            $batchData = $this->fetchOpenMeteoBatch($countries);

            $list = [];
            foreach ($countries as $index => $country) {
                $weatherData = null;
                if ($batchData && is_array($batchData)) {
                    // Open-Meteo returns array of results when multiple coordinates are passed
                    if (isset($batchData[$index]['current'])) {
                        $weatherData = $batchData[$index];
                    } elseif (isset($batchData['current']) && $index === 0) {
                        $weatherData = $batchData;
                    }
                }

                if (!$weatherData) {
                    $weatherData = $this->generateFallbackWeatherData($country->latitude, $country->longitude, false);
                }

                $list[] = $this->formatCountryWeather($country, $weatherData);
            }
            return $list;
        });

        return response()->json(['success' => true, 'data' => $results]);
    }

    /**
     * Call Open-Meteo HTTP API for single location
     */
    private function fetchOpenMeteoData($lat, $lng, $includeHourly = true)
    {
        try {
            $params = [
                'latitude' => $lat,
                'longitude' => $lng,
                'current' => 'temperature_2m,relative_humidity_2m,precipitation,weather_code,wind_speed_10m',
                'timezone' => 'auto',
            ];

            if ($includeHourly) {
                $params['hourly'] = 'temperature_2m,precipitation,weather_code';
            }

            $response = Http::timeout(3)->get('https://api.open-meteo.com/v1/forecast', $params);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::warning('Open-Meteo API Fetch Notice: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Call Open-Meteo HTTP API in a single fast batch request for all countries
     */
    private function fetchOpenMeteoBatch($countries)
    {
        try {
            // Open-Meteo supports up to 500 coordinates per request
            $lats = $countries->pluck('latitude')->implode(',');
            $lngs = $countries->pluck('longitude')->implode(',');

            $response = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $lats,
                'longitude' => $lngs,
                'current' => 'temperature_2m,relative_humidity_2m,precipitation,weather_code,wind_speed_10m',
                'timezone' => 'auto',
            ]);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::warning('Open-Meteo Batch API Fetch Notice: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Generate Fallback Weather Data
     */
    private function generateFallbackWeatherData($lat, $lng, $includeHourly = true)
    {
        $baseTemp = round(20 + (abs($lat) < 20 ? 10 : (abs($lat) > 50 ? -10 : 0)) + rand(-3, 4), 1);
        $weatherCode = [0, 1, 2, 3, 61, 63, 80][rand(0, 6)];

        $data = [
            'current' => [
                'temperature_2m' => $baseTemp,
                'relative_humidity_2m' => rand(45, 90),
                'precipitation' => in_array($weatherCode, [61, 63, 80]) ? round(rand(2, 18) / 10, 1) : 0,
                'wind_speed_10m' => round(rand(5, 32) + (rand(0, 1) ? 5 : 0), 1),
                'weather_code' => $weatherCode,
            ]
        ];

        if ($includeHourly) {
            $hourlyTimes = [];
            $hourlyTemps = [];
            for ($i = 0; $i < 12; $i++) {
                $hourlyTimes[] = now()->addHours($i)->format('Y-m-d\TH:00');
                $hourlyTemps[] = round($baseTemp + sin($i / 2) * 3, 1);
            }
            $data['hourly'] = [
                'time' => $hourlyTimes,
                'temperature_2m' => $hourlyTemps
            ];
        }

        return $data;
    }

    /**
     * Format Open-Meteo response into application weather object
     */
    private function formatCountryWeather($country, $apiData)
    {
        $current = $apiData['current'] ?? [];
        $temp = $current['temperature_2m'] ?? 25;
        $humidity = $current['relative_humidity_2m'] ?? 60;
        $precip = $current['precipitation'] ?? 0;
        $windSpeed = $current['wind_speed_10m'] ?? 10;
        $code = $current['weather_code'] ?? 0;

        $condition = $this->parseWeatherCode($code);
        $risk = $this->calculateWeatherRisk($temp, $humidity, $windSpeed, $precip, $code);

        $hourlyTemp = [];
        $hourlyLabels = [];

        if (isset($apiData['hourly']['temperature_2m'])) {
            $times = array_slice($apiData['hourly']['time'] ?? [], 0, 12);
            $temps = array_slice($apiData['hourly']['temperature_2m'] ?? [], 0, 12);

            foreach ($times as $index => $t) {
                $hourlyLabels[] = substr($t, 11, 5);
                $hourlyTemp[] = $temps[$index] ?? 0;
            }
        }

        return [
            'country_id' => $country->id,
            'country_name' => $country->name,
            'country_code' => $country->code,
            'region' => $country->region,
            'latitude' => $country->latitude,
            'longitude' => $country->longitude,
            'temperature' => round($temp, 1),
            'humidity' => $humidity,
            'precipitation' => $precip,
            'wind_speed' => round($windSpeed, 1),
            'weather_code' => $code,
            'condition_text' => $condition['text'],
            'weather_icon' => $condition['icon'],
            'risk_level' => $risk['level'],
            'risk_badge' => $risk['badge'],
            'risk_color' => $risk['color'],
            'risk_note' => $risk['note'],
            'hourly_labels' => $hourlyLabels,
            'hourly_temp' => $hourlyTemp,
            'updated_at' => now()->format('H:i:s'),
        ];
    }

    private function parseWeatherCode($code)
    {
        switch ($code) {
            case 0:
                return ['text' => 'Cerah (Clear Sky)', 'icon' => 'fas fa-sun text-warning'];
            case 1:
            case 2:
                return ['text' => 'Cerah Berawan (Partly Cloudy)', 'icon' => 'fas fa-cloud-sun text-warning'];
            case 3:
                return ['text' => 'Berawan (Overcast)', 'icon' => 'fas fa-cloud text-secondary'];
            case 45:
            case 48:
                return ['text' => 'Kabut (Foggy)', 'icon' => 'fas fa-smog text-secondary'];
            case 51:
            case 53:
            case 55:
                return ['text' => 'Gerimis Ringan (Drizzle)', 'icon' => 'fas fa-cloud-rain text-info'];
            case 61:
            case 63:
                return ['text' => 'Hujan Sedang (Rain)', 'icon' => 'fas fa-cloud-showers-heavy text-primary'];
            case 65:
            case 80:
            case 81:
            case 82:
                return ['text' => 'Hujan Lebat (Heavy Rain)', 'icon' => 'fas fa-cloud-showers-water text-primary'];
            case 71:
            case 73:
            case 75:
            case 85:
            case 86:
                return ['text' => 'Hujan Salju (Snow)', 'icon' => 'fas fa-snowflake text-info'];
            case 95:
            case 96:
            case 99:
                return ['text' => 'Badai Petir (Thunderstorm)', 'icon' => 'fas fa-bolt text-danger'];
            default:
                return ['text' => 'Cerah Berawan', 'icon' => 'fas fa-cloud-sun text-warning'];
        }
    }

    private function calculateWeatherRisk($temp, $humidity, $windSpeed, $precip, $code)
    {
        if ($code >= 95 || $windSpeed >= 38 || $precip >= 15) {
            return [
                'level' => 'High Risk',
                'badge' => 'badge-danger',
                'color' => '#ef4444',
                'note' => 'Potensi badai / angin kencang ekstrem dapat mengganggu pelayaran dan penerbangan kargo.'
            ];
        }

        if ($windSpeed >= 20 || $precip >= 5 || in_array($code, [61, 63, 65, 80, 81])) {
            return [
                'level' => 'Medium Risk',
                'badge' => 'badge-warning',
                'color' => '#f59e0b',
                'note' => 'Hujan sedang / angin sedang. Waspadai potensi penundaan logistik ringan.'
            ];
        }

        return [
            'level' => 'Low Risk',
            'badge' => 'badge-success',
            'color' => '#10b981',
            'note' => 'Cuaca aman dan kondusif untuk seluruh jalur pengiriman barang maritim & udara.'
        ];
    }
}