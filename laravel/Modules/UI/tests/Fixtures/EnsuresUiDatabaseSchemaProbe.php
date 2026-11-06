<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Fixtures;

use Modules\UI\Tests\Support\EnsuresUiDatabaseSchema;
use Modules\UI\Tests\TestCase;

/** PHPStan host for EnsuresUiDatabaseSchema. */
final class EnsuresUiDatabaseSchemaProbe extends TestCase
{
    use EnsuresUiDatabaseSchema;
}
