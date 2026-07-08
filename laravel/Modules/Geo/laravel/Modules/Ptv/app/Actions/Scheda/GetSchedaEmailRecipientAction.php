<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Determina destinatario email per scheda valutazione.
 *
 * Business Logic (priorità):
 * 1. scheda->email (se presente e valida)
 * 2. scheda->anag->email (fallback anagrafica)
 * 3. config('ptv.email.fallback_recipient') (fallback sistema)
 *
 * @see \Modules\Ptv\docs\sendmail-refactoring-brutal-analysis.md
 */
class GetSchedaEmailRecipientAction
{
    use QueueableAction;

    /**
     * Determina email destinatario.
     *
     * @param  SchedaContract  $scheda  Record scheda
     * @return string Email destinatario valida
     */
    public function execute(SchedaContract $scheda): string
    {
        // Priorità 1: Email diretta in scheda
        if (isset($scheda->email) && is_string($scheda->email)) {
            $email = trim($scheda->email);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            }
        }

        // Priorità 2: Email da anagrafica (se relazione esiste)
        if (method_exists($scheda, 'anag')) {
            // Carica relazione se non già caricata
            if (! $scheda->relationLoaded('anag')) {
                $scheda->load('anag');
            }

            // Estrai email da anagrafica
            /** @var mixed $anag */
            $anag = $scheda->getAttribute('anag');
            if (is_object($anag) && isset($anag->email) && is_string($anag->email)) {
                $email = trim($anag->email);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return $email;
                }
            }
        }

        // Priorità 3: Fallback da configurazione
        $fallback = config('ptv.email.fallback_recipient');

        // Se config non configurato, usa default hardcoded
        if (! is_string($fallback) || empty($fallback)) {
            $fallback = 'marco.sottana@gmail.com';
        }

        // Valida email fallback
        Assert::email($fallback, 'Fallback recipient must be valid email');

        return $fallback;
    }
}
