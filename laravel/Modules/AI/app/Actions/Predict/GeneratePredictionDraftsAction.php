<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Predict;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

use function Safe\json_decode;
use function Safe\preg_match;
use function Safe\preg_replace;


/**
 * Generate structured prediction drafts that can be persisted by the Predict module.
 */
final class GeneratePredictionDraftsAction
{
    /**
     * @return array<int, array{
     *   title: string,
     *   subtitle: string,
     *   description: string,
     *   category: string,
     *   tags: array<int, string>,
     *   analysis: string,
     *   event_end_date: string,
     *   liquidity: int,
     *   options: array<int, string>
     * }>
     */
    public function execute(int $count): array
    {
        Assert::range($count, 1, 100);

        /** @var string|null $apiKey */
        $apiKey = config('openai.api_key');
        if (! is_string($apiKey) || trim($apiKey) === '') {
            return $this->fallbackDrafts($count);
        }

        $apiKey = config('openai.api_key');
        if (! is_string($apiKey) || $apiKey === '') {
            return $this->fallbackDrafts($count);
        }

        $response = Http::withToken($apiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->resolveModel(),
                'temperature' => $this->resolveTemperature(),
                'max_tokens' => min(3800, max(1200, $count * 320)),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Sei un editor italiano specializzato in prediction market. Produci solo JSON valido, niente markdown e niente testo extra.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $this->buildPrompt($count),
                    ],
                ],
            ]);

        $rawData = $response->json();
        $rawText = is_array($rawData) ? data_get($rawData, 'choices.0.message.content', '') : '';
        $text = is_scalar($rawText) ? trim((string) $rawText) : '';

        return $this->parseDrafts($text, $count);
    }

    private function buildPrompt(int $count): string
    {
        return <<<PROMPT
Genera {$count} predizioni realistiche per un sito italiano di prediction market.

Rispondi solo con JSON valido, senza markdown, senza spiegazioni, senza testo extra.

Ogni elemento deve avere questa struttura:
{
  "title": "titolo chiaro e risolvibile",
  "subtitle": "sottotitolo breve",
  "description": "descrizione sintetica con criterio di risoluzione chiaro",
  "category": "Sport|Crypto|Politica|Tecnologia|Economia|Intrattenimento|Scienza",
  "tags": ["tag1", "tag2", "tag3"],
  "analysis": "approfondimento editoriale di 3-5 frasi con contesto, fattori chiave e rischio principale",
  "event_end_date": "YYYY-MM-DD",
  "liquidity": 1000,
  "options": ["Opzione 1", "Opzione 2", "Opzione 3"]
}

Regole:
- lingua italiana
- predizioni specifiche, verificabili e non vaghe
- evitare domande gia risolte o nel passato
- tag brevi e pertinenti
- date future ragionevoli
- liquidita' intera tra 1000 e 50000
- evitare duplicati
- IMPORTANTISSIMO: Preferisci mercati MULTIPLE CHOICE (3-6 opzioni) rispetto ai binari (Sì/No). Solo il 20% dei mercati deve essere binario.
- le opzioni devono essere esaustive e mutuamente esclusive.
- ogni descrizione deve indicare in modo implicito o esplicito come si decide l esito
- restituire un array JSON con esattamente {$count} elementi
PROMPT;
    }

    /**
     * @return array<int, array{
     *   title: string,
     *   subtitle: string,
     *   description: string,
     *   category: string,
     *   tags: array<int, string>,
     *   analysis: string,
     *   event_end_date: string,
     *   liquidity: int,
     *   options: array<int, string>
     * }>
     */
    private function parseDrafts(string $text, int $expectedCount): array
    {
        $normalized = trim($text);
        $normalized = $this->replaceRegex('/^```json\s*/', '', $normalized);
        $normalized = $this->replaceRegex('/^```\s*/', '', $normalized);
        $normalized = $this->replaceRegex('/\s*```$/', '', $normalized);

        /** @var mixed $decoded */
        $decoded = json_decode($normalized, true);
        if (! is_array($decoded)) {
            return $this->fallbackDrafts($expectedCount);
        }

        $drafts = [];

        foreach ($decoded as $item) {
            if (! is_array($item)) {
                continue;
            }

            $title = $this->toNormalizedString(Arr::get($item, 'title', ''));
            $subtitle = $this->toNormalizedString(Arr::get($item, 'subtitle', ''));
            $description = $this->toNormalizedString(Arr::get($item, 'description', ''));
            $category = $this->toNormalizedString(Arr::get($item, 'category', 'Altro'));
            $analysis = $this->toNormalizedString(Arr::get($item, 'analysis', ''));
            $eventEndDate = $this->toNormalizedString(Arr::get($item, 'event_end_date', ''));
            /** @var array<int, mixed> $tags */
            $tags = array_values(Arr::wrap(Arr::get($item, 'tags', [])));
            $rawLiquidity = Arr::get($item, 'liquidity', 5000);
            $liquidity = is_numeric($rawLiquidity) ? (int) $rawLiquidity : 5000;
            $options = $this->normalizeOptions(Arr::get($item, 'options', []));

            if ($title === '' || $description === '' || $analysis === '') {
                continue;
            }

            $drafts[] = [
                'title' => Str::limit($title, 140, ''),
                'subtitle' => $subtitle,
                'description' => $description,
                'category' => $category !== '' ? $category : 'Altro',
                'tags' => $this->normalizeTags($tags),
                'analysis' => $analysis,
                'event_end_date' => $this->normalizeDate($eventEndDate),
                'liquidity' => max(1000, min(50000, $liquidity)),
                'options' => $options,
            ];
        }

        if (count($drafts) < $expectedCount) {
            return $this->fallbackDrafts($expectedCount);
        }

        /** @var array<int, array{title: string, subtitle: string, description: string, category: string, tags: array<int, string>, analysis: string, event_end_date: string, liquidity: int, options: array<int, string>}> $sliced */
        $sliced = array_slice($drafts, 0, $expectedCount);

        return $sliced;
    }

    private function resolveModel(): string
    {
        $rawModel = config('ai.chat_model', 'gpt-4o-mini');

        return is_string($rawModel) && trim($rawModel) !== '' ? $rawModel : 'gpt-4o-mini';
    }

    private function resolveTemperature(): float
    {
        $rawTemperature = config('ai.temperature', 0.6);

        return is_numeric($rawTemperature) ? (float) $rawTemperature : 0.6;
    }

    private function toNormalizedString(mixed $value): string
    {
        return is_scalar($value) ? trim((string) $value) : '';
    }

    /**
     * @return array<int, string>
     */
    private function normalizeOptions(mixed $value): array
    {
        $items = Arr::wrap($value);
        $options = [];

        foreach ($items as $item) {
            if (! is_scalar($item)) {
                continue;
            }

            $normalized = trim((string) $item);
            if ($normalized === '') {
                continue;
            }

            $options[] = $normalized;
        }

        return $options;
    }

    /**
     * @param  array<int, mixed>  $tags
     * @return array<int, string>
     */
    private function normalizeTags(array $tags): array
    {
        $normalized = [];

        foreach ($tags as $tag) {
            if (! is_scalar($tag)) {
                continue;
            }

            $value = trim((string) $tag);
            if ($value === '') {
                continue;
            }

            $normalized[] = Str::lower(Str::limit($value, 32, ''));
        }

        $normalized = array_values(array_unique($normalized));

        if ($normalized === []) {
            return ['prediction-market', 'mercati', 'forecast'];
        }

        return $normalized;
    }

    private function normalizeDate(string $date): string
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) === 1) {
            return $date;
        }

        return now()->addDays(30)->toDateString();
    }

    /**
     * @return array<int, array{
     *   title: string,
     *   subtitle: string,
     *   description: string,
     *   category: string,
     *   tags: array<int, string>,
     *   analysis: string,
     *   event_end_date: string,
     *   liquidity: int,
     *   options: array<int, string>
     * }>
     */
    private function fallbackDrafts(int $count): array
    {
        $templates = [
            [
                'category' => 'Sport',
                'title' => 'La squadra italiana vincera una coppa europea entro la fine della stagione?',
                'subtitle' => 'Calcio europeo',
                'description' => 'Mercato su una possibile vittoria internazionale di un club italiano nella stagione corrente.',
                'analysis' => 'Il mercato combina forma recente, profondita della rosa e calendario residuo. La domanda e risolvibile con un esito pubblico e chiaro.',
                'tags' => ['sport', 'calcio', 'europa'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Crypto',
                'title' => 'Bitcoin chiudera il trimestre sopra i 120000 dollari?',
                'subtitle' => 'Mercati crypto',
                'description' => 'Predizione sul prezzo di chiusura trimestrale di Bitcoin rispetto a una soglia chiara.',
                'analysis' => 'La domanda e verificabile su fonti di mercato pubbliche e ha una soglia netta. E utile per utenti che seguono momentum e volatilita.',
                'tags' => ['crypto', 'bitcoin', 'mercati'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Politica',
                'title' => 'Il governo approvera una riforma fiscale strutturale entro sei mesi?',
                'subtitle' => 'Politica italiana',
                'description' => 'Mercato politico su approvazione formale di una riforma fiscale entro una finestra temporale definita.',
                'analysis' => 'La risoluzione puo essere legata a fonti istituzionali. La domanda resta concreta e non dipende da interpretazioni troppo elastiche.',
                'tags' => ['politica', 'italia', 'riforme'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Tecnologia',
                'title' => 'Un nuovo modello AI open source superera il benchmark di riferimento entro 90 giorni?',
                'subtitle' => 'AI e benchmark',
                'description' => 'Predizione su rilascio e performance di un modello AI open source rispetto a un benchmark noto.',
                'analysis' => 'La metrica deve essere definita prima della pubblicazione del mercato. Questo rende la risoluzione trasparente e difendibile.',
                'tags' => ['ai', 'open-source', 'benchmark'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Economia',
                'title' => 'La BCE tagliera i tassi almeno due volte entro l anno?',
                'subtitle' => 'Politica monetaria',
                'description' => 'Mercato macroeconomico legato alle decisioni ufficiali sui tassi nell anno in corso.',
                'analysis' => 'La domanda ha una fonte di risoluzione ufficiale e facilita una lettura probabilistica chiara da parte degli utenti.',
                'tags' => ['economia', 'bce', 'tassi'],
                'options' => ['0.25%', '0.50%', 'Mantenimento', 'Altro'],
            ],
            [
                'category' => 'Intrattenimento',
                'title' => 'Un film italiano entrera nella top 10 box office europea entro l estate?',
                'subtitle' => 'Cinema europeo',
                'description' => 'Mercato entertainment basato su ranking di box office europei in una finestra temporale definita.',
                'analysis' => 'La domanda usa una metrica pubblica e permette una risoluzione semplice. Il copy puo attirare anche utenti non specialisti.',
                'tags' => ['cinema', 'box-office', 'europa'],
                'options' => ['Sì', 'No'],
            ],
            [
                'category' => 'Scienza',
                'title' => 'Una terapia innovativa otterra un via libera regolatorio entro 12 mesi?',
                'subtitle' => 'Ricerca e salute',
                'description' => 'Predizione su un evento regolatorio chiaro relativo a una terapia innovativa.',
                'analysis' => 'La risoluzione e ancorata a una decisione pubblica. Il mercato e utile per utenti interessati a scienza applicata e health innovation.',
                'tags' => ['scienza', 'salute', 'regolatorio'],
                'options' => ['Sì', 'No'],
            ],
        ];

        $drafts = [];
        $usedTitles = [];

        for ($index = 0; $index < $count; $index++) {
            $templateIndex = $index % count($templates);
            $template = $templates[$templateIndex];

            // Generate unique title by adding index suffix for duplicates
            $baseTitle = $template['title'];
            $title = $baseTitle;
            $suffix = 1;

            while (in_array($title, $usedTitles, true)) {
                // Add variation to make title unique
                $trimmedBaseTitle = $this->replaceRegex('/\?$/', '', $baseTitle);
                $title = $trimmedBaseTitle.' - Variante '.$suffix.'?';
                $suffix++;
            }

            $usedTitles[] = $title;

            $drafts[] = [
                'title' => $title,
                'subtitle' => $template['subtitle'].' ('.($index + 1).')',
                'description' => $template['description'],
                'category' => $template['category'],
                'tags' => $template['tags'],
                'analysis' => $template['analysis'],
                'event_end_date' => now()->addDays(20 + ($index * 11))->toDateString(),
                'liquidity' => 5000 + ($index * 750),
                'options' => $template['options'],
            ];
        }

        /** @var list<array{title: string, subtitle: string, description: string, category: string, tags: array<int, string>, analysis: string, event_end_date: string, liquidity: int, options: array<int, string>}> $draftsList */
        $draftsList = $drafts;

        return $draftsList;
    }

    private function replaceRegex(string $pattern, string $replacement, string $subject): string
    {
        $result = preg_replace($pattern, $replacement, $subject);

        return is_string($result) ? $result : $subject;
    }
}
