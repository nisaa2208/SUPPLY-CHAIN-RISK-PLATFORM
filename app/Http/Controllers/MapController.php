<?php

namespace App\Http\Controllers;

use App\Models\Country;

class MapController extends Controller
{
    public function index()
    {
        $countries = Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('world-map', compact('countries'));
    }
}