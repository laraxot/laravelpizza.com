<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Illuminate\Support\Facades\Cache;
use Modules\AI\Actions\Prompt\BuildAIPromptAction;
use Modules\AI\Actions\MakeAIRequestAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Suggerimento delle soluzioni per un ticket (azione queueable).
 *
 * Sostituisce `AIService::suggestSolutions()` mantenendo invariata la logica di business:
 * - cache `ai:solutions:<md5(title+description+category)>` con TTL 1800 secondi;
 * - prompt di soluzione (template `solutions`);
 * - richiesta all'API AI con retry (see `MakeAIRequestAction`);
 * - decodifica difensiva della risposta JSON con fallback sui valori di default.
 *
 * Essendo un'azione queueable puo' essere eseguita in modo sincrono
 * (`app(SuggestSolutionsAction::class)->execute($title, $description, $category)`)
 * oppure dispatchata su coda (`SuggestSolutionsAction::dispatch($title, $description, $category)`).
 */
final class SuggestSolutionsAction
{
    use QueueableAction;

    /**
     * TTL (secondi) della cache dei suggerimenti.
     */
    private const int CACHE_TTL = 1800;

    /**
     * Valori di default usati quando il modello non risponde in JSON valido.
     *
     * @return array<string, mixed>
     */
    private const array DEFAULTS = [
        'solutions' => [],
        'preventive_measures' => [],
        'follow_up_actions' => [],
    ];

    /**
     * Suggerisce le soluzioni per il ticket e restituisce i dati strutturati.
     *
     * @return array<string, mixed>
     */
    public function execute(string $title, string $description, string $category): array
    {
        $cacheKey = 'ai:solutions:'.md5($title.$description.$category);

        $result = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($title, $description, $category): string {
            $prompt = app(BuildAIPromptAction::class)->execute('solutions', [
                'title' => $title,
                'description' => $description,
                'category' => $category,
            ]);

            return app(MakeAIRequestAction::class)->execute($prompt, 'solutions', [
                'title' => $title,
                'description' => $description,
                'category' => $category,
            ]);
        });

        if (! is_string($result)) {
            return self::DEFAULTS;
        }

        $decoded = AiJsonResponseDecoderAction::decodeObject($result);

        return $decoded === [] ? self::DEFAULTS : $decoded;
    }
}
