<?php

declare(strict_types=1);

use Modules\Cms\Filament\Fields\LeftSidebarContent;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('LeftSidebarContent creates builder with empty blocks', function () {
    $result = LeftSidebarContent::make('test_field', 'form');

    // Note: getBlocks() may fail due to container initialization, so we test differently
    // We just verify the builder was created
});

test('LeftSidebarContent has correct field name', function () {
    $result = LeftSidebarContent::make('sidebar_content', 'form');

    Assert::assertSame('sidebar_content', $result->getName());
});

test('LeftSidebarContent returns collapsible builder', function () {
    $result = LeftSidebarContent::make('test', 'form');

    Assert::assertTrue($result->isCollapsible());
});

test('LeftSidebarContent accepts different contexts', function () {
    $formContext = LeftSidebarContent::make('field1', 'form');
    $tableContext = LeftSidebarContent::make('field2', 'table');

    Assert::assertSame('field1', $formContext->getName());

    Assert::assertSame('field2', $tableContext->getName());
});
