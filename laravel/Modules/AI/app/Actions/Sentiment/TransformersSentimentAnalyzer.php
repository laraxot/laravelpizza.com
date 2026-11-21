<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Sentiment;

use Exception;
use Modules\AI\Contracts\SentimentAnalyzer;

use function Safe\error_log;

class TransformersSentimentAnalyzer implements SentimentAnalyzer
{
    /**
     * {@inheritDoc}
     *
     * @return array<string, mixed>
     */
    public function analyze(string $text): array
    {
        if ($this->canUseTransformersPipeline()) {
            error_log('Transformers sentiment pipeline disabled; using basic fallback.');
        }

        return (new BasicSentimentAnalyzer)->analyze($text);
    }

    private function canUseTransformersPipeline(): bool
    {
        try {
            return class_exists('Codewithkyrian\Transformers\Transformers')
                && class_exists('\\Codewithkyrian\\Transformers\\Pipelines\\Pipeline')
                && function_exists('\\Codewithkyrian\\Transformers\\Pipelines\\pipeline');
        } catch (Exception) {
            return false;
        }
    }
}
