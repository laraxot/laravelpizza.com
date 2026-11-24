<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\App;

use App\Providers\AppServiceProvider;
use Modules\Meetup\Tests\TestCase as MeetupTestCase;

uses(MeetupTestCase::class);

// Solo AppServiceProvider e' registrato in bootstrap/providers.php: Folio e Volt
// sono montati dal solo owner Modules\Cms\Providers\FolioVoltServiceProvider
// (vedi Modules/Cms/tests/Unit/Providers/FolioVoltSoleOwnerTest.php).

test('app service provider can be instantiated', function (): void {
    $provider = new AppServiceProvider(app());
    expect($provider)->toBeInstanceOf(AppServiceProvider::class);
});

test('app service provider register method does not throw', function (): void {
    $provider = new AppServiceProvider(app());
    $provider->register();
    expect(true)->toBeTrue();
});

test('app service provider boot method does not throw', function (): void {
    $provider = new AppServiceProvider(app());
    $provider->boot();
    expect(true)->toBeTrue();
});
