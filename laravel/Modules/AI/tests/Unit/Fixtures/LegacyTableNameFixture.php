<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Fixtures;

use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\Filter;
use Modules\Xot\Filament\Traits\HasXotTable;

final class LegacyTableNameFixture
{
    use HasXotTable;

    public string $tableSearch = '';

    /** @return array<string, Column> */
    public function getTableColumns(): array
    {
        return [];
    }

    /** @return array<string|int, Filter> */
    public function getTableFilters(): array
    {
        return ['legacy_filter' => Filter::make('legacy_filter')];
    }
}
