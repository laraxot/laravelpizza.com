<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Gdpr\Providers\EventServiceProvider;
use Modules\Gdpr\Tests\TestCase;
=======
use Modules\Gdpr\Providers\EventServiceProvider;
use Modules\Gdpr\Tests\TestCase;
use Modules\Xot\Providers\XotBaseEventServiceProvider;
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

uses(TestCase::class);

test('event_service_provider_extends_xot_base_event_service_provider', function (): void {
    $provider = new EventServiceProvider(app());

    Assert::assertInstanceOf(XotBaseEventServiceProvider::class, $provider);
});
