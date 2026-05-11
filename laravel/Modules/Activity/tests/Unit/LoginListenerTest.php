<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoginListenerTest extends TestCase
{
    #[Test]
    public function listener_class_exists(): void
    {
        $this->assertTrue(class_exists(LoginListener::class));
    }

    #[Test]
    public function listener_has_handle_method(): void
    {
        $listener = new LoginListener;
        $this->assertTrue(method_exists($listener, 'handle'));
    }
}
