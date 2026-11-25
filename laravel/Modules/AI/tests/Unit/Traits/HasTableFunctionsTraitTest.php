<?php

declare(strict_types=1);
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Tests\Fixtures\Traits\HasTableFunctionsCustomSlugProbe;
use Modules\Xot\Tests\Fixtures\Traits\HasTableFunctionsTraitProbe;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('gets table columns', function (): void {
    $probe = new HasTableFunctionsTraitProbe;

    $columns = $probe->getTableColumns();
    Assert::assertInstanceOf(TextColumn::class, $columns['name']);
    Assert::assertArrayHasKey('id', $columns);
});

it('gets table actions', function (): void {
    $probe = new HasTableFunctionsCustomSlugProbe;

    $actions = $probe->getTableActions();
    Assert::assertInstanceOf(Action::class, $actions['delete']);
    Assert::assertArrayHasKey('edit', $actions);
});

it('gets table bulk actions', function (): void {
    $probe = new HasTableFunctionsTraitProbe;

    $bulkActions = $probe->getTableBulkActions();
    Assert::assertInstanceOf(BulkAction::class, $bulkActions['delete']);
});

it('has default resource slug', function (): void {
    $probe = new HasTableFunctionsTraitProbe;

    Assert::assertSame('default', $probe->exposeResourceSlug());
});
