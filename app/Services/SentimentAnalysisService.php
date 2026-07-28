<?php

namespace App\Services;

class SentimentAnalysisService
{
    protected array $positiveWords = [
        'growth', 'increase', 'profit', 'stable', 'improve', 'boom', 'boost', 
        'surge', 'expansion', 'recovery', 'strong', 'positive', 'gain', 'advance',
        'benefit', 'success', 'solution', 'deal', 'agreement', 'opportunit'
    ];

    protected array $negativeWords = [
        'war', 'crisis', 'inflation', 'delay', 'disaster', 'conflict', 'strike', 
        'decline', 'drop', 'decrease', 'loss', 'sanction', 'shortage', 'disrupt',
        'congestion', 'threat', 'risk', 'fail', 'collapse', 'embargo', 'tensions'
    ];

    /**
     * Analyze text using Lexicon-Based Sentiment Analysis
     */
    public function analyze(string $text): array
    {
        $cleanText = strtolower(preg_replace('/[^a-zA-Z\s]/', '', $text));
        $words = explode(' ', $cleanText);

        $posCount = 0;
        $negCount = 0;
        $matchedPos = [];
        $matchedNeg = [];

        foreach ($words as $word) {
            if (empty($word)) continue;

            foreach ($this->positiveWords as $pWord) {
                if (str_contains($word, $pWord)) {
                    $posCount++;
                    $matchedPos[] = $word;
                    break;
                }
            }

            foreach ($this->negativeWords as $nWord) {
                if (str_contains($word, $nWord)) {
                    $negCount++;
                    $matchedNeg[] = $word;
                    break;
                }
            }
        }

        $totalMatches = $posCount + $negCount;
        
        if ($totalMatches === 0) {
            $posPercent = 33;
            $negPercent = 33;
            $neuPercent = 34;
            $sentiment = 'Neutral';
            $score = 50; // Neutral baseline risk
        } else {
            $posPercent = round(($posCount / $totalMatches) * 100);
            $negPercent = round(($negCount / $totalMatches) * 100);
            $neuPercent = max(0, 100 - ($posPercent + $negPercent));

            if ($posCount > $negCount) {
                $sentiment = 'Positive';
                $score = max(10, 50 - ($posPercent / 2)); // Lower risk
            } elseif ($negCount > $posCount) {
                $sentiment = 'Negative';
                $score = min(95, 50 + ($negPercent / 2)); // Higher risk
            } else {
                $sentiment = 'Neutral';
                $score = 50;
            }
        }

        return [
            'sentiment' => $sentiment,
            'positive_score' => $posCount,
            'negative_score' => $negCount,
            'positive_percent' => $posPercent,
            'negative_percent' => $negPercent,
            'neutral_percent' => $neuPercent,
            'risk_sentiment_score' => round($score),
            'matched_positive' => array_unique($matchedPos),
            'matched_negative' => array_unique($matchedNeg),
        ];
    }
}
