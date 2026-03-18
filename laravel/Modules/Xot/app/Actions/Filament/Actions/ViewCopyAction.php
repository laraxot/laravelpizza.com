<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament\Actions;

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
        $actionClass = static::class;

        return $action
            ->label('Copy View')
            ->icon('heroicon-o-document-duplicate')
            ->requiresConfirmation()
            ->modalHeading('Copy View')
            ->modalDescription('Are you sure you want to copy this view?')
            ->action(static function (array $arguments, array $data) use ($actionClass): void {
                /** @var self $service */
                $service = app($actionClass);
                $service->execute($arguments, $data);
            });
    }

    public function execute(array $arguments, array $data): void
    {
        // TODO: Implement view copying logic
        // This should copy the view file and any related assets
    }
}
