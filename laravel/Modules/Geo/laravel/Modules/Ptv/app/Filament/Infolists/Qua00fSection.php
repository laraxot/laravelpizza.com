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
use Illuminate\Database\Eloquent\Model;

class Qua00fSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'qua00f';
    }

    // non viene chiamato
    // public function mount(Model $record):void {
    //    dddx($record);
    // }

    protected function setUp(): void
    {
        parent::setUp();
        /*
        dddx([
            get_class_methods($this),
           // 'container'=>$this->getContainer(),
           'getRecord'=>$this->getRecord(),
            ]);
            */
        $this->schema([
            RepeatableEntry::make('qua00f')
                ->schema([
                    TextEntry::make('id'),
                    TextEntry::make('matr'),
                    TextEntry::make('propro'),
                    TextEntry::make('posfun'),
                    TextEntry::make('posiz'),
                    TextEntry::make('categoria_eco'),
                    TextEntry::make('qua2kd'),
                    TextEntry::make('qua2ka'),
                    // Components\TextEntry::make('quaann'),
                    // Components\TextEntry::make('gg'),
                    // Components\TextEntry::make('asz_txt')->,
                    // ->columnSpan(2),
                    // Components\TextEntry::make('_gg1')->default(fn()=>dddx($this->getRecord()->posfun_val)),

                    TextEntry::make('_gg')
                        ->default(function ($record): int {
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0;
                            }
                            $ownerRecord = $this->getRecord();
                            $dateMax = ($ownerRecord !== null && is_object($ownerRecord) && method_exists($ownerRecord, 'getDateMax'))
                                ? $ownerRecord->getDateMax()
                                : null;
                            $result = $record->gg(['date_max' => $dateMax]);

                            return is_numeric($result) ? (int) $result : 0;
                        }),

                    TextEntry::make('_gg_cateco')
                        ->default(function ($record): int {
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0;
                            }
                            $ownerRecord = $this->getRecord();
                            // Type narrowing: ensure ownerRecord is object before method_exists
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

                            return is_numeric($res) ? (int) $res : 0;
                        }),

                    TextEntry::make('_gg_cateco_posfun')
                        ->default(function ($record): int {
                            if (! is_object($record) || ! method_exists($record, 'gg')) {
                                return 0;
                            }
                            $ownerRecord = $this->getRecord();
                            // Type narrowing: ensure ownerRecord is object before method_exists
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

                            return is_numeric($res) ? (int) $res : 0;
                        }),

                ])
                ->columns(11),
        ]);
    }
}
