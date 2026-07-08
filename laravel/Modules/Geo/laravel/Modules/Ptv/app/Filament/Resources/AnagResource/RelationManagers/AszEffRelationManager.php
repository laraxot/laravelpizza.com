<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\AnagResource\RelationManagers;

use Filament\Infolists\Components;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AszEffRelationManager extends RelationManager
{
    protected static string $relationship = 'aszEff';
    // protected static ?string $inverseRelationship = 'section'; // Since the inverse related model is `Category`, this is normally `category`, not `section`.

    public function form(Schema $schema): Schema
    {
        return $schema
            // ->columns(1)
            ->components([
                TextEntry::make('id'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([

                TextColumn::make('id'),
                TextColumn::make('matr'),
                TextColumn::make('tip-cod')
                    ->default(function ($record): string {
                        // Type narrowing: ensure record is object with properties
                        if (! is_object($record)) {
                            return '-';
                        }
                        $asztip = isset($record->asztip) && is_string($record->asztip) ? $record->asztip : '';
                        $aszcod = isset($record->aszcod) && is_string($record->aszcod) ? $record->aszcod : '';

                        return $asztip.'-'.$aszcod;
                    }),
                /*
                    Components\Group::make()->schema([
                        Components\TextEntry::make('asztip'),
                        Components\TextEntry::make('aszcod'),
                    ]),
                    */
                TextColumn::make('ini-fin')
                    ->default(function ($record): string {
                        // Type narrowing: ensure record is object with properties
                        if (! is_object($record)) {
                            return '-';
                        }
                        $aszini = isset($record->aszini) && is_string($record->aszini) ? $record->aszini : '';
                        $aszfin = isset($record->aszfin) && is_string($record->aszfin) ? $record->aszfin : '';

                        return $aszini.'-'.$aszfin;
                    }),
                /*
                    Components\Group::make()->schema([
                        Components\TextEntry::make('aszini'),
                        Components\TextEntry::make('aszfin'),
                    ]),
                    */
                TextColumn::make('asz2kd'),
                TextColumn::make('asz2ka'),
                TextColumn::make('aszumi'),
                TextColumn::make('aszdur'),
                // Components\TextEntry::make('aszann'),
                // Components\TextEntry::make('asz_txt')->,
                // ->columnSpan(2),
                TextColumn::make('propro')
                // ->default(fn($record)=>$record->propro)
                ,
                TextColumn::make('posfun'),

                TextColumn::make('_gg')
                    ->default(function ($record, $livewire): int {
                        // Type narrowing: ensure record is object with gg() method
                        if (! is_object($record) || ! method_exists($record, 'gg')) {
                            return 0;
                        }

                        // Type narrowing: ensure livewire is RelationManager
                        if (! is_object($livewire) || ! method_exists($livewire, 'getOwnerRecord')) {
                            return 0;
                        }

                        $ownerRecord = $livewire->getOwnerRecord();
                        if ($ownerRecord === null || ! is_object($ownerRecord) || ! method_exists($ownerRecord, 'getDateMax')) {
                            return 0;
                        }

                        $dateMax = $ownerRecord->getDateMax();
                        $result = $record->gg(['date_max' => $dateMax]);

                        return is_int($result) ? $result : 0;
                    }),
                TextColumn::make('_gg_cateco')
                    ->default(function ($record, $livewire): int {
                        // Type narrowing: ensure record is object with gg() method
                        if (! is_object($record) || ! method_exists($record, 'gg')) {
                            return 0;
                        }

                        // Type narrowing: ensure livewire is RelationManager
                        if (! is_object($livewire) || ! method_exists($livewire, 'getOwnerRecord')) {
                            return 0;
                        }

                        $ownerRecord = $livewire->getOwnerRecord();
                        if ($ownerRecord === null || ! is_object($ownerRecord) || ! method_exists($ownerRecord, 'getDateMax')) {
                            return 0;
                        }

                        $dateMax = $ownerRecord->getDateMax();
                        $listaPropro = isset($ownerRecord->lista_propro) ? $ownerRecord->lista_propro : null;
                        $listaProproSup = isset($ownerRecord->lista_propro_sup) ? $ownerRecord->lista_propro_sup : null;

                        $res = $record->gg([
                            'date_max' => $dateMax,
                            'lista_propro' => $listaPropro,
                            'lista_propro_sup' => $listaProproSup,
                        ]);

                        return is_int($res) ? $res : 0;
                    }),
                TextColumn::make('_gg_cateco_posfun')
                    ->default(function ($record, $livewire): int {
                        // Type narrowing: ensure record is object with gg() method
                        if (! is_object($record) || ! method_exists($record, 'gg')) {
                            return 0;
                        }

                        // Type narrowing: ensure livewire is RelationManager
                        if (! is_object($livewire) || ! method_exists($livewire, 'getOwnerRecord')) {
                            return 0;
                        }

                        $ownerRecord = $livewire->getOwnerRecord();
                        // Type narrowing: ensure ownerRecord is object before method_exists
                        if ($ownerRecord === null || ! is_object($ownerRecord)) {
                            return 0;
                        }
                        if (! method_exists($ownerRecord, 'getDateMax')) {
                            return 0;
                        }

                        $dateMax = $ownerRecord->getDateMax();
                        $listaPropro = isset($ownerRecord->lista_propro) ? $ownerRecord->lista_propro : null;
                        $listaProproSup = isset($ownerRecord->lista_propro_sup) ? $ownerRecord->lista_propro_sup : null;
                        $posfunVal = isset($ownerRecord->posfun_val) ? $ownerRecord->posfun_val : null;

                        $res = $record->gg([
                            'date_max' => $dateMax,
                            'lista_propro' => $listaPropro,
                            'lista_propro_sup' => $listaProproSup,
                            'posfun' => $posfunVal,
                        ]);

                        return is_int($res) ? $res : 0;
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->recordActions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                // Tables\Actions\BulkActionGroup::make([
                //    Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
