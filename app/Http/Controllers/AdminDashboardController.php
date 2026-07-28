<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Port;
use App\Models\Article;
use App\Models\Country;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Control Panel & Management Overview (PDF Spec Page 6).
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalAdmins = User::whereIn('role', ['Administrator', 'Admin'])->count();
        $totalRegularUsers = User::whereNotIn('role', ['Administrator', 'Admin'])->count();

        $totalPorts = Port::count();
        $highRiskPorts = Port::where('risk_level', 'LIKE', '%High%')->count();

        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'Published')->count();

        $recentUsers = User::latest()->take(5)->get();
        $recentArticles = Article::latest()->take(5)->get();
        $recentPorts = Port::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalAdmins', 'totalRegularUsers',
            'totalPorts', 'highRiskPorts',
            'totalArticles', 'publishedArticles',
            'recentUsers', 'recentArticles', 'recentPorts'
        ));
    }
}
