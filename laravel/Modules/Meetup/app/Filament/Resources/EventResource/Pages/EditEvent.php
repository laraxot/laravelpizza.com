<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Pages;

use Filament\Actions;
use Modules\Meetup\Filament\Resources\EventResource as EventResourceClass;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditEvent extends XotBaseEditRecord
{
    protected static string $resource = EventResourceClass::class;

    /**
     * Get the header actions.
     *
     * @return array<string, \Filament\Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => Actions\DeleteAction::make(),
        ];
    }
}
