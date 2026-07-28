<?php

namespace App\Http\Controllers;

use App\Models\Country;

class GlobalAlertController extends Controller
{
    public function index()
    {
        $alerts = Country::where('risk_score', '>=', 80)
            ->orderByDesc('risk_score')
            ->get();

        return view('alerts.index', compact('alerts'));
    }
}