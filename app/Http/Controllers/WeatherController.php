<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /**
     * Menampilkan data cuaca dari Open-Meteo API
     */
    public function index()
    {
        $response = Http::get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m'
            ]
        );

        if ($response->failed()) {
            abort(500, 'Gagal mengambil data cuaca.');
        }

        $weather = $response->json()['current'];

        return view('api.weather', compact('weather'));
    }
}