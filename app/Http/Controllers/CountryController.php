<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::latest()->paginate(10);

        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'code'             => 'nullable|string|max:10',
            'region'           => 'required|string|max:255',
            'risk_score'       => 'required|numeric|min:0|max:100',
            'risk_level'       => 'required|string|max:50',
            'trade_index'      => 'required|numeric|min:0|max:100',
            'shipping_status'  => 'required|string|max:50',
            'supply_status'    => 'nullable|string|max:50',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',
        ]);

        Country::create($validated);

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'code'             => 'nullable|string|max:10',
            'region'           => 'required|string|max:255',
            'risk_score'       => 'required|numeric|min:0|max:100',
            'risk_level'       => 'required|string|max:50',
            'trade_index'      => 'required|numeric|min:0|max:100',
            'shipping_status'  => 'required|string|max:50',
            'supply_status'    => 'nullable|string|max:50',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',
        ]);

        $country->update($validated);

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country berhasil diperbarui.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country berhasil dihapus.');
    }

    /**
     * Display World Map.
     */
    public function map()
    {
        $countries = Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('countries.map', compact('countries'));
    }

    /**
     * Return World Map data (JSON).
     */
    public function mapData()
    {
        $countries = Country::select(
                'id',
                'name',
                'code',
                'region',
                'latitude',
                'longitude',
                'risk_score',
                'risk_level',
                'trade_index',
                'shipping_status',
                'supply_status'
            )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return response()->json($countries);
    }
}