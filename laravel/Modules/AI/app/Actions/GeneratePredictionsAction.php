<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Modules\AI\Datas\PredictionData;
use RuntimeException;
use Safe\DateTime;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

use function Safe\json_decode;
use function Safe\preg_replace;

/**
 * Generate realistic predictions using AI for prediction markets.
 *
 * This action uses OpenAI API to generate realistic prediction market data
 * including title, description, content, category, tags, and market parameters.
 */
class GeneratePredictionsAction
{
    use QueueableAction;

    /**
     * Execute the AI prediction generation.
     *
     * @param  array<string, mixed>  $options
     *
     * @throws Throwable
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function execute(string $topic, array $options = []): PredictionData
    {
        Log::info('Starting AI prediction generation', [
            'topic' => $topic,
            'options' => $options,
        ]);

        $prompt = $this->buildPrompt($topic, $options);

        $response = $this->callOpenAI($prompt);

        $data = $this->parseResponse($response);

        $this->validate($data);

        $predictionData = PredictionData::fromOpenAIResponse($data);

        Log::info('AI prediction generated successfully', [
            'topic' => $topic,
            'title' => $predictionData->title,
            'category' => $predictionData->category,
        ]);

        return $predictionData;
    }

    /**
     * Build the prompt for OpenAI.
     *
     * @param  array<string, mixed>  $options
     */
    private function buildPrompt(string $topic, array $options): string
    {
        $rawCategory = $options['category'] ?? 'generico';
        $rawLanguage = $options['language'] ?? 'italiano';
        $category = is_scalar($rawCategory) ? trim((string) $rawCategory) : 'generico';
        $language = is_scalar($rawLanguage) ? trim((string) $rawLanguage) : 'italiano';
        $today = now()->format('Y-m-d');

        return <<<PROMPT
Genera una predizione realistica e dettagliata per un prediction market su: {$topic}

Categoria: {$category}
Lingua: {$language}
Data odierna: {$today}

Includi TUTTI i seguenti campi in formato JSON valido:

{
  "title": "Titolo accattivante e chiaro in {$language}",
  "description": "Descrizione chiara e concisa in 2-3 frasi",
  "content": "Contenuto dettagliato e ben strutturato di 300-500 parole che spiega il contesto, i criteri di risoluzione, e le informazioni rilevanti",
  "excerpt": "Estratto breve di 1-2 frasi per anteprima",
  "category": "Nome della categoria più appropriata (es: Politica, Sport, Economia, Tecnologia, Scienza, Intrattenimento)",
  "tags": ["tag1", "tag2", "tag3", "tag4"],
  "closed_at": "Data di chiusura YYYY-MM-DD (tra 30-60 giorni da oggi)",
  "ends_at": "Data di risoluzione YYYY-MM-DD (tra 60-90 giorni da oggi)",
  "liquidity_parameter": 0.5,
  "stocks_count": 1000,
  "is_wagerable": true,
  "content_block": "Contenuto principale formattato in blocchi",
  "sidebar_block": "Informazioni laterali utili",
  "footer_block": "Note aggiuntive e riferimenti"
}

REGOLE IMPORTANTI:
1. Restituisci SOLO il JSON, niente altro testo
2. Assicurati che il JSON sia valido e ben formattato
3. Usa date realistiche e coerenti con l'argomento
4. I tags devono essere rilevanti e specifici per l'argomento
5. La descrizione deve essere chiara sui criteri di risoluzione
6. Il contenuto deve essere neutrale e informativo
7. Categoria deve essere una delle seguenti: Politica, Sport, Economia, Tecnologia, Scienza, Intrattenimento, Salute, Ambiente

Esempio di argomento: "Elezioni politiche Italia 2026"
Esempio di titolo: "Chi vincerà le elezioni politiche in Italia nel 2026?"
Esempio di descrizione: "Questa predizione riguarda il partito che otterrà la maggioranza relativa alle elezioni politiche italiane del 2026."

PROMPT;
    }

    /**
     * Call OpenAI API.
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    private function callOpenAI(string $prompt): string
    {
        $config = $this->resolveOpenAiConfig();

        Log::debug('Calling OpenAI API', [
            'model' => $config['model'],
            'temperature' => $config['temperature'],
            'max_tokens' => $config['maxTokens'],
        ]);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$config['apiKey']}",
            'Content-Type' => 'application/json',
        ])
            ->timeout(30)
            ->post('https://api.openai.com/v1/completions', [
                'model' => $config['model'],
                'prompt' => $prompt,
                'temperature' => $config['temperature'],
                'max_tokens' => $config['maxTokens'],
                'top_p' => 1.0,
                'frequency_penalty' => 0.0,
                'presence_penalty' => 0.0,
            ]);

        if ($response->failed()) {
            Log::error('OpenAI API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new RuntimeException('OpenAI API request failed: '.$response->body());
        }

        return $this->extractCompletionText($response->json());
    }

    /**
     * @return array{apiKey: string, model: string, temperature: float, maxTokens: int}
     */
    private function resolveOpenAiConfig(): array
    {
        $rawApiKey = config('services.openai.api_key');
        $apiKey = is_string($rawApiKey) ? $rawApiKey : '';

        $rawModel = config('ai.model', 'gpt-3.5-turbo-instruct');
        $model = is_string($rawModel) ? $rawModel : 'gpt-3.5-turbo-instruct';

        $rawTemperature = config('ai.temperature', 0.7);
        $temperature = is_numeric($rawTemperature) ? (float) $rawTemperature : 0.7;

        $rawMaxTokens = config('ai.max_tokens', 1500);
        $maxTokens = is_numeric($rawMaxTokens) ? (int) $rawMaxTokens : 1500;

        return [
            'apiKey' => $apiKey,
            'model' => $model,
            'temperature' => $temperature,
            'maxTokens' => $maxTokens,
        ];
    }

    private function extractCompletionText(mixed $payload): string
    {
        $data = is_array($payload) ? $payload : [];
        $choices = $data['choices'] ?? null;
        $firstChoice = is_array($choices) ? ($choices[0] ?? null) : null;
        $text = is_array($firstChoice) ? ($firstChoice['text'] ?? '') : '';
        $result = is_string($text) ? $text : '';

        $usage = $data['usage'] ?? null;
        $totalTokens = is_array($usage) ? ($usage['total_tokens'] ?? 0) : 0;

        Log::debug('OpenAI API response received', [
            'tokens_used' => $totalTokens,
        ]);

        return trim($result);
    }

    /**
     * Parse the OpenAI response.
     *
     * @return array<string, mixed>
     *
     * @throws \JsonException
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    private function parseResponse(string $response): array
    {
        // Remove markdown code blocks if present
        $response = $this->stripMarkdownFence($response, '/^```json\s*/i');
        $response = $this->stripMarkdownFence($response, '/^```\s*/i');
        $response = $this->stripMarkdownFence($response, '/\s*```$/');
        $response = trim($response);

        Log::debug('Parsing OpenAI response', [
            'response_length' => strlen($response),
        ]);

        /** @var array<string, mixed> $parsed */
        $parsed = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        return $parsed;
    }

    /**
     * Validate the generated data.
     *
     * @param  array<string, mixed>  $data
     *
     * @throws InvalidArgumentException
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    private function validate(array $data): void
    {
        Log::debug('Validating prediction data', ['data' => $data]);

        $this->validateRequiredFields($data);
        $this->validateClosedAt($data);
        $this->validateTags($data);
        $this->validateLiquidityParameter($data);

        Log::debug('Validation passed');
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function validateRequiredFields(array $data): void
    {
        foreach (['title', 'description', 'content', 'category', 'tags', 'closed_at'] as $field) {
            if (! isset($data[$field]) || $data[$field] === '') {
                Log::error('Missing required field', ['field' => $field]);
                throw new InvalidArgumentException("Missing required field: {$field}");
            }
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function validateClosedAt(array $data): void
    {
        try {
            $rawClosedAt = $data['closed_at'];
            if (! is_scalar($rawClosedAt)) {
                throw new InvalidArgumentException('Invalid closed_at date format');
            }

            $closedAt = new DateTime(trim((string) $rawClosedAt));
            if ($closedAt <= new DateTime) {
                throw new InvalidArgumentException('closed_at must be in the future');
            }
        } catch (Exception) {
            throw new InvalidArgumentException('Invalid closed_at date format');
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function validateTags(array $data): void
    {
        if (! is_array($data['tags'])) {
            throw new InvalidArgumentException('tags must be an array');
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function validateLiquidityParameter(array $data): void
    {
        if (! isset($data['liquidity_parameter'])) {
            return;
        }

        $rawLiquidity = $data['liquidity_parameter'];
        if (! is_numeric($rawLiquidity)) {
            throw new InvalidArgumentException('liquidity_parameter must be numeric');
        }

        $liquidity = (float) $rawLiquidity;
        if ($liquidity < 0 || $liquidity > 1) {
            throw new InvalidArgumentException('liquidity_parameter must be between 0 and 1');
        }
    }

    private function stripMarkdownFence(string $value, string $pattern): string
    {
        $replaced = preg_replace($pattern, '', $value);

        return is_string($replaced) ? $replaced : $value;
    }
}
