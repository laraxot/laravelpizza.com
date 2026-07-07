<?php

declare(strict_types=1);

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestPage;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestRecord;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestResourceSimple;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('action can be instantiated', function (): void {
    $action = ListLogActivitiesAction::make();

    Assert::assertInstanceOf(ListLogActivitiesAction::class, $action);
    Assert::assertSame('list_log_activities', $action::getDefaultName());
});

test('action has correct configuration', function (): void {
    $action = ListLogActivitiesAction::make();

    Assert::assertSame('heroicon-o-clock', $action->getIcon());
    Assert::assertSame('gray', $action->getColor());
});

test('action generates a log-activity URL containing record key', function (): void {
    $action = ListLogActivitiesAction::make();

    $livewire = ListLogActivitiesActionTestPage::usingResource(ListLogActivitiesActionTestResourceSimple::class);
    $record = new ListLogActivitiesActionTestRecord;

    $action->livewire($livewire);
    $action->record($record);

    $url = $action->getUrl();

    Assert::assertNotNull($url);
    Assert::assertStringContainsString('log-activity', $url);
    Assert::assertStringContainsString('test-record-key', $url);
});
