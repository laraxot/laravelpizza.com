<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Filament\Tables\Enums\PaginationMode;
use Modules\Activity\Tests\Fixtures\CanPaginateHarness;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('CanPaginate gestisce session e default senza database', function (): void {
    $harness = new CanPaginateHarness;
    $harness->recordsPerPage = 25;

    $harness->updatedRecordsPerPage();

    Assert::assertSame(25, $harness->recordsPerPage);
    Assert::assertSame(1, $harness->pageResetCount);
    Assert::assertSame(25, $harness->getRecordsPerPage());
    Assert::assertSame(2, $harness->getTablePage());
    Assert::assertSame('recordsPerPage', $harness->getPaginationPageName());
    Assert::assertStringStartsWith('pages.', $harness->getPerPageSessionKey());
});

test('CanPaginate default option fallback senza database', function (): void {
    $harness = new CanPaginateHarness;
    $harness->setDefaultPerPage(25);

    Assert::assertSame(25, $harness->getDefaultRecordsPerPageSelectOption());
    Assert::assertSame([10, 25, 50], $harness->exposeOptions());

    session()->put([$harness->getPerPageSessionKey() => 999]);
    Assert::assertSame(10, $harness->getDefaultRecordsPerPageSelectOption());
    Assert::assertFalse(session()->has($harness->getPerPageSessionKey()));
});

test('CanPaginate recordsPerPage null usa default option', function (): void {
    $harness = new CanPaginateHarness;
    $harness->setDefaultPerPage(50);

    Assert::assertSame(50, $harness->getRecordsPerPage());
});

test('CanPaginate espone pagination mode default', function (): void {
    $harness = new CanPaginateHarness;

    Assert::assertSame(PaginationMode::Default, $harness->getPaginationMode());
});
