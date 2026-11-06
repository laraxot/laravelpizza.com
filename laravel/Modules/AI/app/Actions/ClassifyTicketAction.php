<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Illuminate\Support\Facades\Cache;
use Modules\AI\Actions\Prompt\BuildAIPromptAction;
use Modules\AI\Actions\MakeAIRequestAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Classificazione automatica di un ticket (azione queueable).
 *
 * Sostituisce `AIService::classifyTicket()` mantenendo invariata la logica di business:
 * - cache `ai:classification:<md5(title+description)>` con TTL 3600 secondi;
 * - prompt di classificazione (template `classification`);
 * - richiesta all'API AI con retry (see `MakeAIRequestAction`);
 * - decodifica difensiva della risposta JSON con fallback sui valori di default.
 *
 * Essendo un'azione queueable puo' essere eseguita in modo sincrono
 * (`app(ClassifyTicketAction::class)->execute($title, $description)`) oppure
 * dispatchata su coda (`ClassifyTicketAction::dispatch($title, $description)`).
 */
final class ClassifyTicketAction
{
    use QueueableAction;

    /**
     * TTL (secondi) della cache della classificazione.
     */
    private const int CACHE_TTL = 3600;

    /**
     * Valori di default usati quando il modello non risponde in JSON valido.
     *
     * @return array<string, mixed>
     */
    private const array DEFAULTS = [
        'category' => 'altro',
        'subcategory' => 'generale',
        'confidence' => 0.5,
        'tags' => [],
        'urgency_indicators' => [],
    ];

    /**
     * Classifica il ticket e restituisce i dati strutturati.
     *
     * @return array<string, mixed>
     */
    public function execute(string $title, string $description): array
    {
        $cacheKey = 'ai:classification:'.md5($title.$description);

        $result = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($title, $description): string {
            $prompt = app(BuildAIPromptAction::class)->execute('classification', [
                'title' => $title,
                'description' => $description,
            ]);

            return app(MakeAIRequestAction::class)->execute($prompt, 'classification', [
                'title' => $title,
                'description' => $description,
            ]);
        });

        if (! is_string($result)) {
            return self::DEFAULTS;
        }

        $decoded = AiJsonResponseDecoderAction::decodeObject($result);

        return $decoded === [] ? self::DEFAULTS : $decoded;
    }
}
