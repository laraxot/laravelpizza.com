<?php

declare(strict_types=1);

namespace Modules\AI\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
    private string $apiKey;

    private string $baseUrl;

    private int $timeout;

    private int $retryAttempts;

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

        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
        $this->timeout = $timeout;
        $this->retryAttempts = $retryAttempts;
    }

    /**
     * Classifica automaticamente un ticket
     *
     * @return array<string, mixed>
     */
    public function classifyTicket(string $title, string $description): array
    {
        $cacheKey = 'ai:classification:'.md5($title.$description);

        $result = Cache::remember($cacheKey, 3600, function () use ($title, $description) {
            $prompt = $this->buildClassificationPrompt($title, $description);

            return $this->makeAIRequest($prompt, 'classification');
        });

        return $this->decodeJsonObject($result);
    }

    /**
     * Suggerisce soluzioni per un ticket
     *
     * @return array<string, mixed>
     */
    public function suggestSolutions(string $title, string $description, string $category): array
    {
        $cacheKey = 'ai:solutions:'.md5($title.$description.$category);

        $result = Cache::remember($cacheKey, 1800, function () use ($title, $description, $category) {
            $prompt = $this->buildSolutionPrompt($title, $description, $category);

            return $this->makeAIRequest($prompt, 'solutions');
        });

        return $this->decodeJsonObject($result);
    }

    /**
     * Analizza il sentiment di un ticket
     *
     * @return array<string, mixed>
     */
    public function analyzeSentiment(string $text): array
    {
        $cacheKey = 'ai:sentiment:'.md5($text);

        $result = Cache::remember($cacheKey, 1800, function () use ($text) {
            $prompt = $this->buildSentimentPrompt($text);

            return $this->makeAIRequest($prompt, 'sentiment');
        });

        return $this->decodeJsonObject($result);
    }

    /**
     * Predice la priorità di un ticket
     *
     * @param  array<string, mixed>  $context
     * @return array<string, mixed>
     */
    public function predictPriority(string $title, string $description, array $context = []): array
    {
        $contextStr = json_encode($context) ?: '{}';
        $cacheKey = 'ai:priority:'.md5($title.$description.$contextStr);

        $result = Cache::remember($cacheKey, 1800, function () use ($title, $description, $context) {
            $prompt = $this->buildPriorityPrompt($title, $description, $context);

            return $this->makeAIRequest($prompt, 'priority');
        });

        return $this->decodeJsonObject($result);
    }

    /**
     * Ottimizza il routing dei ticket
     *
     * @param  array<int, array<string, mixed>>  $tickets
     * @param  array<int, array<string, mixed>>  $agents
     * @return array<string, mixed>
     */
    public function optimizeRouting(array $tickets, array $agents): array
    {
        $jsonTickets = json_encode($tickets);
        $jsonAgents = json_encode($agents);
        $cacheKey = 'ai:routing:'.md5($jsonTickets.$jsonAgents);

        $result = Cache::remember($cacheKey, 900, function () use ($tickets, $agents) {
            $prompt = $this->buildRoutingPrompt($tickets, $agents);

            return $this->makeAIRequest($prompt, 'routing');
        });

        return $this->decodeJsonObject($result);
    }

    /**
     * Genera risposta automatica per un ticket
     */
    public function generateAutoResponse(string $ticketContent, string $category, string $priority): string
    {
        $cacheKey = 'ai:response:'.md5($ticketContent.$category.$priority);

        return Cache::remember($cacheKey, 1800, function () use ($ticketContent, $category, $priority) {
            $prompt = $this->buildResponsePrompt($ticketContent, $category, $priority);

            return $this->makeAIRequest($prompt, 'response');
        });
    }

    /**
     * Analizza pattern nei ticket per insights
     *
     * @param  array<int, array<string, mixed>>  $tickets
     * @return array<string, mixed>
     */
    public function analyzePatterns(array $tickets): array
    {
        $jsonTickets = json_encode($tickets);
        $cacheKey = 'ai:patterns:'.md5($jsonTickets);

        $result = Cache::remember($cacheKey, 3600, function () use ($tickets) {
            $prompt = $this->buildPatternAnalysisPrompt($tickets);

            return $this->makeAIRequest($prompt, 'patterns');
        });

        return $this->decodeJsonObject($result);
    }

    /**
     * Suggerisce miglioramenti per il servizio
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function suggestImprovements(array $data): array
    {
        $jsonData = json_encode($data);
        $cacheKey = 'ai:improvements:'.md5($jsonData);

        $result = Cache::remember($cacheKey, 3600, function () use ($data) {
            $prompt = $this->buildImprovementPrompt($data);

            return $this->makeAIRequest($prompt, 'improvements');
        });

        return $this->decodeJsonObject($result);
    }

    /**
     * Costruisci prompt per classificazione
     */
    private function buildClassificationPrompt(string $title, string $description): string
    {
        return "Classifica il seguente ticket per il servizio di gestione ticket cittadini:

Titolo: {$title}
Descrizione: {$description}

Categorie disponibili:
- infrastruttura (strade, ponti, illuminazione, segnaletica)
- ambiente (rifiuti, inquinamento, verde pubblico)
- trasporti (trasporto pubblico, parcheggi, ciclabili)
- sicurezza (sicurezza urbana, emergenze)
- servizi (uffici pubblici, documenti, pratiche)
- altro

Rispondi in formato JSON con:
{
  \"category\": \"categoria_principale\",
  \"subcategory\": \"sottocategoria\",
  \"confidence\": 0.95,
  \"tags\": [\"tag1\", \"tag2\"],
  \"urgency_indicators\": [\"indicatore1\", \"indicatore2\"]
}";
    }

    /**
     * Costruisci prompt per soluzioni
     */
    private function buildSolutionPrompt(string $title, string $description, string $category): string
    {
        return "Suggerisci soluzioni per questo ticket di {$category}:

Titolo: {$title}
Descrizione: {$description}

Fornisci 3-5 soluzioni pratiche e concrete, specifiche per il contesto italiano e le amministrazioni pubbliche.

Rispondi in formato JSON:
{
  \"solutions\": [
    {
      \"title\": \"Titolo soluzione\",
      \"description\": \"Descrizione dettagliata\",
      \"steps\": [\"passo1\", \"passo2\"],
      \"estimated_time\": \"2-3 giorni\",
      \"required_resources\": [\"risorsa1\", \"risorsa2\"],
      \"priority\": \"high|medium|low\"
    }
  ],
  \"preventive_measures\": [\"misura1\", \"misura2\"],
  \"follow_up_actions\": [\"azione1\", \"azione2\"]
}";
    }

    /**
     * Costruisci prompt per sentiment
     */
    private function buildSentimentPrompt(string $text): string
    {
        return "Analizza il sentiment del seguente testo di un cittadino:

{$text}

Rispondi in formato JSON:
{
  \"sentiment\": \"positive|negative|neutral\",
  \"emotion\": \"soddisfazione|frustrazione|preoccupazione|rabbia|speranza\",
  \"confidence\": 0.85,
  \"key_phrases\": [\"frase1\", \"frase2\"],
  \"urgency_level\": \"low|medium|high|critical\",
  \"recommended_response_tone\": \"professionale|empatico|rassicurante|decisivo\"
}";
    }

    /**
     * Costruisci prompt per priorità
     *
     * @param  array<string, mixed>  $context
     */
    private function buildPriorityPrompt(string $title, string $description, array $context): string
    {
        $contextStr = json_encode($context, JSON_PRETTY_PRINT);

        return "Predici la priorità di questo ticket:

Titolo: {$title}
Descrizione: {$description}
Contesto: {$contextStr}

Considera:
- Impatto sulla sicurezza pubblica
- Numero di cittadini coinvolti
- Urgenza temporale
- Complessità di risoluzione
- Risorse disponibili

Rispondi in formato JSON:
{
  \"priority\": \"low|medium|high|urgent|critical\",
  \"confidence\": 0.90,
  \"reasoning\": \"motivazione dettagliata\",
  \"estimated_resolution_time\": \"1-2 giorni\",
  \"required_escalation\": true|false,
  \"risk_factors\": [\"fattore1\", \"fattore2\"]
}";
    }

    /**
     * Costruisci prompt per routing
     *
     * @param  array<int, array<string, mixed>>  $tickets
     * @param  array<int, array<string, mixed>>  $agents
     */
    private function buildRoutingPrompt(array $tickets, array $agents): string
    {
        $ticketsStr = json_encode($tickets, JSON_PRETTY_PRINT);
        $agentsStr = json_encode($agents, JSON_PRETTY_PRINT);

        return "Ottimizza l'assegnazione di questi ticket agli agenti disponibili:

Ticket: {$ticketsStr}
Agenti: {$agentsStr}

Considera:
- Competenze degli agenti
- Carico di lavoro attuale
- Specializzazione per categoria
- Disponibilità temporale
- Precedenti performance

Rispondi in formato JSON:
{
  \"assignments\": [
    {
      \"ticket_id\": 123,
      \"agent_id\": 456,
      \"reason\": \"motivazione assegnazione\",
      \"estimated_completion\": \"2024-01-15\",
      \"confidence\": 0.85
    }
  ],
  \"unassigned_tickets\": [789],
  \"overload_warnings\": [\"agent1 ha troppi ticket\"],
  \"efficiency_score\": 0.92
}";
    }

    /**
     * Costruisci prompt per risposta automatica
     */
    private function buildResponsePrompt(string $ticketContent, string $category, string $priority): string
    {
        return "Genera una risposta automatica professionale per questo ticket:

Contenuto: {$ticketContent}
Categoria: {$category}
Priorità: {$priority}

La risposta deve essere:
- Professionale ma amichevole
- Rassicurante per il cittadino
- Specifica per la categoria
- Adatta alla priorità
- In italiano corretto
- Lunga 2-3 paragrafi

Rispondi solo con il testo della risposta, senza formattazione aggiuntiva.";
    }

    /**
     * Costruisci prompt per analisi pattern
     *
     * @param  array<int, array<string, mixed>>  $tickets
     */
    private function buildPatternAnalysisPrompt(array $tickets): string
    {
        $ticketsStr = json_encode($tickets, JSON_PRETTY_PRINT);

        return "Analizza i pattern in questi ticket per identificare:

Ticket: {$ticketsStr}

Identifica:
- Trend temporali
- Aree geografiche problematiche
- Categorie più frequenti
- Pattern stagionali
- Correlazioni tra fattori
- Opportunità di miglioramento

Rispondi in formato JSON:
{
  \"temporal_trends\": {
    \"peak_hours\": [\"9-11\", \"14-16\"],
    \"peak_days\": [\"lunedì\", \"martedì\"],
    \"seasonal_patterns\": {\"estate\": \"+20%\"}
  },
  \"geographic_hotspots\": [
    {\"area\": \"centro\", \"count\": 45, \"trend\": \"increasing\"}
  ],
  \"category_insights\": {
    \"most_common\": \"infrastruttura\",
    \"growing\": \"ambiente\",
    \"declining\": \"trasporti\"
  },
  \"recommendations\": [
    \"Aumentare personale nelle ore di picco\",
    \"Focus su area centro\"
  ]
}";
    }

    /**
     * Costruisci prompt per miglioramenti
     *
     * @param  array<string, mixed>  $data
     */
    private function buildImprovementPrompt(array $data): string
    {
        $dataStr = json_encode($data, JSON_PRETTY_PRINT);

        return "Suggerisci miglioramenti per il servizio di gestione ticket basandoti su questi dati:

Dati: {$dataStr}

Fornisci suggerimenti per:
- Processi operativi
- Tecnologie
- Formazione personale
- Comunicazione cittadini
- Metriche di performance

Rispondi in formato JSON:
{
  \"process_improvements\": [
    {
      \"area\": \"assegnazione ticket\",
      \"suggestion\": \"Implementare sistema di priorità dinamica\",
      \"impact\": \"high\",
      \"effort\": \"medium\"
    }
  ],
  \"technology_upgrades\": [
    {
      \"technology\": \"AI routing\",
      \"description\": \"Sistema di assegnazione automatica\",
      \"benefits\": [\"efficienza\", \"soddisfazione\"],
      \"cost_estimate\": \"€50k\"
    }
  ],
  \"training_recommendations\": [
    {
      \"role\": \"operatori\",
      \"topics\": [\"comunicazione\", \"tecniche risoluzione\"],
      \"format\": \"workshop\",
      \"duration\": \"2 giorni\"
    }
  ]
}";
    }

    /**
     * Effettua richiesta all'API AI
     */
    private function makeAIRequest(string $prompt, string $type): string
    {
        $attempt = 0;

        while ($attempt < $this->retryAttempts) {
            try {
                $response = Http::timeout($this->timeout)
                    ->withHeaders([
                        'Authorization' => 'Bearer '.$this->apiKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->post($this->baseUrl.'/chat/completions', [
                        'model' => 'gpt-4',
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => 'Sei un assistente AI specializzato nella gestione di ticket per amministrazioni pubbliche italiane. Rispondi sempre in formato JSON valido.',
                            ],
                            [
                                'role' => 'user',
                                'content' => $prompt,
                            ],
                        ],
                        'temperature' => 0.3,
                        'max_tokens' => 2000,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    Assert::isArray($data, 'API response must be an array');

                    if (isset($data['choices']) && is_array($data['choices']) &&
                        isset($data['choices'][0]) && is_array($data['choices'][0]) &&
                        isset($data['choices'][0]['message']) && is_array($data['choices'][0]['message']) &&
                        isset($data['choices'][0]['message']['content'])) {
                        $content = $data['choices'][0]['message']['content'];
                        Assert::string($content, 'API content must be a string');

                        return $content;
                    }

                    return '';
                }

                Log::warning('AI API request failed', [
                    'type' => $type,
                    'attempt' => $attempt + 1,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
            } catch (\Exception $e) {
                Log::error('AI API request error', [
                    'type' => $type,
                    'attempt' => $attempt + 1,
                    'error' => $e->getMessage(),
                ]);
            }

            $attempt++;
            sleep(pow(2, $attempt)); // Exponential backoff
        }

        throw new \Exception('AI API request failed after '.$this->retryAttempts.' attempts');
    }

    /**
     * @return array<string, mixed>
     */
    private function decodeJsonObject(string $result): array
    {
        $normalized = trim($result);
        if ($normalized === '') {
            return [];
        }

        try {
            $decoded = \Safe\json_decode($normalized, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($decoded)) {
                return [];
            }

            $result = [];
            foreach ($decoded as $key => $value) {
                if (! is_string($key)) {
                    continue;
                }

                $result[$key] = $value;
            }

            return $result;
        } catch (\Throwable) {
            return [];
        }
    }
}
