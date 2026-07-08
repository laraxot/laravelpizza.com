<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Filament\Pages;

use Modules\Notify\Filament\Pages\SettingPage;
use Modules\Notify\Tests\TestCase;

uses(\Modules\Notify\Tests\TestCase::class);

test('setting page returns env widget in header', function () {
    $page = new SettingPage;

    $widgets = $page->getHeaderWidgets();

});
