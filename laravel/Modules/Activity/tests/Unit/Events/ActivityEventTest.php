<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Activity\Events\ActivityEvent;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ActivityEventTest extends TestCase
{
    #[Test]
    public function event_class_exists(): void
    {
        // @var mixed assertTrue(class_exists(ActivityEvent::class;
    }

    #[Test]
    public function event_uses_dispatchable_trait(): void
    {
        // @var mixed assertContains(Dispatchable::class, class_uses_recursive(ActivityEvent::class;
    }

    #[Test]
    public function event_uses_interacts_with_sockets_trait(): void
    {
        // @var mixed assertContains(InteractsWithSockets::class, class_uses_recursive(ActivityEvent::class;
    }

    #[Test]
    public function event_uses_serializes_models_trait(): void
    {
        // @var mixed assertContains(SerializesModels::class, class_uses_recursive(ActivityEvent::class;
    }

    #[Test]
    public function event_can_be_instantiated(): void
    {
        $event = new ActivityEvent;
        // @var mixed assertInstanceOf(ActivityEvent::class, $event;
    }
}
