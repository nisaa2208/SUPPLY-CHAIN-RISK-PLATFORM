<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of analysis articles for Admin & Users.
     */
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $articles = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = Article::distinct()->pluck('category')->filter()->values();

        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Show form for creating a new analysis article (Admin only).
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created analysis article (Admin only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:Published,Draft',
        ]);

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category' => $request->category,
            'author' => $request->author,
            'source' => $request->source ?? 'Internal Risk Analyst',
            'summary' => $request->summary,
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => now(),
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel Analisis Risiko berhasil dibuat.');
    }

    /**
     * Display the specified analysis article.
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show form for editing an analysis article (Admin only).
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified analysis article (Admin only).
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:Published,Draft',
        ]);

        $article->update([
            'title' => $request->title,
            'category' => $request->category,
            'author' => $request->author,
            'summary' => $request->summary,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel Analisis Risiko berhasil diperbarui.');
    }

    /**
     * Remove the specified analysis article (Admin only).
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artikel Analisis Risiko berhasil dihapus.');
    }
}
