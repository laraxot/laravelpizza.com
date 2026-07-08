<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Filament\Actions;

use Filament\Actions\Action;
use Modules\Ptv\Actions\TrovaEsclusiByYearAction;
use Spatie\QueueableAction\QueueableAction;

class TrovaEsclusiButton
{
    use QueueableAction;

    public function execute(string $modelClass, string $fieldName, ?string $year): Action
    {
        return Action::make('trova_esclusi')
            ->label('')
            ->tooltip('trova esclusi')
            ->icon('fas-skull-crossbones')
            ->visible($year != null)
            ->action(fn () => app(TrovaEsclusiByYearAction::class)->execute($modelClass, $fieldName, (int) $year));
    }
}
