<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CedDiffResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Imports\CedDiffImporter;
use Modules\Progressioni\Models\CedDiff;
use Modules\Progressioni\Models\Scheda;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CedDiffsTable extends XotBaseResourceTable
{
    /**
     * Convertito da ListCedDiffs::getHeaderActions() (azioni pagina) al contesto
     * classe Table: metodo `getTableHeaderActions()` cablato da HasXotTable in ->headerActions().
     *
     * @return array<string, Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
            'import' => ImportAction::make()
                ->importer(CedDiffImporter::class)
                ->label(__('progressioni::messages.import_ced_diff'))
                ->modalHeading(__('progressioni::messages.import_modal_heading'))
                ->successNotificationTitle(__('progressioni::messages.import_success'))
                ->color('success'),
            'escludi' => Action::make('escludi da progressione')
                ->schema([
                    TextInput::make('anno')
                        ->numeric()
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $matricole = CedDiff::all()->pluck('matricola')->toArray();

                    $rows = Scheda::where('anno', $data['anno'])
                        ->whereIn('matr', $matricole)
                        ->get();
                    foreach ($rows as $row) {
                        $motivo_arr = explode(',', (string) $row->motivo);
                        $motivo_arr[] = 'gradino';
                        $motivo_arr = array_unique($motivo_arr);
                        $motivo_arr = array_filter($motivo_arr);
                        $row->ha_diritto = 0;
                        $row->motivo = implode(',', $motivo_arr);
                        $row->save();
                    }
                }),
        ];
    }

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

    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
