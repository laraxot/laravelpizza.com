<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Ptv\Filament\Infolists;

use Filament\Infolists\Components;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

class AszEffSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'asz_eff';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            RepeatableEntry::make('aszEff')
                ->schema([
                    TextEntry::make('id'),
                    TextEntry::make('matr'),
                    TextEntry::make('tip-cod')
                        ->default(function ($record): string {
                            if (! is_object($record)) {
                                return '';
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
                    TextEntry::make('ini-fin')
                        ->default(function ($record): string {
                            if (! is_object($record)) {
                                return '';
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
                    TextEntry::make('asz2kd'),
                    TextEntry::make('asz2ka'),
                    TextEntry::make('aszumi'),
                    TextEntry::make('aszdur'),
                    // Components\TextEntry::make('aszann'),
                    // Components\TextEntry::make('asz_txt')->,
                    // ->columnSpan(2),
                    TextEntry::make('propro')
                    // ->default(fn($record)=>$record->propro)
                    ,
                    TextEntry::make('posfun'),

                    TextEntry::make('_gg')
                        ->default(function ($record): float {
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0.0;
                            }
                            $ownerRecord = $this->getRecord();
                            $dateMax = ($ownerRecord !== null && is_object($ownerRecord) && method_exists($ownerRecord, 'getDateMax'))
                                ? $ownerRecord->getDateMax()
                                : null;
                            $result = $record->gg(['date_max' => $dateMax]);

                            return is_numeric($result) ? (float) $result : 0.0;
                        }),

                    TextEntry::make('_gg_cateco')
                        ->default(function ($record): float {
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0.0;
                            }
                            $ownerRecord = $this->getRecord();
                            $dateMax = ($ownerRecord !== null && is_object($ownerRecord) && method_exists($ownerRecord, 'getDateMax'))
                                ? $ownerRecord->getDateMax()
                                : null;
                            $listaPropro = ($ownerRecord !== null && is_object($ownerRecord) && isset($ownerRecord->lista_propro))
                                ? $ownerRecord->lista_propro
                                : null;
                            $listaProproSup = ($ownerRecord !== null && is_object($ownerRecord) && isset($ownerRecord->lista_propro_sup))
                                ? $ownerRecord->lista_propro_sup
                                : null;
                            $res = $record->gg([
                                'date_max' => $dateMax,
                                'lista_propro' => $listaPropro,
                                'lista_propro_sup' => $listaProproSup,
                            ]);

                            return is_numeric($res) ? (float) $res : 0.0;
                        }),

                    TextEntry::make('_gg_cateco_posfun')
                        ->default(function ($record): float {
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0.0;
                            }
                            $ownerRecord = $this->getRecord();
                            if ($ownerRecord === null || ! is_object($ownerRecord)) {
                                return 0.0;
                            }
                            $dateMax = method_exists($ownerRecord, 'getDateMax')
                                ? $ownerRecord->getDateMax()
                                : null;
                            $listaPropro = isset($ownerRecord->lista_propro) ? $ownerRecord->lista_propro : null;
                            $listaProproSup = isset($ownerRecord->lista_propro_sup) ? $ownerRecord->lista_propro_sup : null;
                            $posfunVal = isset($ownerRecord->posfun_val) ? $ownerRecord->posfun_val : null;
                            $res = $record->gg([
                                'date_max' => $dateMax,
                                'lista_propro' => $listaPropro,
                                'lista_propro_sup' => $listaProproSup,
                                'posfun' => $posfunVal,
                            ]);

                            return is_numeric($res) ? (float) $res : 0.0;
                        }),
                ])
                ->columns(15),
        ]);
    }
}
