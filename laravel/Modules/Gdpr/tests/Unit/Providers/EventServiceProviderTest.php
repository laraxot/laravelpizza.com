<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

use Modules\Gdpr\Providers\EventServiceProvider;
use Modules\Xot\Providers\XotBaseEventServiceProvider;
use PHPUnit\Framework\Assert;

use function Safe\class_parents;

test('event_service_provider_extends_xot_base_event_service_provider', function (): void {
    Assert::assertArrayHasKey(XotBaseEventServiceProvider::class, class_parents(EventServiceProvider::class));
});
