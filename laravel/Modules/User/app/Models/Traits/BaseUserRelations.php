<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\Notification;
use Modules\User\Models\OauthClient;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Datas\XotData;

trait BaseUserRelations
{
    /**
     * @return HasOne<Model&ProfileContract, Model&static>
     *
     * @phpstan-return HasOne<Model&ProfileContract, Model&static>
     */
    #[\Override]
    public function profile(): HasOne
    {
        $profileClass = XotData::make()->getProfileClass();
        if (class_exists($profileClass)) {
            /** @var HasOne<Model&ProfileContract, Model&static> $relation */
            $relation = $this->hasOne($profileClass);

            return $relation;
        }

        $directClass = 'Modules\\User\\Models\\Profile';
        if (class_exists($directClass)) {
            /** @var HasOne<Model&ProfileContract, Model&static> $relation */
            $relation = $this->hasOne($directClass);

            return $relation;
        }

        /** @var HasOne<Model&ProfileContract, Model&static> $relation */
        $relation = $this->hasOne(static::class, 'id', 'id')->whereRaw('1=0');

        return $relation;
    }

    /**
     * Get the entity's notifications.
     *
     * @return MorphMany<Notification, $this>
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    /**
     * Get the entity's unread notifications.
     *
     * @return MorphMany<Notification, $this>
     */
    public function unreadNotifications(): MorphMany
    {
        return $this->notifications()->unread();
    }

    /**
     * Get the user's latest authentication log.
     *
     * @return MorphOne<AuthenticationLog, $this>
     */
    public function latestAuthentication(): MorphOne
    {
        return $this->morphOne(AuthenticationLog::class, 'authenticatable')->latestOfMany();
    }

    /**
     * @return MorphMany<OauthClient, $this>
     */
    public function clients(): MorphMany
    {
        return $this->morphMany(OauthClient::class, 'owner');
    }
}
