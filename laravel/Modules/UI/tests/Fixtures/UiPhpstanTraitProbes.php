<?php

declare(strict_types=1);

namespace Tests\Modules\UI\Fixtures;

use Modules\UI\Tests\Support\EnsuresUiDatabaseSchema;
use Modules\UI\Tests\TestCase;

/** PHPStan host for EnsuresUiDatabaseSchema. */
final class EnsuresUiDatabaseSchemaProbe extends TestCase
{
    use EnsuresUiDatabaseSchema;
}
