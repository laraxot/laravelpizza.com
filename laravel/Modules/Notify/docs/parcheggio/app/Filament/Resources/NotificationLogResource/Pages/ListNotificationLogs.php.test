<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationLogResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Notify\Filament\Resources\NotificationLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListNotificationLogs extends XotBaseListRecords
{
    protected static string $resource = NotificationLogResource::class;

    /**
     * {@inheritdoc}
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Crea Notifica'),
        ];
    }
}
