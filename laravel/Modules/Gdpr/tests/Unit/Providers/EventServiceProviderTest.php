<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

use Modules\Gdpr\Providers\EventServiceProvider;
use Modules\Gdpr\Tests\TestCase;
use Modules\Xot\Providers\XotBaseEventServiceProvider;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('event_service_provider_extends_xot_base_event_service_provider', function (): void {
    $provider = new EventServiceProvider(app());

    Assert::assertInstanceOf(XotBaseEventServiceProvider::class, $provider);
});
