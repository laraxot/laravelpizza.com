# AI Module - Generate Predictions Action

## Panoramica

Il modulo AI fornisce azioni per generare contenuti utilizzando intelligenza artificiale. Questa documentazione descrive l'implementazione di `GeneratePredictionsAction` per la creazione di predizioni realistiche.

## Architettura AI Module

```
Modules/AI/
├── app/
│   ├── Actions/
│   │   ├── CompletionAction.php (esistente)
│   │   ├── SentimentAction.php (esistente)
│   │   └── GeneratePredictionsAction.php (nuovo)
│   ├── Datas/
│   │   ├── CompletionData.php (esistente)
│   │   └── PredictionData.php (nuovo)
│   └── Services/
│       └── OpenAIService.php (opzionale)
├── config/
│   └── ai.php (da creare)
└── tests/
    └── Unit/
        └── Actions/
            └── GeneratePredictionsActionTest.php (nuovo)
```

## GeneratePredictionsAction

### Classe Principale

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Modules\AI\Datas\PredictionData;
use Modules\AI\Services\OpenAIService;
use Spatie\QueueableAction\QueueableAction;

class GeneratePredictionsAction
{
    use QueueableAction;

    public function __construct(
        private OpenAIService $openAIService
    ) {}

    /**
     * Execute the AI prediction generation.
     * 
     * @param array<string, mixed> $options
     */
    public function execute(string $topic, array $options = []): PredictionData
    {
        $prompt = $this->buildPrompt($topic, $options);
        
        $response = $this->openAIService->complete($prompt);
        
        $data = $this->parseResponse($response);
        
        $this->validate($data);
        
        return PredictionData::from($data);
    }

    /**
     * Build the prompt for OpenAI.
     * 
     * @param array<string, mixed> $options
     */
    private function buildPrompt(string $topic, array $options): string
    {
        $category = $options['category'] ?? 'generico';
        $language = $options['language'] ?? 'it';
        
        return <<<PROMPT
Genera una predizione realistica per un prediction market su: {$topic}

Categoria: {$category}
Lingua: {$language}

Includi TUTTI i seguenti campi in formato JSON:

{
  "title": "Titolo accattivante in {$language}",
  "description": "Descrizione chiara in 2-3 frasi",
  "content": "Contenuto dettagliato 300-500 parole",
  "excerpt": "Estratto breve per anteprima",
  "category": "Nome categoria appropriata",
  "tags": ["tag1", "tag2", "tag3"],
  "closed_at": "YYYY-MM-DD (30-60 giorni da oggi)",
  "ends_at": "YYYY-MM-DD (60-90 giorni da oggi)",
  "liquidity_parameter": 0.5,
  "stocks_count": 1000,
  "is_wagerable": true
}

IMPORTANTE:
- Restituisci SOLO il JSON, niente altro testo
- Assicurati che il JSON sia valido
- Usa date realistiche e coerenti
- I tags devono essere rilevanti per l'argomento
PROMPT;
    }

    /**
     * Parse the OpenAI response.
     * 
     * @return array<string, mixed>
     */
    private function parseResponse(string $response): array
    {
        // Remove markdown code blocks if present
        $response = preg_replace('/^```json\s*/', '', $response);
        $response = preg_replace('/\s*```$/', '', $response);
        $response = trim($response);
        
        /** @var array<string, mixed> $data */
        $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        
        return $data;
    }

    /**
     * Validate the generated data.
     * 
     * @param array<string, mixed> $data
     * @throws \InvalidArgumentException
     */
    private function validate(array $data): void
    {
        $required = ['title', 'description', 'content', 'category', 'tags', 'closed_at'];
        
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }
        
        // Validate dates
        if (isset($data['closed_at'])) {
            $closedAt = new \DateTime($data['closed_at']);
            $today = new \DateTime();
            
            if ($closedAt <= $today) {
                throw new \InvalidArgumentException('closed_at must be in the future');
            }
        }
        
        // Validate tags is array
        if (!is_array($data['tags'])) {
            throw new \InvalidArgumentException('tags must be an array');
        }
    }
}
```

## PredictionData DTO

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Spatie\LaravelData\Data;

class PredictionData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public string $content,
        public string $excerpt,
        public string $category,
        /** @var array<int, string> */
        public array $tags,
        public string $closed_at,
        public string $ends_at,
        public float $liquidity_parameter,
        public int $stocks_count,
        public bool $is_wagerable,
    ) {}

    /**
     * Convert to array for Predict model.
     * 
     * @return array<string, mixed>
     */
    public function toPredictArray(): array
    {
        return [
            'title' => ['it' => $this->title],
            'description' => $this->description,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category_name' => $this->category,
            'tags' => $this->tags,
            'closed_at' => $this->closed_at,
            'ends_at' => $this->ends_at,
            'liquidity_parameter' => $this->liquidity_parameter,
            'stocks_count' => $this->stocks_count,
            'is_wagerable' => $this->is_wagerable,
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
```

## OpenAIService

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService
{
    /**
     * Complete a prompt using OpenAI API.
     */
    public function complete(string $prompt): string
    {
        $result = OpenAI::completions()->create([
            'model' => config('ai.model', 'gpt-3.5-turbo-instruct'),
            'prompt' => $prompt,
            'temperature' => config('ai.temperature', 0.7),
            'max_tokens' => config('ai.max_tokens', 1000),
            'top_p' => 1.0,
            'frequency_penalty' => 0.0,
            'presence_penalty' => 0.0,
        ]);

        return trim($result->choices[0]->text ?? '');
    }

    /**
     * Complete using chat completion API.
     * 
     * @param array<int, array<string, string>> $messages
     */
    public function chat(array $messages): string
    {
        $result = OpenAI::chat()->create([
            'model' => config('ai.chat_model', 'gpt-3.5-turbo'),
            'messages' => $messages,
            'temperature' => config('ai.temperature', 0.7),
            'max_tokens' => config('ai.max_tokens', 1000),
        ]);

        return trim($result->choices[0]->message->content ?? '');
    }
}
```

## Configurazione

### File config/ai.php

```php
<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI Model
    |--------------------------------------------------------------------------
    */
    'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo-instruct'),

    /*
    |--------------------------------------------------------------------------
    | Chat Model
    |--------------------------------------------------------------------------
    */
    'chat_model' => env('OPENAI_CHAT_MODEL', 'gpt-3.5-turbo'),

    /*
    |--------------------------------------------------------------------------
    | Temperature
    |--------------------------------------------------------------------------
    */
    'temperature' => env('OPENAI_TEMPERATURE', 0.7),

    /*
    |--------------------------------------------------------------------------
    | Max Tokens
    |--------------------------------------------------------------------------
    */
    'max_tokens' => env('OPENAI_MAX_TOKENS', 1000),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limit' => [
        'max_predictions_per_request' => 100,
        'delay_between_calls_ms' => 1000,
        'timeout_seconds' => 30,
    ],

];
```

## Utilizzo

### Esempio Base

```php
use Modules\AI\Actions\GeneratePredictionsAction;

$action = app(GeneratePredictionsAction::class);

$prediction = $action->execute('Elezioni politiche Italia 2026');

// PredictionData object
echo $prediction->title;
echo $prediction->description;
```

### Con Opzioni

```php
$prediction = $action->execute(
    'Elezioni politiche Italia 2026',
    [
        'category' => 'Politica',
        'language' => 'it',
    ]
);
```

### Batch Generation

```php
$predictions = [];

for ($i = 0; $i < 10; $i++) {
    $predictions[] = $action->execute("Topic {$i}");
    
    // Rate limiting
    sleep(1);
}
```

## Testing

### Unit Test

```php
<?php

use Modules\AI\Actions\GeneratePredictionsAction;
use Modules\AI\Services\OpenAIService;

it('generates valid prediction data', function () {
    $openAIService = Mockery::mock(OpenAIService::class);
    
    $openAIService->shouldReceive('complete')
        ->once()
        ->andReturn('{
            "title": "Test Prediction",
            "description": "Test description",
            "content": "Test content",
            "excerpt": "Test excerpt",
            "category": "Test",
            "tags": ["test", "prediction"],
            "closed_at": "2026-04-12",
            "ends_at": "2026-05-12",
            "liquidity_parameter": 0.5,
            "stocks_count": 1000,
            "is_wagerable": true
        }');

    $action = new GeneratePredictionsAction($openAIService);
    $result = $action->execute('Test topic');

    expect($result)->toBeInstanceOf(\Modules\AI\Datas\PredictionData::class);
    expect($result->title)->toBe('Test Prediction');
    expect($result->tags)->toBeArray();
});
```

## Monitoraggio

### Logging

```php
use Illuminate\Support\Facades\Log;

Log::info('AI Prediction generated', [
    'topic' => $topic,
    'tokens_used' => $tokens,
    'duration_ms' => $duration,
    'model' => config('ai.model'),
]);
```

### Metriche

- **Predizioni generate**: Count totale
- **Tempo medio generazione**: Milliseconds
- **Error rate**: Percentage
- **Token usage**: Total tokens consumed

## Sicurezza

### Validazione

- Tutti gli input sono validati
- Il JSON response è parsato con `JSON_THROW_ON_ERROR`
- Le date sono validate per essere future
- I tags sono validati come array

### Rate Limiting

- Max 100 predizioni per richiesta
- Delay di 1 secondo tra chiamate API
- Timeout di 30 secondi per chiamata

## Riferimenti

- **Issue GitHub**: #66
- **Discussion**: #63
- **OpenAI API**: https://platform.openai.com/docs/api-reference
- **Laravel Data**: https://spatie.be/docs/laravel-data

---

**Ultimo aggiornamento**: 2026-03-12  
**Versione**: 1.0  
**Stato**: In sviluppo
