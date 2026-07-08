<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Exception;
use Modules\AI\Actions\Sentiment\BasicSentimentAnalyzer;
use Modules\AI\Actions\Sentiment\TransformersSentimentAnalyzer;
use Modules\AI\Datas\SentimentData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\error_log;

/**
 * Sentiment analysis using transformers when available, otherwise basic pattern matching.
 */
class SentimentAction
{
    use QueueableAction;

    public function execute(string $prompt): SentimentData
    {
        $analyzer = class_exists('Codewithkyrian\Transformers\Transformers')
            ? new TransformersSentimentAnalyzer
            : new BasicSentimentAnalyzer;

        try {
            $result = $analyzer->analyze($prompt);

            return SentimentData::from($result);
        } catch (Exception $e) {
            error_log('Sentiment analysis error: '.$e->getMessage());

            return SentimentData::from([
                'error' => $e->getMessage(),
                'status' => 'error',
            ]);
        }
    }
}
