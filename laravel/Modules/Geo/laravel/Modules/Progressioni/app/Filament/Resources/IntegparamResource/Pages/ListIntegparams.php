<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\IntegparamResource\Pages;

use Carbon\Carbon;
use Exception;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\IntegparamResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListIntegparams extends XotBaseListRecords
{
    protected static string $resource = IntegparamResource::class;

    /**
     * Get the table columns.
     *
     * @return array<string, Column>
     */
    #[Override]
    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        return [
            'ente' => TextColumn::make('ente')
                ->searchable()
                ->sortable(),

            'matr' => TextColumn::make('matr')
                ->searchable()
                ->sortable(),

            'conome' => TextColumn::make('conome')
                ->searchable()
                ->sortable(),

            'nome' => TextColumn::make('nome')
                ->searchable()
                ->sortable(),

            'anv2kd' => TextColumn::make('anv2kd')
                ->date()
                ->sortable(),

            'anv2ka' => TextColumn::make('anv2ka')
                ->date()
                ->sortable()
                ->formatStateUsing(function (mixed $state): string {
                    if (empty($state)) {
                        return '';
                    }

                    try {
                        $stateString = is_string($state) ? $state : (string) $state;
                        if ($stateString === '') {
                            return '';
                        }
                        // After empty check, $stateString is guaranteed to be non-falsy-string
                        $date = Carbon::parse($stateString);
                        if ($date->year < 0) {
                            return '';
                        }

                        return $date->format('d/m/Y');
                    } catch (Exception $e) {
                        return '';
                    }
                }),

            'anvist' => IconColumn::make('anvist')
                ->boolean()
                ->sortable(),

            'anvpar' => TextColumn::make('anvpar')
                ->searchable(),

            'anvimp' => TextColumn::make('anvimp')
                ->numeric()
                ->sortable(),

            'anvqta' => TextColumn::make('anvqta')
                ->numeric()
                ->sortable(),

            'anvvoc' => TextColumn::make('anvvoc')
                ->searchable(),

            'anvdes' => TextColumn::make('anvdes')
                ->limit(50)
                ->searchable(),
        ];
    }
}
