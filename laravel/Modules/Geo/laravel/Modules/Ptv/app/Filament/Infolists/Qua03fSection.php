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

class Qua03fSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'qua03f';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            RepeatableEntry::make('qua03f')
                ->schema([
                    TextEntry::make('id'),
                    TextEntry::make('matr'),
                    TextEntry::make('q3pro'),
                    TextEntry::make('q3fun'),
                    TextEntry::make('q3tipo'),
                    TextEntry::make('q3desc'),
                    TextEntry::make('q32kd'),
                    TextEntry::make('q32ka'),
                    // Components\TextEntry::make('q3ann'),
                    // Components\TextEntry::make('_gg')
                    //    ->default(fn($record)=>($record->gg([]))),
                    // Components\TextEntry::make('asz_txt')->,
                    // ->columnSpan(2),
                    TextEntry::make('_gg')
                        ->default(function ($record): int {
                            // Type narrowing: ensure record is object with gg() method
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0;
                            }

                            $ownerRecord = $this->getRecord();
                            if ($ownerRecord === null || ! is_object($ownerRecord)) {
                                return 0;
                            }

                            $dateMax = method_exists($ownerRecord, 'getDateMax')
                                ? $ownerRecord->getDateMax()
                                : null;

                            $result = $record->gg(['date_max' => $dateMax]);

                            return is_numeric($result) ? (int) $result : 0;
                        }),

                    TextEntry::make('_gg_cateco')
                        ->default(function ($record): int {
                            // Type narrowing: ensure record is object with gg() method
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0;
                            }

                            $ownerRecord = $this->getRecord();
                            if ($ownerRecord === null || ! is_object($ownerRecord)) {
                                return 0;
                            }

                            $dateMax = method_exists($ownerRecord, 'getDateMax')
                                ? $ownerRecord->getDateMax()
                                : null;
                            $listaPropro = isset($ownerRecord->lista_propro) ? $ownerRecord->lista_propro : null;
                            $listaProproSup = isset($ownerRecord->lista_propro_sup) ? $ownerRecord->lista_propro_sup : null;

                            $res = $record->gg([
                                'date_max' => $dateMax,
                                'lista_propro' => $listaPropro,
                                'lista_propro_sup' => $listaProproSup,
                            ]);

                            return is_int($res) ? $res : 0;
                        }),

                    TextEntry::make('_gg_cateco_posfun')
                        ->default(function ($record): int {
                            // Type narrowing: ensure record is object with gg() method
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0;
                            }

                            $ownerRecord = $this->getRecord();
                            if ($ownerRecord === null || ! is_object($ownerRecord)) {
                                return 0;
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

                            return is_int($res) ? $res : 0;
                        }),
                ])
                ->columns(11),
        ]);
    }
}
