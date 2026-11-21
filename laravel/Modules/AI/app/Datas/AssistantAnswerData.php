<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Modules\AI\Actions\AiJsonResponseDecoderAction;
use Spatie\LaravelData\Data;

/**
 * Risposta dell'assistente a una domanda del cliente.
 *
 * `needsHuman` = true significa: non rispondere in automatico, passa a una persona
 * (`handoffReason` spiega perche'). In quel caso `answer` e' il messaggio di cortesia.
 */
class AssistantAnswerData extends Data
{
    /** @param  list<int>  $sourceIds */
    public function __construct(
        public string $answer,
        public bool $needsHuman,
        public ?string $handoffReason = null,
        public array $sourceIds = [],
    ) {}

    public static function handoff(string $reason): self
    {
        return new self(
            answer: \trans_string('ai::assistant.handoff_message'),
            needsHuman: true,
            handoffReason: $reason,
        );
    }

    /**
     * Decodifica difensiva della risposta JSON del modello: tutto cio' che non e' una
     * risposta chiara e fondata sulle fonti diventa un passaggio a una persona.
     *
     * @param  list<int>  $allowedSourceIds  id delle fonti effettivamente passate al modello
     */
    public static function fromModelResponse(string $raw, array $allowedSourceIds): self
    {
        $decoded = AiJsonResponseDecoderAction::decodeObject($raw);
        $answer = $decoded['answer'] ?? null;

        if (! is_string($answer) || trim($answer) === '') {
            return self::handoff('invalid_model_response');
        }

        if (($decoded['handoff'] ?? false) === true) {
            $reason = $decoded['reason'] ?? null;

            return self::handoff(is_string($reason) && $reason !== '' ? $reason : 'model_requested');
        }

        $sourceIds = is_array($decoded['source_ids'] ?? null) ? $decoded['source_ids'] : [];
        $sourceIds = array_values(array_intersect(
            $allowedSourceIds,
            array_map(static fn (mixed $id): int => is_numeric($id) ? (int) $id : 0, $sourceIds),
        ));

        return new self(answer: trim($answer), needsHuman: false, sourceIds: $sourceIds);
    }
}
