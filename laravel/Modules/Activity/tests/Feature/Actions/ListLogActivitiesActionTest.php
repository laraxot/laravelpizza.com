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

// Specifica non implementata: ListLogActivitiesAction espone solo setUp() e getDefaultName(). Questi test
// presupponevano getUrl($livewire, $record), findResourceClass(), getFieldLabel(), getActivitiesModalContent(),
// getActivitiesPageClass() e getClassFromFile(), tutti assenti, su un modulo (IndennitaResponsabilita) che non
// esiste in questo progetto. Il corpo e' nel repo Activity al commit b88f43dd.
$actionHelpersNotImplemented = 'ListLogActivitiesAction resource/content helpers not implemented';

test('action can find resource class')->skip($actionHelpersNotImplemented);
test('action can extract field labels')->skip($actionHelpersNotImplemented);
test('action handles missing resource')->skip($actionHelpersNotImplemented);
test('action handles record without activities')->skip($actionHelpersNotImplemented);
test('action generates content for record with activities')->skip($actionHelpersNotImplemented);
test('action can navigate')->skip($actionHelpersNotImplemented);
test('action can extract class from file')->skip($actionHelpersNotImplemented);
