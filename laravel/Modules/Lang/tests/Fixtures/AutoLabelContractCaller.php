<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Filament\Forms\Components\Field;
use Modules\Lang\Actions\Filament\AutoLabelAction;
use Webmozart\Assert\Assert;

/**
 * Classe chiamante per i test del contratto di AutoLabelAction.
 *
 * AutoLabelAction salta i primi due frame del backtrace e prende la prima classe `Modules\` concreta come proprietaria
 * della chiave di traduzione: qui `apply()` e' quel frame, come lo e' la Resource Filament in produzione.
 */
final class AutoLabelContractCaller
{
    public function apply(Field $field, string $type = 'label'): Field
    {
        return $this->run($field, $type);
    }

    private function run(Field $field, string $type): Field
    {
        $result = app(AutoLabelAction::class)->execute($field, $type);
        Assert::isInstanceOf($result, Field::class);

        return $result;
    }
}
