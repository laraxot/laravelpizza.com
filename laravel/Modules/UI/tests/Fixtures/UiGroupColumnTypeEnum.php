<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Fixtures;

use Filament\Support\Contracts\HasLabel;

/**
 * Backed enum con HasLabel per GroupColumnTest.
 *
 * Sostituisce il riferimento a `Modules\Ptv\Enums\WorkerType`, importato da un
 * altro progetto e inesistente in questo repository. Il test verifica solo che
 * la vista di GroupColumn chiami getLabel() invece di stampare il raw value,
 * quindi il dominio dell'enum e' irrilevante: conta solo che sia un BackedEnum
 * con HasLabel e che label e raw value differiscano.
 */
enum UiGroupColumnTypeEnum: string implements HasLabel
{
    case Dip = 'dip';
    case Collaboratore = 'collaboratore';

    public function getLabel(): string
    {
        return match ($this) {
            self::Dip => 'Dipendente',
            self::Collaboratore => 'Collaboratore',
        };
    }
}
