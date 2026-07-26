<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WorldBankController extends Controller
{
    /**
     * Menampilkan data GDP dari World Bank API
     */
    public function index()
    {
        $response = Http::get(
            'https://api.worldbank.org/v2/country/all/indicator/NY.GDP.MKTP.CD',
            [
                'format'   => 'json',
                'per_page' => 20,
            ]
        );

        if ($response->failed()) {
            abort(500, 'Gagal mengambil data World Bank API.');
        }

        $json = $response->json();

        if (!isset($json[1])) {
            abort(500, 'Data World Bank tidak tersedia.');
        }

        $countries = collect($json[1])
            ->filter(function ($item) {
                return !empty($item['value']);
            })
            ->take(15)
            ->values();

        return view('api.worldbank', compact('countries'));
    }
}