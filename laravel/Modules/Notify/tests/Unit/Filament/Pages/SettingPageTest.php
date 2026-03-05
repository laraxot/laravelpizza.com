<?php

declare(strict_types=1);

use Modules\Notify\Filament\Pages\SettingPage;
use Modules\Notify\Tests\TestCase;
use Filament\Widgets\WidgetConfiguration;

uses(TestCase::class);

test('setting page returns env widget in header', function () {
    $page = new SettingPage();

    $widgets = $page->getHeaderWidgets();

    expect($widgets)->toBeArray()->toHaveCount(1)
        ->and($widgets[0])->toBeInstanceOf(WidgetConfiguration::class);
});
