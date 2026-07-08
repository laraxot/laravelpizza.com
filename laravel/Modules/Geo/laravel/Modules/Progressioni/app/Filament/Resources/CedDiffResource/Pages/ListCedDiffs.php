<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CedDiffResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Modules\Progressioni\Filament\Imports\CedDiffImporter;
use Modules\Progressioni\Filament\Resources\CedDiffResource;
use Modules\Progressioni\Models\CedDiff;
use Modules\Progressioni\Models\Scheda;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListCedDiffs extends PtvBaseYearListRecords
{
    protected static string $resource = CedDiffResource::class;

    /**
     * @return array<string, Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
            'import' => ImportAction::make()
                ->importer(CedDiffImporter::class)
                ->label(__('progressioni::messages.import_ced_diff')) // Traduzione
                ->modalHeading(__('progressioni::messages.import_modal_heading')) // Titolo della modale
                ->successNotificationTitle(__('progressioni::messages.import_success')) // Messaggio di successo
                ->color('success'), // Colore dell'azione
            'escludi' => Action::make('escludi da progressione')
                ->schema([
                    TextInput::make('anno')
                        ->numeric()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $matricole = CedDiff::all()->pluck('matricola')->toArray();

                    $rows = Scheda::where('anno', $data['anno'])
                        ->whereIn('matr', $matricole)
                        ->get();
                    foreach ($rows as $row) {
                        $motivo_arr = explode(',', (string) $row->motivo);
                        $motivo_arr[] = 'gradino';
                        $motivo_arr = array_unique($motivo_arr);
                        $motivo_arr = array_filter($motivo_arr);
                        /*
                        $row->update([
                            'ha_diritto'=>0,
                            'motivo'=>implode(',', $motivo_arr),
                        ]);
                        */
                        // dddx($row);
                        $row->ha_diritto = 0;
                        $row->motivo = implode(',', $motivo_arr);
                        $row->save();
                    }
                }),
        ];
    }

    #[Override]
    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        return [
            'matricola' => TextColumn::make('matricola')->searchable()->sortable(),
            'cognome' => TextColumn::make('cognome')->searchable()->sortable(),
            'nome' => TextColumn::make('nome')->searchable()->sortable(),
            'dal' => TextColumn::make('dal')->sortable(),
            'al' => TextColumn::make('al')->sortable(),
            'importo_forzato' => TextColumn::make('importo_forzato')->searchable()->sortable(),
            'importo_base' => TextColumn::make('importo_base')->searchable()->sortable(),
            'voce' => TextColumn::make('voce')->searchable()->sortable(),
            'descrizione' => TextColumn::make('descrizione')->searchable()->sortable(),
            'istituto' => TextColumn::make('istituto')->searchable()->sortable(),
            'tipo' => TextColumn::make('tipo')->searchable()->sortable(),
            'ruolo' => TextColumn::make('ruolo')->searchable()->sortable(),
            'ruolo_txt' => TextColumn::make('ruolo_txt')->searchable()->sortable(),
            'profilo' => TextColumn::make('profilo')->searchable()->sortable(),
            'profilo_txt' => TextColumn::make('profilo_txt')->searchable()->sortable(),
            'posizione_funzionale' => TextColumn::make('posizione_funzionale')->searchable()->sortable(),
            'descr_posizione_funzionale' => TextColumn::make('descr_posizione_funzionale')->searchable()->sortable(),
            'stabilimento' => TextColumn::make('stabilimento')->searchable()->sortable(),
            'stabi_txt' => TextColumn::make('stabi_txt')->searchable()->sortable(),
            'reparto' => TextColumn::make('reparto')->searchable()->sortable(),
            'repar_txt' => TextColumn::make('repar_txt')->searchable()->sortable(),
        ];
    }

    #[Override]
    /**
    * @return array<string, Filter>
    */
    public function getTableFilters(): array
    {
        return [
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    /**
    * @return array<string, Action>
    */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make()
                ->label(''),
            'edit' => EditAction::make()
                ->label(''),
            'delete' => DeleteAction::make()
                ->label('')
                ->requiresConfirmation(),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }

    #[Override]
    public function table(Table $table): Table
    {
        $listColumns = $this->getTableColumns();
        $gridColumns = $listColumns; // Use same columns for both layouts

        return $table
            // ->columns($this->getTableColumns())
            ->columns($this->layoutView->getTableColumns($listColumns, $gridColumns))
            ->contentGrid($this->layoutView->getTableContentGrid())
            ->headerActions($this->getTableHeaderActions())

            ->filters($this->getTableFilters())
            ->filtersLayout(FiltersLayout::AboveContent)
            ->persistFiltersInSession()
            ->recordActions($this->getTableActions())
            ->toolbarActions($this->getTableBulkActions())
            ->recordActionsPosition(RecordActionsPosition::BeforeColumns)
            ->defaultSort(
                column: 'created_at',
                direction: 'DESC',
            );
    }
}
