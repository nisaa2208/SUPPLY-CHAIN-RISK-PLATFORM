<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    /**
     * Display a listing of user favorites.
     */
    public function index()
    {
        $userId = Auth::id();
        $watchlists = Watchlist::with('country')
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->get();

        $allCountries = Country::orderBy('name')->get();

        return view('favorites.index', compact('watchlists', 'allCountries'));
    }

    /**
     * Toggle favorite status for a country.
     */
    public function toggle(Request $request, Country $country)
    {
        $userId = Auth::id();
        $watchlist = Watchlist::where('user_id', $userId)
            ->where('country_id', $country->id)
            ->first();

        if ($watchlist) {
            $watchlist->delete();
            $message = "{$country->name} berhasil dihapus dari daftar favorit.";
        } else {
            Watchlist::create([
                'user_id' => $userId,
                'country_id' => $country->id,
                'is_active' => true,
            ]);
            $message = "{$country->name} berhasil ditambahkan ke daftar favorit.";
        }

        return redirect()->back()->with('success', $message);
    }
}
