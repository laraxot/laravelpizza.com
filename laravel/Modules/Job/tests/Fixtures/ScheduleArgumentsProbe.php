<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Fixtures;

use Modules\Job\Filament\Columns\ScheduleArguments;

/**
 * Sonda per `ScheduleArguments`.
 *
 * `getTags()` legge lo stato con `getState()`, che fuori da una tabella Filament risolve dal
 * record e qui varrebbe sempre `null`: senza controllarlo si testerebbe un solo ramo su cinque.
 * La sottoclasse espone lo stato come proprieta e lascia intatta tutta la logica sotto esame -
 * `formatArrayTags()` e `filterEmptyTags()` restano quelle di produzione.
 *
 * E una sottoclasse **nominata** di proposito: il nome di una classe anonima contiene un byte
 * NUL, e il codice Xot che ne deriva il path di un file di lingua muore con
 * `ValueError: must not contain any null bytes`.
 */
final class ScheduleArgumentsProbe extends ScheduleArguments
{
    /**
     * @var array<int|string, mixed>|string|null
     */
    public array|string|null $fakeState = null;

    /**
     * @return array<int|string, mixed>|string|null
     */
    public function getState(): array|string|null
    {
        return $this->fakeState;
    }
}
