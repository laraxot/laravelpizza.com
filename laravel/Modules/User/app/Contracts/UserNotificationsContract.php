<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\User\Models\Notification;

/**
 * Contract for users backed by Laravel's database notification channels.
 *
 * The capability is deliberately separate from UserContract: not every
 * contract implementation is required to persist notifications.
 *
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
interface UserNotificationsContract extends UserContract
{
    /**
     * @return MorphMany<Notification, covariant Model>
     */
    public function notifications(): MorphMany;

    /**
     * @return MorphMany<Notification, covariant Model>
     */
    public function unreadNotifications(): MorphMany;
}
