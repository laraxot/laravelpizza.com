<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Listeners\LogoutListener;
<<<<<<< HEAD
use Modules\Activity\Tests\TestCase;
=======
use PHPUnit\Framework\TestCase;
>>>>>>> a21dc33d (.)
use PHPUnit\Framework\Attributes\Test;

class LogoutListenerTest extends TestCase
{
<<<<<<< HEAD
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
=======
>>>>>>> a21dc33d (.)

    #[Test]
    public function listener_class_exists(): void
    {
        $this->assertTrue(class_exists(LogoutListener::class));
    }

    #[Test]
    public function listener_has_handle_method(): void
    {
        $listener = new LogoutListener();
        $this->assertTrue(method_exists($listener, 'handle'));
    }
}
