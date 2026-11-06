<?php

declare(strict_types=1);

use Modules\Job\Filament\Widgets\ScheduleStatusWidget;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ScheduleStatusWidget espone solo comandi schedule in whitelist', function (): void {
    $widget = new ScheduleStatusWidget();
    Assert::assertContains('schedule:list', $widget->getAllowedCommands());
    $widget->artisan('migrate:fresh');
    Assert::assertSame('', $widget->out);
});
