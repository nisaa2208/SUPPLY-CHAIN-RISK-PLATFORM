<?php

namespace App\Http\Controllers;

use App\Services\SentimentAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiSentimentController extends Controller
{
    /**
     * Display AI Lexicon Sentiment Engine Control Panel (PDF Spec Pages 6-8)
     */
    public function index(Request $request)
    {
        $testText = $request->input('test_text', 'Inflation increases while exports decrease due to port congestion and war.');
        
        $service = new SentimentAnalysisService();
        $testResult = $service->analyze($testText);

        $positiveWords = DB::table('positive_words')->orderBy('word')->get();
        $negativeWords = DB::table('negative_words')->orderBy('word')->get();

        return view('admin.ai_sentiment', compact('testText', 'testResult', 'positiveWords', 'negativeWords'));
    }

    /**
     * Add new word to Positive Words Dictionary
     */
    public function addPositiveWord(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:50|unique:positive_words,word'
        ]);

        $word = strtolower(trim($request->input('word')));
        DB::table('positive_words')->insert([
            'word' => $word,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.ai.sentiment')->with('success', "Kata positif '{$word}' berhasil ditambahkan ke Kamus Lexicon AI.");
    }

    /**
     * Delete word from Positive Words Dictionary
     */
    public function deletePositiveWord($id)
    {
        DB::table('positive_words')->where('id', $id)->delete();
        return redirect()->route('admin.ai.sentiment')->with('success', 'Kata positif berhasil dihapus dari Kamus Lexicon AI.');
    }

    /**
     * Add new word to Negative Words Dictionary
     */
    public function addNegativeWord(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:50|unique:negative_words,word'
        ]);

        $word = strtolower(trim($request->input('word')));
        DB::table('negative_words')->insert([
            'word' => $word,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.ai.sentiment')->with('success', "Kata negatif '{$word}' berhasil ditambahkan ke Kamus Lexicon AI.");
    }

    /**
     * Delete word from Negative Words Dictionary
     */
    public function deleteNegativeWord($id)
    {
        DB::table('negative_words')->where('id', $id)->delete();
        return redirect()->route('admin.ai.sentiment')->with('success', 'Kata negatif berhasil dihapus dari Kamus Lexicon AI.');
    }
}
