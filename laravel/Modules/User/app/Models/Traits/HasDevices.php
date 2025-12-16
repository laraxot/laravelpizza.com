<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Models\Device;

trait HasDevices
{
    public function devices(): BelongsToMany
    {
        return $this->belongsToManyX(Device::class);
    }
}
