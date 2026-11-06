<?php

declare(strict_types=1);
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestPage;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestRecord;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestResource;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('action has correct default name', function (): void {
    Assert::assertSame('list_log_activities', ListLogActivitiesAction::getDefaultName());
});

test('action tooltip is translated correctly', function () {
    $action = ListLogActivitiesAction::make();

    Assert::assertSame('list_log_activities', $action->getTooltip());
});

test('action is configured correctly', function (): void {
    $action = ListLogActivitiesAction::make();

    Assert::assertSame('list_log_activities', $action->getName());
    Assert::assertSame('heroicon-o-clock', $action->getIcon());
    Assert::assertSame('gray', $action->getColor());
});

test('action generates correct URL for activity log page', function (): void {
    $action = ListLogActivitiesAction::make();

    $livewire = ListLogActivitiesActionTestPage::usingResource(ListLogActivitiesActionTestResource::class);
    $record = new ListLogActivitiesActionTestRecord;

    $action->livewire($livewire);
    $action->record($record);

    $url = $action->getUrl();
    Assert::assertNotNull($url);
    Assert::assertStringContainsString('log-activity', $url);
    Assert::assertStringContainsString('test-record-key', $url);
});

// Specifica non implementata: l'action e' sempre visibile, non ha logica `visible()` legata alle attivita' del
// record. Il corpo di questi test (su IndennitaResponsabilita, modulo assente) e' nel repo Activity al commit b88f43dd.
$visibilityNotImplemented = 'ListLogActivitiesAction visibility by record activities not implemented';

test('action is visible in table actions')->skip($visibilityNotImplemented);
test('action is visible only when record has activities')->skip($visibilityNotImplemented);
