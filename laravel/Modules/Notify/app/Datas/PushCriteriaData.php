<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

/**
 * Criteri di targeting per la selezione dei device token nell'invio push
 * (`Modules\Notify\Actions\Push\SendPushWithTargetingAction`).
 *
 * Nota: `getTokensByCriteria()` è al momento uno stub (ritorna sempre `[]`);
 * questi campi rappresentano le dimensioni di targeting più comuni
 * (utente, piattaforma, tag, segmento) e vanno estesi quando la query reale
 * verrà implementata.
 */
final class PushCriteriaData extends Data
{
    /**
     * @param  list<int>|null  $userIds
     * @param  list<string>|null  $tags
     */
    public function __construct(
        public ?array $userIds = null,
        public ?string $platform = null,
        public ?array $tags = null,
        public ?string $segment = null,
    ) {}
}
