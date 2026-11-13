<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\SnapshotResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
<<<<<<< .merge_file_5qdCEs
use Modules\Activity\Models\Snapshot;
=======
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Modules\Activity\Models\Snapshot;
use Modules\UI\Filament\Tables\Columns\IDColumn;
>>>>>>> .merge_file_BzTneY
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\json_encode;

class SnapshotsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Snapshot>
     */
    protected static string $model = Snapshot::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'aggregate_uuid' => TextColumn::make('aggregate_uuid')->searchable()->sortable()->copyable(),
            'aggregate_version' => TextColumn::make('aggregate_version')->numeric()->sortable(),
            'state' => TextColumn::make('state')
                ->state(static fn (Snapshot $record): string => json_encode($record->state, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->limit(100)
                ->wrap()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
<<<<<<< .merge_file_5qdCEs
            'id' => TextColumn::make('id')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
=======
            'id' => IDColumn::make('id')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'aggregate_uuid' => SelectFilter::make('aggregate_uuid')
                ->searchable()
                ->getSearchResultsUsing(fn (string $search): array => (new Snapshot)->newQuery()
                    ->where('aggregate_uuid', 'like', "%{$search}%")
                    ->distinct()
                    ->orderBy('aggregate_uuid')
                    ->limit(50)
                    ->pluck('aggregate_uuid', 'aggregate_uuid')
                    ->all())
                ->getOptionLabelUsing(fn (string $value): string => $value),
>>>>>>> .merge_file_BzTneY
        ];
    }
}
