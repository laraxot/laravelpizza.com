<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Support;

use Filament\Schemas\Schema;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\Layout\Component;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mockery\MockInterface;
use Modules\Xot\Filament\Traits\HasXotTable;

/**
 * @property string|null $tableSearch
 */
class HasTableWithoutOptionalMethodsTestClass
{
    use HasXotTable;

    public function getLayoutView(): object
    {
        $mock = \Mockery::mock();
        $mock->allows(['getTableColumns' => []]);
        $mock->allows(['getTableContentGrid' => []]);

        return $mock;
    }

    #[\Override]
    /** @return array<int, Column|ColumnGroup|Component> */
    public function getTableColumns(): array
    {
        return [];
    }

    /**
     * @return Table&MockInterface
     */
    public function getTable(): Table
    {
        /** @var Table&MockInterface $mock */
        $mock = \Mockery::mock(Table::class);

        return $mock;
    }

    public function getTablePage(): ?int
    {
        return 1;
    }

    public function getTableRecordsPerPage(): int
    {
        return 10;
    }

    public function getTableSortColumn(): ?string
    {
        return null;
    }

    public function getTableSortDirection(): ?string
    {
        return null;
    }

    /** @return array<string|int, BaseFilter> */
    public function getTableFilters(): array
    {
        return [];
    }

    public function getTableFiltersForm(): ?Schema
    {
        return null;
    }

    /** @return array<int, mixed> */
    public function getTableFilterState(string $_name): ?array
    {
        return [];
    }

    public function getTableGrouping(): ?string
    {
        return null;
    }

    public function getTableSearchIndicator(): ?string
    {
        return null;
    }

    /** @return array<int, mixed> */
    public function getTableColumnSearchIndicators(): array
    {
        return [];
    }

    public function getTableColumnToggleForm(): ?Schema
    {
        return null;
    }

    /** @return array<int, mixed> */
    public function getTableRecords(): array
    {
        return [];
    }

    /**
     * @return Model|array<string, mixed>|null
     */
    public function getTableRecord(): Model|array|null
    {
        return null;
    }

    public function getTableRecordKey(): ?string
    {
        return null;
    }

    /** @return array<int, mixed> */
    public function getSelectedTableRecords(): array
    {
        return [];
    }

    public function getAllTableRecordsCount(): int
    {
        return 0;
    }

    public function getAllSelectableTableRecordsCount(): int
    {
        return 0;
    }

    /** @return array<int, mixed> */
    public function getAllSelectableTableRecordKeys(): array
    {
        return [];
    }

    /**
     * @return Builder<Model>|null
     */
    public function getTableQueryForExport(): ?Builder
    {
        return null;
    }

    /**
     * @return Builder<Model>|null
     */
    public function getFilteredTableQuery(): ?Builder
    {
        return null;
    }

    /**
     * @return Builder<Model>|null
     */
    public function getFilteredSortedTableQuery(): ?Builder
    {
        return null;
    }

    /**
     * @return Builder<Model>|null
     */
    public function getAllTableSummaryQuery(): ?Builder
    {
        return null;
    }

    /**
     * @return Builder<Model>|null
     */
    public function getPageTableSummaryQuery(): ?Builder
    {
        return null;
    }

    public function getMountedTableAction(): ?string
    {
        return null;
    }

    public function getMountedTableActionForm(): ?Schema
    {
        return null;
    }

    public function getMountedTableActionRecord(): ?Model
    {
        return null;
    }

    public function getMountedTableActionRecordKey(): ?string
    {
        return null;
    }

    public function getMountedTableBulkAction(): ?string
    {
        return null;
    }

    public function getMountedTableBulkActionForm(): ?Schema
    {
        return null;
    }

    public function getActiveTableLocale(): ?string
    {
        return null;
    }

    public function isTableLoaded(): bool
    {
        return true;
    }

    public function isTableReordering(): bool
    {
        return false;
    }

    public function hasTableSearch(): bool
    {
        return false;
    }

    public function isTableColumnToggledHidden(): bool
    {
        return false;
    }

    public function callMountedTableAction(): mixed
    {
        return null;
    }

    public function callTableColumnAction(string $_name, string $_recordKey): mixed
    {
        return null;
    }

    public function deselectAllTableRecords(): void {}

    public function mountTableAction(): void {}

    public function mountTableBulkAction(): void {}

    public function mountedTableActionRecord(): ?Model
    {
        return null;
    }

    public function replaceMountedTableAction(): void {}

    public function replaceMountedTableBulkAction(): void {}

    public function resetTableSearch(): void {}

    public function resetTableColumnSearch(): void {}

    public function toggleTableReordering(): void {}

    public function parseTableFilterName(): string
    {
        return '';
    }

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }
}
