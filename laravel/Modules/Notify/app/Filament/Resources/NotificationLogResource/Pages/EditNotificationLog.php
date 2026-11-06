<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationLogResource\Pages;

use Modules\Notify\Filament\Resources\NotificationLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditNotificationLog extends XotBaseEditRecord
{
    protected static string $resource = NotificationLogResource::class;
}
