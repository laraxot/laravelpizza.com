<?php

declare(strict_types=1);

namespace Modules\User\Actions\Filament;

use Filament\Schemas\Components\Component;
use Spatie\QueueableAction\QueueableAction;

/**
 * Normalizza lo schema form restituito da `getFormSchemaWidget()` della resource utente.
 *
 * Lo schema arriva da una resource scelta a runtime (per tipo utente), quindi non e' tipizzato:
 * se anche un solo elemento non e' un `Component` Filament lo schema e' considerato non valido
 * e si restituisce un array vuoto (il widget mostra un form vuoto invece di andare in errore).
 * Le chiavi sono conservate perche' Filament le usa come nomi dei componenti.
 *
 * Usata da `EditUserWidget` e `RegistrationWidget` (prima avevano ciascuno una copia identica).
 */
class NormalizeFormSchemaAction
{
    use QueueableAction;

    /**
     * @param  array<int|string, mixed>  $schema
     * @return array<int|string, Component>
     */
    public function execute(array $schema): array
    {
        $normalized = [];
        foreach ($schema as $key => $component) {
            if (! $component instanceof Component) {
                return [];
            }

            $normalized[$key] = $component;
        }

        return $normalized;
    }
}
