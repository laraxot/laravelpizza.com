<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Filament\Pages;

use Filament\Widgets\WidgetConfiguration;
use Modules\Notify\Filament\Pages\SettingPage;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

test('setting page returns env widget in header', function () {
    $page = new SettingPage;

    $widgets = $page->getHeaderWidgets();

    expect($widgets)->toBeArray()->toHaveCount(1)
        ->and($widgets[0])->toBeInstanceOf(WidgetConfiguration::class);
});
