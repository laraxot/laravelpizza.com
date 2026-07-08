<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Fixtures\Traits;

use Modules\Tenant\Models\BaseModel;

/**
 * @property int|string|null                 $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null                        $created_by
 * @property int|null                        $updated_by
 */
abstract class TenantPhpstanProbeModel extends BaseModel
{
    protected $table = 'tenant_phpstan_trait_probes';
}
