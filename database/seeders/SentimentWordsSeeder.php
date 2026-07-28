<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SentimentWordsSeeder extends Seeder
{
    /**
     * Seed positive_words and negative_words tables (Indonesian & English Bilingual Dictionary)
     */
    public function run()
    {
        // Positive Words Dictionary (Indonesian + English)
        $positiveWords = [
            // English
            'growth', 'increase', 'profit', 'stable', 'improve', 
            'boom', 'boost', 'surge', 'recovery', 'strong', 
            'expand', 'thrive', 'gain', 'surplus', 'opportunity',
            'optimistic', 'robust', 'peak', 'record', 'high', 'success',

            // Indonesian
            'kenaikan', 'keuntungan', 'stabil', 'membaik', 'tumbuh', 
            'sukses', 'laba', 'pulih', 'lancar', 'meningkat', 
            'aman', 'bagus', 'surplus', 'peluang', 'perkembangan', 
            'kemajuan', 'efisien', 'naik', 'positif', 'baik'
        ];

        foreach ($positiveWords as $word) {
            DB::table('positive_words')->updateOrInsert(
                ['word' => strtolower($word)],
                ['word' => strtolower($word), 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // Negative Words Dictionary (Indonesian + English)
        $negativeWords = [
            // English
            'war', 'crisis', 'inflation', 'delay', 'disaster', 
            'conflict', 'strike', 'decline', 'drop', 'shortage', 
            'bottleneck', 'congestion', 'disruption', 'tariff', 'sanction', 
            'collapse', 'hazard', 'loss', 'recession', 'vulnerable', 'flood', 'storm',

            // Indonesian
            'banjir', 'kemacetan', 'perang', 'krisis', 'inflasi', 
            'kerusakan', 'keterlambatan', 'gempa', 'badai', 'rugi', 
            'turun', 'bencana', 'pemogokan', 'hujan', 'blokir', 
            'mogok', 'lambat', 'macet', 'gangguan', 'tutup', 
            'anjlok', 'batal', 'merugi', 'sengketa', 'kerusuhan', 'terhambat', 'rusak'
        ];

        foreach ($negativeWords as $word) {
            DB::table('negative_words')->updateOrInsert(
                ['word' => strtolower($word)],
                ['word' => strtolower($word), 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
