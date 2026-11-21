<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Assistant;

use Spatie\QueueableAction\QueueableAction;

/**
 * Guardrail deterministico, prima di chiamare il modello: se la domanda tocca un argomento
 * che deve gestire una persona (rimborsi, reclami, questioni legali o mediche...) restituisce
 * la parola che l'ha fatto scattare, altrimenti null.
 *
 * Le parole arrivano dal chiamante (es. per singola attivita'); se null si usa
 * `config('ai.assistant.handoff_keywords')`.
 */
final class DetectHandoffTriggerAction
{
    use QueueableAction;

    public function __construct(private readonly TokenizeTextAction $tokenize) {}

    /** @param  list<string>|null  $keywords  null = parole della config */
    public function execute(string $question, ?array $keywords = null): ?string
    {
        $tokens = $this->tokenize->execute($question);

        foreach ($this->normalize($keywords ?? $this->configuredKeywords()) as $keyword) {
            foreach ($tokens as $token) {
                if (str_starts_with($token, $keyword)) {
                    return $keyword;
                }
            }
        }

        return null;
    }

    /** @return array<mixed> */
    private function configuredKeywords(): array
    {
        $configured = config('ai.assistant.handoff_keywords', []);

        return is_array($configured) ? $configured : [];
    }

    /**
     * @param  array<mixed>  $keywords
     * @return list<string> radici normalizzate (es. "rimbors" copre rimborso/rimborsi)
     */
    private function normalize(array $keywords): array
    {
        $normalized = [];
        foreach ($keywords as $keyword) {
            if (is_string($keyword)) {
                $normalized = [...$normalized, ...$this->tokenize->execute($keyword)];
            }
        }

        return $normalized;
    }
}
