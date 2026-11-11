<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Providers;

use Filament\Panel;
use Modules\Notify\Providers\Filament\AdminPanelProvider;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('admin panel provider returns a panel instance', function () {
    $provider = new AdminPanelProvider(app());
    $panel = $provider->panel(Panel::make());
    Assert::assertNotSame('', $panel->getId());
});
