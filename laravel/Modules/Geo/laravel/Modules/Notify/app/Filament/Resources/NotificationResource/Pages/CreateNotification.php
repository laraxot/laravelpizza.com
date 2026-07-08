<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationResource\Pages;

use Modules\Notify\Filament\Resources\NotificationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateNotification extends XotBaseCreateRecord
{
    protected static string $resource = NotificationResource::class;
}
