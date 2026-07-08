<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

/**
 * Evento per il salvataggio dei dati di valutazione.
 */
class DatiSalvati implements ShouldBroadcast
{
    /** @var array<string, mixed> */
    public array $vecchiDati;

    /** @var array<string, mixed> */
    public array $nuoviDati;

    /**
     * @param  array<string, mixed>|null  $vecchiDati
     * @param  array<string, mixed>|null  $nuoviDati
     */
    public function __construct(
        public IndennitaResponsabilita $record,
        ?array $vecchiDati = null,
        ?array $nuoviDati = null,
    ) {
        $fields = [
            'matr',
            'cognome',
            'email',
            'responsabilita_di_spesa',
            'realizzazione_piani_programmi',
            'supporto_decisioni_dirigente',
            'note',
        ];

        $this->vecchiDati = $vecchiDati ?? $record->only($fields);
        $this->nuoviDati = $nuoviDati ?? $this->vecchiDati;
    }

    /**
     * @return array<string, mixed>
     */
    public function getVecchiDati(): array
    {
        return $this->diffChanged($this->vecchiDati, $this->nuoviDati);
    }

    /**
     * @return array<string, mixed>
     */
    public function getNuoviDati(): array
    {
        return $this->diffChanged($this->nuoviDati, $this->vecchiDati);
    }

    /**
     * @param  array<string, mixed>  $from
     * @param  array<string, mixed>  $against
     * @return array<string, mixed>
     */
    private function diffChanged(array $from, array $against): array
    {
        $changed = [];

        foreach ($from as $key => $value) {
            if (! array_key_exists($key, $against)) {
                $changed[$key] = $value;

                continue;
            }

            if ((string) $value !== (string) $against[$key]) {
                $changed[$key] = $value;
            }
        }

        return $changed;
    }

    /**
     * @return array<int, string>
     */
    public function broadcastOn(): array
    {
        return ['dati-salvati'];
    }
}
