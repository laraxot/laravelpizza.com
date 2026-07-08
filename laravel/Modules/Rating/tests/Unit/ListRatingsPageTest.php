<?php

declare(strict_types=1);

use Modules\Rating\Filament\Resources\RatingResource\Pages\ListRatings;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('defines expected table columns without labels', function (): void {
    $page = new ListRatings();
    $columns = $page->getTableColumns();

    Assert::assertSame(['id', 'title', 'rule', 'is_disabled', 'is_readonly'], array_keys($columns));
});

test('defines default empty filters and header actions', function (): void {
    $page = new ListRatings();

    Assert::assertSame([], $page->getTableFilters());
    Assert::assertNotEmpty($page->getTableHeaderActions());
});

test('defines view edit delete actions and bulk delete', function (): void {
    $page = new ListRatings();
    $actions = $page->getTableActions();
    $bulk = $page->getTableBulkActions();

    Assert::assertArrayHasKey('view', $actions);
    Assert::assertArrayHasKey('edit', $actions);
    Assert::assertArrayHasKey('delete', $actions);
    Assert::assertArrayHasKey('delete', $bulk);
});
