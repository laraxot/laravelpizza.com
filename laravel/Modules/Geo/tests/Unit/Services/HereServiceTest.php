<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\HereService;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('has correct base URL', function (): void {
    $service = new HereService();
    Assert::assertSame('https://router.hereapi.com/v8/routes', $service->base_url);
});

it('has static method for getting duration and length', function (): void {
    Assert::assertContains('getDurationAndLength', get_class_methods(HereService::class));
});
