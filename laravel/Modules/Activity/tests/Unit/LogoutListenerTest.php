<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LogoutListenerTest extends TestCase
{
    #[Test]
    public function listener_class_exists(): void
    {
        $this->assertTrue(class_exists(LogoutListener::class));
    }

    #[Test]
    public function listener_has_handle_method(): void
    {
        $listener = new LogoutListener;
        $this->assertTrue(method_exists($listener, 'handle'));
    }
}
