<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\Asz00fResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Progressioni\Filament\Resources\Asz00fResource;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Tables\Asz00fsTable;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Widgets\Asz00fStatsOverview;
use Modules\Progressioni\Models\Asz00f;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListAsz00fs extends XotBaseListRecords
{
    protected static string $resource = Asz00fResource::class;

    /**
     * @return array<class-string>
     */
    public function getHeaderWidgets(): array
    {
        return [
            Asz00fStatsOverview::class,
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
        return app(Asz00fsTable::class)->getTableColumns();
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
            'ricerca' => Filter::make('ricerca')
                ->columns(2)
                ->schema([
                    'ente' => TextInput::make('ente')->numeric(),
                    'matr' => TextInput::make('matr')->numeric(),
                    'asztip' => TextInput::make('asztip')->numeric(),
                    'aszcod' => TextInput::make('aszcod')->numeric(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    /** @var array<string, mixed> $data */
                    /** @var Builder<Asz00f> $query */

                    return $query
                        ->when(
                            filled($data['ente'] ?? null),
                            fn (Builder $query): Builder => $query->where('ente', (int) $data['ente']),
                        )
                        ->when(
                            filled($data['matr'] ?? null),
                            fn (Builder $query): Builder => $query->where('matr', (int) $data['matr']),
                        )
                        ->when(
                            filled($data['asztip'] ?? null),
                            fn (Builder $query): Builder => $query->where('asztip', (int) $data['asztip']),
                        )
                        ->when(
                            filled($data['aszcod'] ?? null),
                            fn (Builder $query): Builder => $query->where('aszcod', (int) $data['aszcod']),
                        );
                }),
        ];
    }
}
