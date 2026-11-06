<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\User\Models\Device;

trait HasDevices
{
    /**
     * @return BelongsToMany<Device, $this, Pivot>
     */
    public function devices(): BelongsToMany
    {
        return $this->belongsToManyX(Device::class);
    }
}
