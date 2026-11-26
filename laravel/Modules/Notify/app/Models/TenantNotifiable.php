<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Traits\HasTenantNotifications;

/**
 * Host di dominio per notifiche tenant-aware (log morph + scope tenant).
 * Non e' un probe PHPStan: modello concreto usato dai flussi Notify multi-tenant.
 *
 * @see Modules/Notify/docs/contracts/index.md
 */
class TenantNotifiable extends Model
{
    use HasTenantNotifications;

    /** @var list<string> */
    protected $fillable = [
        'tenant_id',
    ];
}
