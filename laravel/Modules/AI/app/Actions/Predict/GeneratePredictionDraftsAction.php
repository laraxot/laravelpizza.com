<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Predict;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\AI\Actions\Cast\ScalarCasterAction;
use Modules\AI\Actions\Prediction\GetPredictionFallbackTemplatesAction;
use Modules\AI\Datas\AIConfigData;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\json_decode;
use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Generate structured prediction drafts that can be persisted by the Predict module.
 */
final class GeneratePredictionDraftsAction
{
    use QueueableAction;

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
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function execute(int $count): array
    {
        Assert::range($count, 1, 100);

        /** @var string|null $apiKey */
        $apiKey = config('openai.api_key');
        if (! is_string($apiKey) || trim($apiKey) === '') {
            return $this->fallbackDrafts($count);
        }

        $response = OpenAI::chat()->create([
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

        $rawText = data_get($response, 'choices.0.message.content', '');
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
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
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

        /** @var list<array{title: string, subtitle: string, description: string, category: string, tags: array<int, string>, analysis: string, event_end_date: string, liquidity: int, options: array<int, string>}> $drafts */
        $drafts = [];

        foreach ($decoded as $item) {
            if (! is_array($item)) {
                continue;
            }

            $draft = $this->mapDraftFromItem($item);
            if ($draft !== null) {
                $drafts[] = $draft;
            }
        }

        if (count($drafts) < $expectedCount) {
            return $this->fallbackDrafts($expectedCount);
        }

        return array_slice($drafts, 0, $expectedCount);
    }

    /**
     * @param  array<mixed, mixed>  $item
     * @return array{
     *   title: string,
     *   subtitle: string,
     *   description: string,
     *   category: string,
     *   tags: array<int, string>,
     *   analysis: string,
     *   event_end_date: string,
     *   liquidity: int,
     *   options: array<int, string>
     * }|null
     */
    private function mapDraftFromItem(array $item): ?array
    {
        $title = $this->toNormalizedString(Arr::get($item, 'title', ''));
        $description = $this->toNormalizedString(Arr::get($item, 'description', ''));
        $analysis = $this->toNormalizedString(Arr::get($item, 'analysis', ''));
        if (! $this->hasRequiredDraftFields($title, $description, $analysis)) {
            return null;
        }

        $category = $this->toNormalizedString(Arr::get($item, 'category', 'Altro'));
        $eventEndDate = $this->toNormalizedString(Arr::get($item, 'event_end_date', ''));
        /** @var array<int, mixed> $tags */
        $tags = array_values(Arr::wrap(Arr::get($item, 'tags', [])));
        $rawLiquidity = Arr::get($item, 'liquidity', 5000);
        $liquidity = is_numeric($rawLiquidity) ? (int) $rawLiquidity : 5000;

        return [
            'title' => Str::limit($title, 140, ''),
            'subtitle' => $this->toNormalizedString(Arr::get($item, 'subtitle', '')),
            'description' => $description,
            'category' => $category !== '' ? $category : 'Altro',
            'tags' => $this->normalizeTags($tags),
            'analysis' => $analysis,
            'event_end_date' => $this->normalizeDate($eventEndDate),
            'liquidity' => max(1000, min(50000, $liquidity)),
            'options' => $this->normalizeOptions(Arr::get($item, 'options', [])),
        ];
    }

    private function hasRequiredDraftFields(string $title, string $description, string $analysis): bool
    {
        return $title !== '' && $description !== '' && $analysis !== '';
    }

    private function resolveModel(): string
    {
        return AIConfigData::make()->chat_model;
    }

    private function resolveTemperature(): float
    {
        return AIConfigData::make()->chat_temperature;
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
        $templates = app(GetPredictionFallbackTemplatesAction::class)->execute();
        $caster = app(ScalarCasterAction::class);
        $drafts = [];
        $usedTitles = [];

        for ($index = 0; $index < $count; $index++) {
            $template = $templates[$index % count($templates)];
            $title = $this->uniqueFallbackTitle($caster->execute($template['title'] ?? ''), $usedTitles);
            $usedTitles[] = $title;

            $drafts[] = [
                'title' => $title,
                'subtitle' => $caster->execute($template['subtitle'] ?? '').' ('.($index + 1).')',
                'description' => $caster->execute($template['description'] ?? ''),
                'category' => $caster->execute($template['category'] ?? ''),
                'tags' => $caster->stringList($template['tags'] ?? []),
                'analysis' => $caster->execute($template['analysis'] ?? ''),
                'event_end_date' => now()->addDays(20 + ($index * 11))->toDateString(),
                'liquidity' => 5000 + ($index * 750),
                'options' => $caster->stringList($template['options'] ?? []),
            ];
        }

        return $drafts;
    }

    /**
     * @param  list<string>  $usedTitles
     */
    private function uniqueFallbackTitle(string $baseTitle, array $usedTitles): string
    {
        $title = $baseTitle;
        $suffix = 1;

        while (in_array($title, $usedTitles, true)) {
            $trimmedBaseTitle = $this->replaceRegex('/\?$/', '', $baseTitle);
            $title = $trimmedBaseTitle.' - Variante '.$suffix.'?';
            $suffix++;
        }

        return $title;
    }

    private function replaceRegex(string $pattern, string $replacement, string $subject): string
    {
        $result = preg_replace($pattern, $replacement, $subject);

        return is_string($result) ? $result : $subject;
    }
}
