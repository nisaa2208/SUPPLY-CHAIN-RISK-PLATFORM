<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    //=================================================
    // COUNTRIES MANAGEMENT
    //=================================================

    public function index(Request $request)
    {
        $query = Country::query();


        // SEARCH COUNTRY

        if ($request->search) {

            $query->where(
                'name',
                'LIKE',
                '%' . $request->search . '%'
            );

        }


        // FILTER RISK LEVEL

        if ($request->risk_level) {

            $query->where(
                'risk_level',
                $request->risk_level
            );

        }


        // FILTER REGION

        if ($request->region) {

            $query->where(
                'region',
                $request->region
            );

        }



        // DATA COUNTRY

        $countries = $query->orderBy(
            'name',
            'ASC'
        )->get();



        // FILTER REGION

        $regions = Country::select('region')
            ->distinct()
            ->orderBy('region')
            ->pluck('region');



        // STATISTICS

        $totalCountry = Country::count();

        $lowRisk = Country::where(
            'risk_level',
            'Low'
        )->count();


        $mediumRisk = Country::where(
            'risk_level',
            'Medium'
        )->count();


        $highRisk = Country::where(
            'risk_level',
            'High'
        )->count();



        return view(

            'countries.index',

            compact(

                'countries',
                'regions',
                'totalCountry',
                'lowRisk',
                'mediumRisk',
                'highRisk'

            )

        );
    }




    //=================================================
    // DETAIL COUNTRY
    //=================================================

    public function show(Country $country)
    {

        $country->load(
            'suppliers',
            'products'
        );


        return view(

            'countries.show',

            compact('country')

        );

    }




    //=================================================
    // WORLD MAP
    //=================================================

    public function map()
    {

        $countries = Country::orderBy(
            'name',
            'ASC'
        )->get();


        $totalCountry = Country::count();


        $lowRisk = Country::where(
            'risk_level',
            'Low'
        )->count();


        $mediumRisk = Country::where(
            'risk_level',
            'Medium'
        )->count();


        $highRisk = Country::where(
            'risk_level',
            'High'
        )->count();



        return view(

            'countries.map',

            compact(

                'countries',
                'totalCountry',
                'lowRisk',
                'mediumRisk',
                'highRisk'

            )

        );

    }


//=================================================
// WORLD MAP API (REAL TIME)
//=================================================

public function mapData()
{
    $countries = Country::select(
        'id',
        'name',
        'code',
        'capital',
        'region',
        'latitude',
        'longitude',
        'risk_level',
        'risk_score',
        'trade_index',
        'shipping_status'
    )
    ->orderBy('name', 'ASC')
    ->get();

    return response()->json($countries);
}

    //=================================================
    // FORM ADD COUNTRY
    //=================================================

    public function create()
    {

        return view(
            'countries.create'
        );

    }




    //=================================================
    // SAVE COUNTRY
    //=================================================

    public function store(Request $request)
    {

        $validated = $request->validate([

            'name'          => 'required',
            'code'          => 'required|size:2|unique:countries',
            'iso3'          => 'nullable|size:3',
            'gdp'           => 'nullable|numeric',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'capital'       => 'required',
            'region'        => 'required',
            'currency'      => 'required',
            'population'    => 'required|numeric',
            'risk_level'    => 'required',
            'risk_score'    => 'nullable|numeric',
            'trade_index'   => 'nullable|numeric',
            'supply_status' => 'nullable',
            'shipping_status' => 'nullable',

        ]);


        Country::create($validated);


        return redirect()

            ->route('countries.index')

            ->with(

                'success',

                'Data Negara berhasil ditambahkan.'

            );

    }




    //=================================================
    // FORM EDIT COUNTRY
    //=================================================

    public function edit(Country $country)
    {

        return view(

            'countries.edit',

            compact('country')

        );

    }




    //=================================================
    // UPDATE COUNTRY
    //=================================================

    public function update(
        Request $request,
        Country $country
    )
    {

        $validated = $request->validate([

            'name'          => 'required',

            'code'          =>
            'required|unique:countries,code,' . $country->id,

            'capital'       => 'required',

            'region'        => 'required',

            'currency'      => 'required',

            'population'    => 'required|numeric',

            'risk_level'    => 'required',

            'risk_score'    => 'nullable|numeric',

            'trade_index'   => 'nullable|numeric',

            'supply_status' => 'nullable',

            'shipping_status' => 'nullable',

        ]);


      $country->update($validated);

return redirect()
    ->route('countries.index')
    ->with(
        'success',
        'Data Negara berhasil diperbarui.'
    );
}

    //=================================================
    // DELETE COUNTRY
    //=================================================

    public function destroy(
        Country $country
    )
    {

        $country->delete();


        return redirect()

            ->route('countries.index')

            ->with(

                'success',

                'Data Negara berhasil dihapus.'

            );

    }

}