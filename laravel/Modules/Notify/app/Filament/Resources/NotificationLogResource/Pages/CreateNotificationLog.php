<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationLogResource\Pages;

use Modules\Notify\Filament\Resources\NotificationLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateNotificationLog extends XotBaseCreateRecord
{
    protected static string $resource = NotificationLogResource::class;
}
