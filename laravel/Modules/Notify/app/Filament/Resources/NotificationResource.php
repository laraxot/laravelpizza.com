<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Modules\Notify\Models\Notification;
use Modules\Xot\Filament\Resources\XotBaseResource;

class NotificationResource extends XotBaseResource
{
    protected static ?string $model = Notification::class;
}
