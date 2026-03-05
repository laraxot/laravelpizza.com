<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Providers;

use Filament\Panel;
use Modules\Activity\Providers\Filament\AdminPanelProvider;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('admin panel provider returns a panel instance', function () {
    $provider = new AdminPanelProvider(app());

    $panel = $provider->panel(Panel::make());

    expect($panel)->toBeInstanceOf(Panel::class);
});
