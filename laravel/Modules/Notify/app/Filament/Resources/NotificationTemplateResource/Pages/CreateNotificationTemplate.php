<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;

use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateNotificationTemplate extends XotBaseCreateRecord
{
    protected static string $resource = NotificationTemplateResource::class;
}
