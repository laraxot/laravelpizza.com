<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroAdmResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ptv\Actions\GetAllValutatoriOptions;
use Modules\Ptv\Filament\Forms\Components\PeriodoSection;
use Modules\Ptv\Filament\Forms\Components\WorkerSection;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class CondizioniLavoroAdmForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'lavoratore' => WorkerSection::make('lavoratore'),
            'periodo' => PeriodoSection::make('periodo')->add([
                'quadrimestre' => TextInput::make('quadrimestre'),
            ]),
            'valutatore_id' => Select::make('valutatore_id')
                ->options(function ($record) {
                    // Type narrowing: ensure record is object with anno property
                    if (! is_object($record) || ! isset($record->anno)) {
                        $anno = date('Y');
                    } else {
                        $anno = is_int($record->anno) || is_string($record->anno) ? $record->anno : date('Y');
                    }

                    return app(GetAllValutatoriOptions::class)->execute('IndennitaCondizioniLavoro', $anno);
                }),
            'indennitaTipoDettaglio' => Select::make('indennitaTipoDettaglio')
                ->multiple()
                ->relationship('indennitaTipoDettaglio', 'nome',
                    fn (Builder $query, Model $record) => $query->where('dal', '<=', $record->anno ?? date('Y'))->where('al', '>=', $record->anno ?? date('Y'))
                )
                ->getOptionLabelFromRecordUsing(function (Model $record): string {
                    // Type narrowing: ensure indennitaTipo exists and has nome
                    $indennitaTipo = isset($record->indennitaTipo) && is_object($record->indennitaTipo) ? $record->indennitaTipo : null;
                    $nome = ($indennitaTipo !== null && isset($indennitaTipo->nome) && is_string($indennitaTipo->nome)) ? $indennitaTipo->nome : '';

                    // Type narrowing: ensure record properties exist
                    $recordNome = isset($record->nome) && is_string($record->nome) ? $record->nome : '';
                    $dal = isset($record->dal) ? (string) $record->dal : '';
                    $al = isset($record->al) ? (string) $record->al : '';

                    return sprintf('[%s] %s %s %s', $nome, $recordNome, $dal, $al);
                }),
        ];
    }
}
