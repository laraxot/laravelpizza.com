<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Tenant\Models\Tenant;

trait TenantSubscriptionRelations
{
    /** @return BelongsTo<Tenant, $this> */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
