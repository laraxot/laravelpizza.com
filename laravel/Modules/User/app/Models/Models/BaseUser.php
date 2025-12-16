<?php

declare(strict_types=1);

namespace Modules\User\Models\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;

abstract class BaseUser extends Authenticatable
{
    use Notifiable;

    /**
     * Get the entity's notifications.
     *
     * @return MorphMany<DatabaseNotification, $this>
     */
    public function notifications(): MorphMany
    {
        /** @var class-string<DatabaseNotification> $notificationClass */
        $notificationClass = config('notifications.notification_model', DatabaseNotification::class);

        return $this->morphMany($notificationClass, 'notifiable');
    }
}
