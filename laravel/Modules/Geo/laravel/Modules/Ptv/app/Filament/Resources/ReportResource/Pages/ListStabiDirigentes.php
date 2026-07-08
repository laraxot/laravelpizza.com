<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\ReportResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

// use Modules\Ptv\Filament\Resources\StabiDirigenteResource;

class ListStabiDirigentes extends XotBaseListRecords
{
    // protected static string $resource = StabiDirigenteResource::class;

    protected function getTableFiltersLayout(): FiltersLayout
    {
        return FiltersLayout::AboveContent;
    }

    protected function getTableActionsPosition(): RecordActionsPosition
    {
        return RecordActionsPosition::BeforeColumns;
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        // @phpstan-ignore-next-line return.type
        return [
            CreateAction::make(),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id'),
            'valutatore_id' => TextColumn::make('valutatore_id'),
            'stabi' => TextColumn::make('stabi')->searchable(),
            'repar' => TextColumn::make('repar')->searchable(),
            'nome_stabi' => TextColumn::make('nome_stabi')->searchable(),
            'nome_diri' => TextColumn::make('nome_diri')->searchable(),
            'nome_diri_plus' => TextColumn::make('nome_diri_plus')->searchable(),
            'anno' => TextColumn::make('anno'),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno')
                ->options([
                    '2021' => '2021',
                    '2022' => '2022',
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                ])->query(static function (Builder $query, array $data): Builder {
                    if ($data['value'] == null) {
                        return $query->where('id', 0);
                    }

                    return $query->where('anno', $data['value']);
                }),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        return [
            EditAction::make()
                ->label('')
                ->tooltip('Modifica'),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }

    #[Override]
    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getTableColumns())
            ->filters($this->getTableFilters())
            ->recordActions($this->getTableActions())
            ->filtersLayout($this->getTableFiltersLayout())
            ->recordActionsPosition($this->getTableActionsPosition())
            ->filtersFormColumns(1)
            ->persistFiltersInSession()
            ->toolbarActions($this->getTableBulkActions());
    }
}
