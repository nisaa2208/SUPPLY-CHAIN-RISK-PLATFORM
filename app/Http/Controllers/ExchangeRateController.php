<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ExchangeRateController extends Controller
{
    /**
     * Menampilkan data kurs mata uang dari Exchange Rate API
     */
    public function index()
    {
        $response = Http::get('https://open.er-api.com/v6/latest/USD');

        if ($response->failed()) {
            abort(500, 'Gagal mengambil data Exchange Rate API.');
        }

        $data = $response->json();

        $rates = collect($data['rates'])->only([
            'IDR',
            'EUR',
            'GBP',
            'JPY',
            'SGD',
            'MYR',
            'CNY',
            'AUD',
            'CAD',
            'KRW'
        ]);

        return view('api.exchange', compact('rates'));
    }
}