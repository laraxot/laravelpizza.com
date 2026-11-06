<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToCsv;

/**
 * Fixture minima: rende SushiToCsv visibile a PHPStan nel perimetro modulo Tenant.
 * Consumer reale: Sigma\WebService.
 */
final class TenantSushiCsvFixture extends Model
{
    use SushiToCsv;

    protected $table = 'tenant_sushi_csv_fixture';
}
