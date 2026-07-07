<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits\Fixtures;

use Modules\User\Models\User;
use Modules\User\Tests\Traits\HasUserTestCase;

final class HasUserTestCaseFixture
{
    use HasUserTestCase;

<<<<<<< HEAD
<<<<<<< HEAD
    public User $user;

=======
>>>>>>> 6d3760fe (.)
=======
    public User $user;

>>>>>>> 9fa499be (.)
    public function __construct()
    {
        $this->user = new User();
    }
}
