<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\AnagResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class Qua00fRelationManager extends RelationManager
{
    protected static string $relationship = 'qua00f';
    // protected static ?string $inverseRelationship = 'section'; // Since the inverse related model is `Category`, this is normally `category`, not `section`.

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('matr'),
                TextColumn::make('propro'),
                TextColumn::make('posfun'),
                TextColumn::make('posiz'),
                TextColumn::make('categoria_eco'),
                TextColumn::make('qua2kd'),
                TextColumn::make('qua2ka'),

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
                        // Type narrowing: ensure ownerRecord is object before method_exists
                        if ($ownerRecord === null || ! is_object($ownerRecord)) {
                            return 0;
                        }
                        if (! method_exists($ownerRecord, 'getDateMax')) {
                            return 0;
                        }

                        $dateMax = $ownerRecord->getDateMax();
                        $noPosiz = method_exists($ownerRecord, 'getOption')
                            ? $ownerRecord->getOption('no_posiz')
                            : null;

                        $result = $record->gg([
                            'date_max' => $dateMax,
                            'no_posiz' => $noPosiz,
                        ]);

                        return is_int($result) ? $result : 0;
                    }),
                TextColumn::make('_gg_cateco')
                    ->default(function ($record, $livewire): float {
                        // Type narrowing: ensure record is object with gg() method
                        if (! is_object($record) || ! method_exists($record, 'gg')) {
                            return 0.0;
                        }

                        // Type narrowing: ensure livewire is RelationManager
                        if (! is_object($livewire) || ! method_exists($livewire, 'getOwnerRecord')) {
                            return 0.0;
                        }

                        $ownerRecord = $livewire->getOwnerRecord();
                        if ($ownerRecord === null || ! is_object($ownerRecord) || ! method_exists($ownerRecord, 'getDateMax')) {
                            return 0.0;
                        }

                        $dateMax = $ownerRecord->getDateMax();
                        $listaPropro = isset($ownerRecord->lista_propro) ? $ownerRecord->lista_propro : null;
                        $listaProproSup = isset($ownerRecord->lista_propro_sup) ? $ownerRecord->lista_propro_sup : null;
                        $noPosiz = method_exists($ownerRecord, 'getOption')
                            ? $ownerRecord->getOption('no_posiz')
                            : null;

                        $res = $record->gg([
                            'date_max' => $dateMax,
                            'lista_propro' => $listaPropro,
                            'lista_propro_sup' => $listaProproSup,
                            'no_posiz' => $noPosiz,
                        ]);

                        return is_numeric($res) ? (float) $res : 0.0;
                    }),
                TextColumn::make('_gg_cateco_posfun')
                    ->default(function ($record, $livewire): float {
                        // Type narrowing: ensure record is object with gg() method
                        if (! is_object($record) || ! method_exists($record, 'gg')) {
                            return 0.0;
                        }

                        // Type narrowing: ensure livewire is RelationManager
                        if (! is_object($livewire) || ! method_exists($livewire, 'getOwnerRecord')) {
                            return 0.0;
                        }

                        $ownerRecord = $livewire->getOwnerRecord();
                        if ($ownerRecord === null || ! is_object($ownerRecord) || ! method_exists($ownerRecord, 'getDateMax')) {
                            return 0.0;
                        }

                        $dateMax = $ownerRecord->getDateMax();
                        $listaPropro = isset($ownerRecord->lista_propro) ? $ownerRecord->lista_propro : null;
                        $listaProproSup = isset($ownerRecord->lista_propro_sup) ? $ownerRecord->lista_propro_sup : null;
                        $posfunVal = isset($ownerRecord->posfun_val) ? $ownerRecord->posfun_val : null;
                        $noPosiz = method_exists($ownerRecord, 'getOption')
                            ? $ownerRecord->getOption('no_posiz')
                            : null;

                        $res = $record->gg([
                            'date_max' => $dateMax,
                            'lista_propro' => $listaPropro,
                            'lista_propro_sup' => $listaProproSup,
                            'posfun' => $posfunVal,
                            'no_posiz' => $noPosiz,
                        ]);

                        return is_numeric($res) ? (float) $res : 0.0;
                    }),
            ])
            ->filters([
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
