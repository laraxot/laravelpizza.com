<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * phpstan-require-extends Model.
 */
interface CanReceivePushNotifications
{
    /**
     * @return Collection<string>
     */
    public function getMobileDeviceTokens(): Collection;

    /**
     * Get the value of the model's primary key.
     * non si puo usare mixed che cs lo cancella.
     *
     * @return string|int|null
     */
    public function getKey();
}
