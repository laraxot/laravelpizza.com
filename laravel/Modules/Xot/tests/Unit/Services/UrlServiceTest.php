<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Services;

use Modules\Xot\Services\UrlService;


it('can be instantiated', function (): void {
    $service = new UrlService();
    expect($service)->toBeInstanceOf(UrlService::class);
});

it('can get instance via getInstance', function (): void {
    $service = UrlService::getInstance();
    expect($service)->toBeInstanceOf(UrlService::class);
});

it('can get instance via make', function (): void {
    $service = UrlService::make();
    expect($service)->toBeInstanceOf(UrlService::class);
});

it('validates correct urls', function (): void {
    $service = UrlService::make();
    expect($service->checkValidUrl('https://google.com'))->toBeTrue()
        ->and($service->checkValidUrl('http://localhost'))->toBeTrue()
        ->and($service->checkValidUrl('ftp://server.com'))->toBeTrue();
});

it('invalidates incorrect urls', function (): void {
    $service = UrlService::make();
    expect($service->checkValidUrl('not-a-url'))->toBeFalse()
        ->and($service->checkValidUrl('http:///double-slash'))->toBeFalse()
        ->and($service->checkValidUrl(''))->toBeFalse();
});
