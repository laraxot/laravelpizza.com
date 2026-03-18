<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament\Actions;

use Modules\Xot\Actions\ModelClass\CopyFromLastYearAction as ModelCopyAction;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action for copying data from the previous year in Filament.
 */
class CopyFromLastYearAction extends XotBaseAction
{
    use QueueableAction;

    /**
     * Create a new instance of the action.
     */
    public static function make(?string $name = null): static
    {
        $action = parent::make($name ?? 'copy_from_last_year');

        return $action
            ->label('Copy from Last Year')
            ->icon('heroicon-o-arrow-path')
            ->requiresConfirmation()
            ->modalHeading('Copy Data from Last Year')
            ->modalDescription('Are you sure you want to copy data from the previous year?')
            ->action(function (array $arguments, array $data) use ($action): void {
                $action->execute($arguments, $data);
            });
    }

    public function execute(array $arguments, array $data): void
    {
        $modelClass = $arguments['model_class'] ?? null;
        $fieldName = $arguments['field_name'] ?? null;
        $year = $arguments['year'] ?? null;

        if (! is_string($modelClass) || ! is_string($fieldName)) {
            return;
        }

        if (! is_string($year) && null !== $year) {
            return;
        }

        app(ModelCopyAction::class)->execute($modelClass, $fieldName, $year);
    }
}
