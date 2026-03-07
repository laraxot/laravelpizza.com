<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament\Actions;

use Filament\Actions\Action;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action for copying views in Filament.
 */
class ViewCopyAction extends XotBaseAction
{
    use QueueableAction;

    /**
     * Create a new instance of the action.
     */
    public static function make(?string $name = null): static
    {
        $action = parent::make($name ?? 'view_copy');

        return $action
            ->label('Copy View')
            ->icon('heroicon-o-document-duplicate')
            ->requiresConfirmation()
            ->modalHeading('Copy View')
            ->modalDescription('Are you sure you want to copy this view?')
            ->action(function (array $arguments, array $data): void {
                // Implementation for copying view logic
                $this->execute($arguments, $data);
            });
    }

    /**
     * Execute the copy view action.
     */
    public function execute(array $arguments, array $data): void
    {
        // TODO: Implement view copying logic
        // This should copy the view file and any related assets
    }
}
