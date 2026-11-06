<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToPhpArray;

/**
 * Fixture minima: rende il trait SushiToPhpArray visibile a PHPStan nel perimetro
 * del modulo Tenant. Consumer reale: User\SocialProvider.
 *
 * Un file per classe: stava insieme a TenantSushiCsvFixture dentro
 * TenantSushiTraitsFixture.php, un nome che non corrispondeva a nessuna delle due,
 * e composer lo segnalava come non conforme a PSR-4 saltando entrambe le classi.
 */
final class TenantSushiPhpArrayFixture extends Model
{
    use SushiToPhpArray;

    protected $table = 'tenant_sushi_php_fixture';
}
