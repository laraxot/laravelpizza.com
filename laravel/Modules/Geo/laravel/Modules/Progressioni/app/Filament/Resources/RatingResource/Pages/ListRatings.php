<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\RatingResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Filament\Resources\RatingResource;
use Modules\Progressioni\Models\Rating;
use Modules\Rating\Filament\Resources\RatingResource\Pages\BaseListRatings;
use Override;

class ListRatings extends BaseListRatings
{
    protected static string $resource = RatingResource::class;

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getTableHeaderActions(): array
    {
        /** @var array<string, Action|ActionGroup> $parentActions */
        $parentActions = parent::getTableHeaderActions();
        /** @var array<string, string|int|bool|null>|null $tableFilters */
        $tableFilters = $this->tableFilters;
        /** @var string|int|bool|null $annoRaw */
        $annoRaw = Arr::get($tableFilters ?? [], 'filter.anno');
        /** @var int|null $anno */
        $anno = is_numeric($annoRaw) ? (int) $annoRaw : null;

        return [
            ...$parentActions,
            'copy_from_last_year' => Action::make('copy_from_last_year')
                ->action(function () use ($anno): void {
                    if ($anno === null) {
                        return;
                    }
                    /** @var int $annoInt */
                    $annoInt = is_int($anno) ? $anno : (int) $anno;
                    $anno_prec = $annoInt - 1;
                    /** @var class-string<Rating> $model */
                    $model = $this->getModel();
                    // Query per schemaless attributes - filtra per extra_attributes->anno
                    /** @var Collection<int, Rating> $rows */
                    $rows = $model::query()
                        ->where('extra_attributes->anno', $anno_prec)
                        ->get();
                    foreach ($rows as $row) {
                        /** @var array<string, mixed> $data */
                        $data = $row->toArray();
                        /** @var array<string, mixed> $data_where */
                        $data_where = Arr::only($data, ['title']);
                        unset($data['id']);

                        /** @var Rating $rowCreated */
                        $rowCreated = $model::query()->firstOrCreate($data_where, $data);

                        if ($rowCreated->extra_attributes !== null) {
                            $rowCreated->extra_attributes->set('anno', $annoInt);
                            $rowCreated->save();
                        }
                    }
                }),
        ];
    }

    /**
     * @return array<string, Column>
     */
    #[Override]
    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        /** @var array<string, Column> $cols */
        $cols = parent::getTableColumns();
        /** @var array<string, Column> $prepend */
        $prepend = [
            'extra_attributes_type' => TextColumn::make('extra_attributes.type'),
            'extra_attributes_anno' => TextColumn::make('extra_attributes.anno'),
        ];

        /** @var array<string, Column> $merged */
        $merged = array_merge($prepend, $cols);

        return $merged;
    }

    /**
     * @return array<string, Filter>
     */
    #[Override]
    /**
    * @return array<string, Filter>
    */
    public function getTableFilters(): array
    {
        return [
            'filter' => Filter::make('filter')
                ->schema([
                    'anno' => Select::make('anno')
                        ->options(self::getYears()),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (! isset($data['anno'])) {
                        return $query;
                    }
                    /** @var Builder<Rating> $query */
                    /** @var int|string|null $anno */
                    $anno = $data['anno'] ?? null;
                    if ($anno === null) {
                        return $query;
                    }

                    // Query per schemaless attributes - filtra per extra_attributes->anno
                    return $query->where('extra_attributes->anno', $anno);
                }),
        ];
    }

    /**
     * @return array<int, string>
     */
    protected static function getYears(): array
    {
        $currentYear = Carbon::now()->year;
        $years = [];
        for ($year = $currentYear; $year >= $currentYear - 2; $year--) {
            $years[$year] = (string) $year;
        }

        return $years;
    }
}
