<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Sentiment;

use Exception;
use Spatie\QueueableAction\QueueableAction;

use function Safe\error_log;

final class AnalyzeTransformersSentimentAction
{
    use QueueableAction;

    public function __construct(
        private readonly AnalyzeBasicSentimentAction $analyzeBasicSentimentAction,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function execute(string $text): array
    {
        if ($this->canUseTransformersPipeline()) {
            error_log('Transformers sentiment pipeline disabled; using basic fallback.');
        }

        return $this->analyzeBasicSentimentAction->execute($text);
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
