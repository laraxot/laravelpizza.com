<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits\Fixtures;

use Modules\User\Models\Traits\HasPasswordExpiry;
use Modules\User\Models\User;

/** PHPStan fixture: keeps HasPasswordExpiry trait in analysed graph. */
final class HasPasswordExpiryFixture extends User
{
    use HasPasswordExpiry;
}
