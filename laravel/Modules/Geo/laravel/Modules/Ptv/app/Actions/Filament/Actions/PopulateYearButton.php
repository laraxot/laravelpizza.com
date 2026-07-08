<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Filament\Actions;

use Filament\Actions\Action;
use Modules\Ptv\Actions\PopulateByYearAction;
use Spatie\QueueableAction\QueueableAction;

class PopulateYearButton
{
    use QueueableAction;

    public function execute(string $modelClass, string $fieldName, ?string $year): Action
    {
        return Action::make('populate_year')
            ->label('')
            ->tooltip('popola anno')
            ->icon('heroicon-o-shield-exclamation')
            ->visible($year != null)
            ->action(fn () => app(PopulateByYearAction::class)->execute($modelClass, $fieldName, (int) $year));
    }
}
