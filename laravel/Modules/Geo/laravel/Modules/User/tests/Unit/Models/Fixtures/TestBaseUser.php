<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models\Fixtures;

use Modules\User\Models\BaseUser;

/**
 * Concrete BaseUser stub for unit tests (PHPStan-safe, no anonymous classes).
 */
class TestBaseUser extends BaseUser
{
    protected $table = 'test_users';
}
