<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationLogResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Notify\Filament\Resources\NotificationLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditNotificationLog extends XotBaseEditRecord
{
    protected static string $resource = NotificationLogResource::class;
    
    /**
     * {@inheritdoc}
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
