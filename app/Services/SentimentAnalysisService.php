<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SentimentAnalysisService
{
    /**
     * Lexicon Based Sentiment Analysis (PDF Spec Page 7 & 8)
     * Supports both Indonesian and English logistics risk vocabulary.
     */
    public function analyze(string $text): array
    {
        $cleanText = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $text));
        $words = array_filter(explode(' ', $cleanText));

        // Fetch words from database tables positive_words & negative_words (PDF Page 7)
        if (Schema::hasTable('positive_words') && Schema::hasTable('negative_words')) {
            $positiveWords = DB::table('positive_words')->pluck('word')->toArray();
            $negativeWords = DB::table('negative_words')->pluck('word')->toArray();
        } else {
            $positiveWords = [
                'growth', 'increase', 'profit', 'stable', 'improve', 'boom', 'boost', 'surge', 'recovery', 'strong',
                'kenaikan', 'keuntungan', 'stabil', 'membaik', 'tumbuh', 'sukses', 'laba', 'pulih', 'lancar', 'meningkat', 'aman', 'baik'
            ];
            $negativeWords = [
                'war', 'crisis', 'inflation', 'delay', 'disaster', 'conflict', 'strike', 'decline', 'drop', 'shortage', 'flood', 'storm',
                'banjir', 'kemacetan', 'perang', 'krisis', 'inflasi', 'kerusakan', 'keterlambatan', 'gempa', 'badai', 'rugi', 'turun', 'bencana', 'pemogokan', 'hujan', 'blokir', 'macet', 'gangguan', 'terhambat'
            ];
        }

        // PDF Page 8 exact algorithm logic
        $positiveScore = 0;
        $negativeScore = 0;
        $matchedPos = [];
        $matchedNeg = [];

        foreach ($words as $word) {
            $w = trim(strtolower($word));
            if (empty($w)) continue;

            if (in_array($w, $positiveWords)) {
                $positiveScore++;
                $matchedPos[] = $w;
            }
            if (in_array($w, $negativeWords)) {
                $negativeScore++;
                $matchedNeg[] = $w;
            }
        }

        $sentiment = $positiveScore > $negativeScore ? "Positive" : ($negativeScore > $positiveScore ? "Negative" : "Neutral");

        $totalMatches = $positiveScore + $negativeScore;
        if ($totalMatches === 0) {
            $posPercent = 33;
            $negPercent = 33;
            $neuPercent = 34;
            $riskScore = 50;
        } else {
            $posPercent = round(($positiveScore / $totalMatches) * 100);
            $negPercent = round(($negativeScore / $totalMatches) * 100);
            $neuPercent = max(0, 100 - ($posPercent + $negPercent));
            $riskScore = $sentiment === 'Positive' ? max(10, 50 - ($posPercent / 2)) : ($sentiment === 'Negative' ? min(95, 50 + ($negPercent / 2)) : 50);
        }

        return [
            'sentiment' => $sentiment,
            'positive_score' => $positiveScore,
            'negative_score' => $negativeScore,
            'positive_percent' => $posPercent,
            'negative_percent' => $negPercent,
            'neutral_percent' => $neuPercent,
            'risk_sentiment_score' => round($riskScore),
            'matched_positive' => array_values(array_unique($matchedPos)),
            'matched_negative' => array_values(array_unique($matchedNeg)),
        ];
    }
}
