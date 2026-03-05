<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Providers\Filament;

use Modules\Meetup\Providers\Filament\AdminPanelProvider;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it can instantiate admin panel provider', function () {
    $provider = new AdminPanelProvider(app());
    expect($provider)->toBeInstanceOf(AdminPanelProvider::class);
});

test('it has correct module name', function () {
    $provider = new AdminPanelProvider(app());
    $reflection = new \ReflectionClass($provider);
    $property = $reflection->getProperty('module');
    $property->setAccessible(true);
    
    expect($property->getValue($provider))->toBe('Meetup');
});
