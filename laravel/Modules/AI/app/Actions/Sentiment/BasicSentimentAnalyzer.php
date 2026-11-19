<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Sentiment;

use Modules\AI\Contracts\SentimentAnalyzer;

use function Safe\preg_match;

class BasicSentimentAnalyzer implements SentimentAnalyzer
{
    /**
     * {@inheritDoc}
     *
     * @return array<string, mixed>
     */
    public function analyze(string $text): array
    {
        if (trim($text) === '') {
            return [
                'label' => 'NEGATIVE',
                'score' => 0,
                'warning' => 'Using basic sentiment analysis - install transformers for better accuracy',
            ];
        }

        $positiveWords = ['good', 'great', 'excellent', 'positive', 'happy'];
        $negativeWords = ['bad', 'poor', 'terrible', 'negative', 'unhappy'];

        $positiveCount = $this->countWholeWordMatches($text, $positiveWords);
        $negativeCount = $this->countWholeWordMatches($text, $negativeWords);

        $score = ($positiveCount - $negativeCount) / max(1, $positiveCount + $negativeCount);

        return [
            'label' => $score >= 0 ? 'POSITIVE' : 'NEGATIVE',
            'score' => abs($score),
            'warning' => 'Using basic sentiment analysis - install transformers for better accuracy',
        ];
    }

    /**
     * @param  list<string>  $words
     */
    private function countWholeWordMatches(string $text, array $words): int
    {
        $count = 0;

        foreach ($words as $word) {
            if (preg_match('/\b'.preg_quote($word, '/').'\b/i', $text) === 1) {
                $count++;
            }
        }

        return $count;
    }
}
