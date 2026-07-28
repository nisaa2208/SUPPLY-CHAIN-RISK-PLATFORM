<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    /**
     * Display the Global Maritime Port Location & Shipping Route Dashboard.
     */
    public function index(Request $request)
    {
        $query = Port::query();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('country', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('port_code', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('country')) {
            $country = trim($request->input('country'));
            $query->where('country', 'LIKE', "%{$country}%");
        }

        if ($request->filled('risk_level')) {
            $risk = trim($request->input('risk_level'));
            $cleanRisk = str_replace(' Risk', '', $risk);
            $query->where(function($q) use ($risk, $cleanRisk) {
                $q->where('risk_level', 'LIKE', "%{$risk}%")
                  ->orWhere('risk_level', 'LIKE', "%{$cleanRisk}%");
            });
        }

        $ports = $query->orderBy('name')->get();

        // Calculate summary analytics
        $totalPortsCount = Port::count();
        $lowRiskCount = Port::where('risk_level', 'LIKE', '%Low%')->count();
        $mediumRiskCount = Port::where('risk_level', 'LIKE', '%Medium%')->count();
        $highRiskCount = Port::where('risk_level', 'LIKE', '%High%')->count();
        $totalCountriesCount = Port::distinct()->count('country');

        $countries = Port::distinct()->pluck('country')->filter()->sort()->values();

        // Global Maritime Shipping Routes
        $routes = $this->getGlobalShippingRoutes();

        return view('ports.index', compact(
            'ports',
            'totalPortsCount',
            'lowRiskCount',
            'mediumRiskCount',
            'highRiskCount',
            'totalCountriesCount',
            'countries',
            'routes'
        ));
    }

    /**
     * Show form for adding new Port to dataset (Admin only).
     */
    public function create()
    {
        return view('ports.create');
    }

    /**
     * Store new Port in dataset (Admin only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'port_code' => 'required|string|max:20|unique:ports,port_code',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'risk_level' => 'required|string|in:Low Risk,Medium Risk,High Risk',
        ]);

        Port::create([
            'name' => $request->name,
            'port_code' => strtoupper($request->port_code),
            'country' => $request->country,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'risk_level' => $request->risk_level,
            'risk_score' => $request->risk_level === 'High Risk' ? 80 : ($request->risk_level === 'Medium Risk' ? 50 : 20),
            'status' => 'Active',
        ]);

        return redirect()->route('ports.index')->with('success', 'Pelabuhan baru berhasil ditambahkan ke dataset.');
    }

    /**
     * Show form for editing Port in dataset (Admin only).
     */
    public function edit(Port $port)
    {
        return view('ports.edit', compact('port'));
    }

    /**
     * Update Port in dataset (Admin only).
     */
    public function update(Request $request, Port $port)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'port_code' => 'required|string|max:20|unique:ports,port_code,' . $port->id,
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'risk_level' => 'required|string|in:Low Risk,Medium Risk,High Risk',
        ]);

        $port->update([
            'name' => $request->name,
            'port_code' => strtoupper($request->port_code),
            'country' => $request->country,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'risk_level' => $request->risk_level,
            'risk_score' => $request->risk_level === 'High Risk' ? 80 : ($request->risk_level === 'Medium Risk' ? 50 : 20),
        ]);

        return redirect()->route('ports.index')->with('success', 'Data pelabuhan berhasil diperbarui.');
    }

    /**
     * Delete Port from dataset (Admin only).
     */
    public function destroy(Port $port)
    {
        $port->delete();
        return redirect()->route('ports.index')->with('success', 'Pelabuhan berhasil dihapus dari dataset.');
    }

    /**
     * Live AJAX endpoint for real-time GIS Port Data + Shipping Routes JSON
     */
    public function getLivePorts(Request $request)
    {
        $query = Port::query();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('country', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('port_code', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('country')) {
            $country = trim($request->input('country'));
            $query->where('country', 'LIKE', "%{$country}%");
        }

        if ($request->filled('risk_level')) {
            $risk = trim($request->input('risk_level'));
            $cleanRisk = str_replace(' Risk', '', $risk);
            $query->where(function($q) use ($risk, $cleanRisk) {
                $q->where('risk_level', 'LIKE', "%{$risk}%")
                  ->orWhere('risk_level', 'LIKE', "%{$cleanRisk}%");
            });
        }

        $ports = $query->orderBy('name')->get()->map(function ($port) {
            $liveVariation = rand(-3, 3);
            $liveScore = max(10, min(95, ($port->risk_score ?? 25) + $liveVariation));

            $port->risk_score = $liveScore;
            $port->active_vessels = rand(15, 85);
            $port->wait_time_hours = round(rand(4, 36) / 2, 1);

            return $port;
        });

        $stats = [
            'total' => Port::count(),
            'low_risk' => Port::where('risk_level', 'LIKE', '%Low%')->count(),
            'medium_risk' => Port::where('risk_level', 'LIKE', '%Medium%')->count(),
            'high_risk' => Port::where('risk_level', 'LIKE', '%High%')->count(),
            'countries_count' => Port::distinct()->count('country'),
        ];

        return response()->json([
            'success' => true,
            'updated_at' => now()->format('H:i:s'),
            'stats' => $stats,
            'ports' => $ports,
            'routes' => $this->getGlobalShippingRoutes()
        ]);
    }

    /**
     * Define major international maritime container route lines
     */
    private function getGlobalShippingRoutes()
    {
        return [
            [
                'name' => 'Koridor Maritim Asia (Shanghai - Singapura - Jakarta)',
                'color' => '#3b82f6',
                'coordinates' => [
                    [30.6274, 122.0628],
                    [22.5004, 113.8828],
                    [1.2644, 103.8400],
                    [-6.1014, 106.8833],
                ]
            ],
            [
                'name' => 'Jalur Perdagangan Timur Tengah & Terusan Suez',
                'color' => '#8b5cf6',
                'coordinates' => [
                    [1.2644, 103.8400],
                    [24.9857, 55.0657],
                    [31.2653, 32.3019],
                ]
            ],
            [
                'name' => 'Jalur Perdagangan Eropa Mediterania',
                'color' => '#10b981',
                'coordinates' => [
                    [31.2653, 32.3019],
                    [51.9556, 4.1333],
                    [53.5461, 9.9664],
                ]
            ],
            [
                'name' => 'Jalur Transpasifik (Asia - Amerika Utara)',
                'color' => '#f59e0b',
                'coordinates' => [
                    [30.6274, 122.0628],
                    [35.4437, 139.6380],
                    [33.7423, -118.2673],
                ]
            ]
        ];
    }
}
