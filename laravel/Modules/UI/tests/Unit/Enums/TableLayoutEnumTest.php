<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Enums;

use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Enums\TableLayoutEnum;
use Tests\TestCase;

class TableLayoutEnumTest extends TestCase
{
    /**
     * Test enum values.
     */
    public function testEnumValues(): void
    {
        static::assertSame('list', TableLayoutEnum::LIST->value);
        static::assertSame('grid', TableLayoutEnum::GRID->value);
    }

    /**
     * Test default layout.
     */
    public function testDefaultLayout(): void
    {
        $default = TableLayoutEnum::init();
        static::assertSame(TableLayoutEnum::LIST, $default);
    }

    /**
     * Test toggle functionality.
     */
    public function testToggleFunctionality(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        static::assertSame($grid, $list->toggle());
        static::assertSame($list, $grid->toggle());
    }

    /**
     * Test layout type checks.
     */
    public function testLayoutTypeChecks(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        static::assertTrue($list->isListLayout());
        static::assertFalse($list->isGridLayout());

        static::assertTrue($grid->isGridLayout());
        static::assertFalse($grid->isListLayout());
    }

    /**
     * Test grid configuration.
     */
    public function testGridConfiguration(): void
    {
        $grid = TableLayoutEnum::GRID;
        $config = $grid->getTableContentGrid();

        static::assertIsArray($config);
        static::assertArrayHasKey('sm', $config);
        static::assertArrayHasKey('md', $config);
        static::assertArrayHasKey('lg', $config);
        static::assertArrayHasKey('xl', $config);
        static::assertArrayHasKey('2xl', $config);
    }

    /**
     * Test table columns method.
     */
    public function testTableColumnsMethod(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        $listColumns = [
            TextColumn::make('name'),
            TextColumn::make('email'),
        ];

        $gridColumns = [
            Stack::make([
                TextColumn::make('name'),
                TextColumn::make('email'),
            ]),
        ];

        // Test list layout
        $result = $list->getTableColumns($listColumns, $gridColumns);
        static::assertSame($listColumns, $result);

        // Test grid layout
        $result = $grid->getTableColumns($listColumns, $gridColumns);
        static::assertSame($gridColumns, $result);
    }

    /**
     * Test options method.
     */
    public function testOptionsMethod(): void
    {
        $options = TableLayoutEnum::getOptions();

        static::assertIsArray($options);
        static::assertArrayHasKey('list', $options);
        static::assertArrayHasKey('grid', $options);
        static::assertSame(TableLayoutEnum::LIST, $options['list']);
        static::assertSame(TableLayoutEnum::GRID, $options['grid']);
    }

    /**
     * Test container classes.
     */
    public function testContainerClasses(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        $listClasses = $list->getContainerClasses();
        $gridClasses = $grid->getContainerClasses();

        static::assertIsString($listClasses);
        static::assertIsString($gridClasses);
        static::assertNotEmpty($listClasses);
        static::assertNotEmpty($gridClasses);
    }

    /**
     * Test translation support.
     */
    public function testTranslationSupport(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        // Test that labels are translatable
        $listLabel = $list->getLabel();
        $gridLabel = $grid->getLabel();

        static::assertIsString($listLabel);
        static::assertIsString($gridLabel);
        static::assertNotEmpty($listLabel);
        static::assertNotEmpty($gridLabel);
    }

    /**
     * Test color and icon methods.
     */
    public function testColorAndIconMethods(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        // Test colors
        $listColor = $list->getColor();
        $gridColor = $grid->getColor();

        static::assertIsString($listColor);
        static::assertIsString($gridColor);
        static::assertNotEmpty($listColor);
        static::assertNotEmpty($gridColor);

        // Test icons
        $listIcon = $list->getIcon();
        $gridIcon = $grid->getIcon();

        static::assertIsString($listIcon);
        static::assertIsString($gridIcon);
        static::assertNotEmpty($listIcon);
        static::assertNotEmpty($gridIcon);
    }
}
