<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits\Fixtures;

use Illuminate\Support\ServiceProvider;
use Modules\User\Providers\Traits\HasPassportConfiguration;

/** PHPStan fixture: keeps HasPassportConfiguration trait in analysed graph. */
final class HasPassportConfigurationFixture extends ServiceProvider
{
    use HasPassportConfiguration;
}
