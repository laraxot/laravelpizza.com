<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Filament\Resources\ExtraResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * Table di ExtraResource: getResource() la deduce dal namespace `{Resource}\\Tables\\`.
 */
final class XotBaseResourceTableConfigureFixture extends XotBaseResourceTable
{
    /**
     * @return array<string, TextColumn>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
        ];
    }

    /**
     * @return array<string, Filter>
     */
    public function getTableFilters(): array
    {
        return [
            'fixture_filter' => Filter::make('fixture_filter'),
        ];
    }
}
