<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Modules\Notify\Models\NotificationLog;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource per la consultazione dei log di invio delle notifiche
 * (email, sms, whatsapp): stato di consegna, apertura, click, errori.
 */
class NotificationLogResource extends XotBaseResource
{
    protected static ?string $model = NotificationLog::class;
}
