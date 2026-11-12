<?php

declare(strict_types=1);

namespace Modules\Meetup\Datas;

use Spatie\LaravelData\Data;

/**
 * Dati del profilo che il partecipante modifica da /{lingua}/profile/edit.
 * L'email non c'è: cambiarla richiede una nuova verifica e passa dall'assistenza.
 */
final class OwnProfileData extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public ?string $bio = null,
        public ?string $locale = null,
    ) {}
}
