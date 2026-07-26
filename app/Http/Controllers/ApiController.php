<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function countries()
    {
        $response = Http::get(
            'https://restcountries.com/v3.1/all?fields=name,region,population,currencies,flags'
        );

        if ($response->failed()) {
            abort(500, 'Gagal mengambil data dari REST Countries API.');
        }

        $countries = collect($response->json())
            ->map(function ($country) {

                $currency = '-';

                if (!empty($country['currencies'])) {
                    $currency = implode(', ', array_keys($country['currencies']));
                }

                return [
                    'name'       => $country['name']['common'] ?? '-',
                    'region'     => $country['region'] ?? '-',
                    'currency'   => $currency,
                    'population' => $country['population'] ?? 0,
                    'flag'       => $country['flags']['png'] ?? '',
                ];
            })
            ->sortBy('name')
            ->values();

        return view('api.countries', compact('countries'));
    }
}