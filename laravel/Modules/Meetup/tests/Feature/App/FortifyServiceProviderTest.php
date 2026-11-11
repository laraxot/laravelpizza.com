<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\App;

use App\Providers\FortifyServiceProvider;
use Modules\Meetup\Tests\TestCase as MeetupTestCase;

uses(MeetupTestCase::class);

test('fortify service provider can be instantiated', function (): void {
    $provider = new FortifyServiceProvider(app());
    expect($provider)->toBeInstanceOf(FortifyServiceProvider::class);
});

test('fortify service provider register method does not throw', function (): void {
    $provider = new FortifyServiceProvider(app());
    $provider->register();
    expect(true)->toBeTrue();
});

test('fortify service provider boot method can be called', function (): void {
    // Skip if Fortify is not installed (package not in composer.json)
    if (! interface_exists('Laravel\Fortify\Contracts\UpdatesUserPasswords')) {
        $this->markTestSkipped('Fortify is not installed');
    }

    $provider = new FortifyServiceProvider(app());
    $provider->boot();
    expect(true)->toBeTrue();
});
