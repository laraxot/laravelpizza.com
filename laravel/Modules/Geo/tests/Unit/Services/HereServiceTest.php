<?php

declare(strict_types=1);

use Modules\Geo\Services\HereService;

beforeEach(function () {
    // @var mixed service = new HereService(;
});

it('has correct base URL', function (): void {
    expect(// @var mixed service->base_url;
});

it('has static method for getting duration and length', function (): void {
    // Check that the method exists
    expect(method_exists(HereService::class, 'getDurationAndLength'))->toBeTrue();
});
