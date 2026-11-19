<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Assistant;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_split;

/**
 * Riduce un testo a parole confrontabili: minuscolo, senza accenti, solo lettere/cifre,
 * almeno 3 caratteri ("Rimborsò!" -> "rimborso"). Base comune di ricerca e guardrail.
 */
final class TokenizeTextAction
{
    use QueueableAction;

    private const int MIN_LENGTH = 3;

    /** @return list<string> */
    public function execute(string $text): array
    {
        $normalized = Str::lower(Str::ascii($text));
        $tokens = [];
        foreach (preg_split('/[^a-z0-9]+/', $normalized) as $word) {
            if (is_string($word) && strlen($word) >= self::MIN_LENGTH) {
                $tokens[] = $word;
            }
        }

        return array_values(array_unique($tokens));
    }
}
