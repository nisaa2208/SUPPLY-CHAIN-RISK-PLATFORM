<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $articles = [];

        try {

            $response = Http::timeout(10)
                ->acceptJson()
                ->get('https://api.spaceflightnewsapi.net/v4/articles/', [
                    'limit' => 10,
                ]);

            if ($response->successful()) {

                $articles = $response->json('results', []);

            }

        } catch (\Exception $e) {

            $articles = [];

        }

        return view('news.index', compact('articles'));
    }
}