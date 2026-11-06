<?php

declare(strict_types=1);

namespace Modules\User\Tests\Traits;

use Modules\User\Models\User;

/**
 * Type-safe $user property for Pest / PHPUnit test cases.
 */
trait HasUserTestCase
{
    protected User $user;
}
