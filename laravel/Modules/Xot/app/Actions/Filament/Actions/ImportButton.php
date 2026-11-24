<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament\Actions;

use Filament\Actions\Action;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/import-button.md
<<<<<<< .merge_file_6oOVpD
 *
=======
>>>>>>> .merge_file_rr55cm
 * @contract docs/contracts/import-button.md
 */
class ImportButton
{
    use QueueableAction;

    public function execute(): Action
    {
        return Action::make('import')
            ->tooltip('import XLS')
            ->icon('heroicon-o-arrow-up-on-square')
            // ->visible(null != $year)
            ->action(static fn (): never => throw new \LogicException('ImportButton action not implemented'));
    }
}
