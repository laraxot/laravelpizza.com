<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Modules\User\Models\SocialProvider;

/**
 * Fixture di coverage: stesso trait dell'host reale `SocialProvider`, in memoria.
 */
final class SushiToPhpArrayCoverageModel extends SocialProvider
{
    protected $table = 'tenant_configs';

    protected $fillable = ['name', 'meta'];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }
}
