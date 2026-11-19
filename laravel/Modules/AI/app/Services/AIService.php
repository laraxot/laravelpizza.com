<?php

declare(strict_types=1);

namespace Modules\AI\Services;

use Illuminate\Support\Facades\Cache;
use Webmozart\Assert\Assert;

use function Safe\json_encode;

/**
 * Servizio AI/ML per FixCity Platform
 *
 * Integra funzionalità di intelligenza artificiale per:
 * - Classificazione automatica dei ticket
 * - Suggerimenti per risoluzione
 * - Analisi del sentiment
 * - Predizione di priorità
 * - Ottimizzazione del routing
 */
class AIService
{
    private AIChatCompletionClient $client;

    public function __construct()
    {
        $apiKey = config('services.openai.api_key', '');
        $baseUrl = config('services.openai.base_url', 'https://api.openai.com/v1');
        $timeout = config('services.openai.timeout', 30);
        $retryAttempts = config('services.openai.retry_attempts', 3);

        Assert::string($apiKey, 'API key must be a string');
        Assert::string($baseUrl, 'Base URL must be a string');
        Assert::integer($timeout, 'Timeout must be an integer');
        Assert::integer($retryAttempts, 'Retry attempts must be an integer');

        $this->client = new AIChatCompletionClient($apiKey, $baseUrl, $timeout, $retryAttempts);
    }

    /**
     * @return array<string, mixed>
     */
    public function classifyTicket(string $title, string $description): array
    {
        $cacheKey = 'ai:classification:'.hash('xxh128', $title.$description);

        $result = Cache::remember($cacheKey, 3600, function () use ($title, $description): string {
            $prompt = AIServicePromptBuilder::classification($title, $description);

            return $this->client->request($prompt, 'classification');
        });

        return AIServiceJsonDecoder::decodeObject($result);
    }

    /**
     * @return array<string, mixed>
     */
    public function suggestSolutions(string $title, string $description, string $category): array
    {
        $cacheKey = 'ai:solutions:'.hash('xxh128', $title.$description.$category);

        $result = Cache::remember($cacheKey, 1800, function () use ($title, $description, $category): string {
            $prompt = AIServicePromptBuilder::solutions($title, $description, $category);

            return $this->client->request($prompt, 'solutions');
        });

        return AIServiceJsonDecoder::decodeObject($result);
    }

    /**
     * @return array<string, mixed>
     */
    public function analyzeSentiment(string $text): array
    {
        $cacheKey = 'ai:sentiment:'.hash('xxh128', $text);

        $result = Cache::remember($cacheKey, 1800, function () use ($text): string {
            $prompt = AIServicePromptBuilder::sentiment($text);

            return $this->client->request($prompt, 'sentiment');
        });

        return AIServiceJsonDecoder::decodeObject($result);
    }

    /**
     * @param  array<string, mixed>  $context
     * @return array<string, mixed>
     */
    public function predictPriority(string $title, string $description, array $context = []): array
    {
        $contextStr = json_encode($context) ?: '{}';
        $cacheKey = 'ai:priority:'.hash('xxh128', $title.$description.$contextStr);

        $result = Cache::remember($cacheKey, 1800, function () use ($title, $description, $context): string {
            $prompt = AIServicePromptBuilder::priority($title, $description, $context);

            return $this->client->request($prompt, 'priority');
        });

        return AIServiceJsonDecoder::decodeObject($result);
    }

    /**
     * @param  array<int, array<string, mixed>>  $tickets
     * @param  array<int, array<string, mixed>>  $agents
     * @return array<string, mixed>
     */
    public function optimizeRouting(array $tickets, array $agents): array
    {
        $jsonTickets = json_encode($tickets);
        $jsonAgents = json_encode($agents);
        $cacheKey = 'ai:routing:'.hash('xxh128', $jsonTickets.$jsonAgents);

        $result = Cache::remember($cacheKey, 900, function () use ($tickets, $agents): string {
            $prompt = AIServicePromptBuilder::routing($tickets, $agents);

            return $this->client->request($prompt, 'routing');
        });

        return AIServiceJsonDecoder::decodeObject($result);
    }

    public function generateAutoResponse(string $ticketContent, string $category, string $priority): string
    {
        $cacheKey = 'ai:response:'.hash('xxh128', $ticketContent.$category.$priority);

        return Cache::remember($cacheKey, 1800, function () use ($ticketContent, $category, $priority): string {
            $prompt = AIServicePromptBuilder::autoResponse($ticketContent, $category, $priority);

            return $this->client->request($prompt, 'response');
        });
    }

    /**
     * @param  array<int, array<string, mixed>>  $tickets
     * @return array<string, mixed>
     */
    public function analyzePatterns(array $tickets): array
    {
        $jsonTickets = json_encode($tickets);
        $cacheKey = 'ai:patterns:'.hash('xxh128', $jsonTickets);

        $result = Cache::remember($cacheKey, 3600, function () use ($tickets): string {
            $prompt = AIServicePromptBuilder::patternAnalysis($tickets);

            return $this->client->request($prompt, 'patterns');
        });

        return AIServiceJsonDecoder::decodeObject($result);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function suggestImprovements(array $data): array
    {
        $jsonData = json_encode($data);
        $cacheKey = 'ai:improvements:'.hash('xxh128', $jsonData);

        $result = Cache::remember($cacheKey, 3600, function () use ($data): string {
            $prompt = AIServicePromptBuilder::improvements($data);

            return $this->client->request($prompt, 'improvements');
        });

        return AIServiceJsonDecoder::decodeObject($result);
    }
}
