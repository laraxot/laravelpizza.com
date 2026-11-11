<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Sentiment;

use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_match_all;

final class AnalyzeBasicSentimentAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(string $text): array
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

        [$positiveCount, $negativeCount] = $this->countPolarity($text, $positiveWords, $negativeWords);

        $score = ($positiveCount - $negativeCount) / max(1, $positiveCount + $negativeCount);

        return [
            'label' => $score >= 0 ? 'POSITIVE' : 'NEGATIVE',
            'score' => abs($score),
            'warning' => 'Using basic sentiment analysis - install transformers for better accuracy',
        ];
    }

    /**
     * Counts sentiment words, flipping the polarity of a word preceded by a negation
     * within the previous three words ("not a good product" counts as negative).
     *
     * @param  list<string>  $positiveWords
     * @param  list<string>  $negativeWords
     * @return array{int, int}
     */
    private function countPolarity(string $text, array $positiveWords, array $negativeWords): array
    {
        $negations = ['not', 'no', 'never', 'nor', "isn't", "aren't", "wasn't", "don't", "doesn't", "didn't", "can't", "won't"];
        $matches = [];
        preg_match_all("/[a-z']+/", mb_strtolower($text), $matches);
        $tokens = $matches[0];
        $positive = 0;
        $negative = 0;

        foreach ($tokens as $index => $token) {
            $polarity = in_array($token, $positiveWords, true) ? 1 : (in_array($token, $negativeWords, true) ? -1 : 0);
            if ($polarity === 0) {
                continue;
            }

            $window = array_slice($tokens, max(0, $index - 3), 3);
            if (array_intersect($window, $negations) !== []) {
                $polarity = -$polarity;
            }

            $polarity > 0 ? $positive++ : $negative++;
        }

        return [$positive, $negative];
    }
}
