<?php

declare(strict_types=1);

use Modules\Geo\Services\HereService;

beforeEach(function () {
    $this->service = new HereService();
});

it('has correct base URL', function (): void {
    expect($this->service->base_url)->toBe('https://router.hereapi.com/v8/routes');
});

it('has static method for getting duration and length', function (): void {
    // Check that the method exists
    expect(method_exists(HereService::class, 'getDurationAndLength'))->toBeTrue();
});
