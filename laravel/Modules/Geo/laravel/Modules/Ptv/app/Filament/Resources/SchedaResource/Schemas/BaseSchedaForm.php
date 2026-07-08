<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Ptv\Actions\CriteriEsclusione\Check;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Xot\Filament\Actions\Form\FieldRefreshAction;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Form scheda condiviso tra moduli che estendono BaseSchedaResource.
 *
 * Le classi concrete nel modulo figlio estendono questa base e sovrascrivono
 * getFormSchema() quando l'UI differisce (es. Progressioni).
 */
abstract class BaseSchedaForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),

            'diritto_section' => Section::make('diritto')
                ->headerActions([
                    Action::make('refresh')
                        ->label('')
                        ->tooltip('ricalcola')
                        ->icon('heroicon-o-arrow-path')
                        ->action(function (SchedaContract $record): void {
                            $criteriEsclusione = $record->criteriEsclusione;
                            if ($criteriEsclusione === null) {
                                return;
                            }

                            /** @var \Illuminate\Support\Collection<int, \Modules\Ptv\Models\Contracts\CriteriEsclusioneContract> $validatedCriteriEsclusione */
                            $validatedCriteriEsclusione = $criteriEsclusione->where('value', '!=', 0);
                            if (! $record instanceof Model || ! method_exists($record, 'getCriteriOptions')) {
                                return;
                            }

                            $validatedCriteriOption = $record->getCriteriOptions();
                            if (! $validatedCriteriOption instanceof Collection) {
                                return;
                            }

                            app(Check::class)->execute($record, $validatedCriteriEsclusione, $validatedCriteriOption);
                        }),
                ])
                ->schema([
                    'ha_diritto' => Toggle::make('ha_diritto'),
                    'motivo' => Textarea::make('motivo')->columnSpan(3),
                ])
                ->columns(4),

            'lavoratore_section' => Section::make('lavoratore')->schema([
                'matr' => TextInput::make('matr'),
                'cognome' => TextInput::make('cognome'),
                'nome' => TextInput::make('nome'),
                'email' => TextInput::make('email'),
            ])->columns(4),

            'qua_section' => Section::make('qua')->schema([
                'propro' => TextInput::make('propro'),
                'posfun' => TextInput::make('posfun'),
                'posiz' => TextInput::make('posiz'),
                'posiz_txt' => TextInput::make('posiz_txt'),
                'disci1' => TextInput::make('disci1'),
                'disci1_txt' => TextInput::make('disci1_txt'),
            ])->columns(5),

            'rep_section' => Section::make('rep')->schema([
                'stabi' => TextInput::make('stabi'),
                'stabi_txt' => TextInput::make('stabi_txt'),
                'repar' => TextInput::make('repar'),
                'repar_txt' => TextInput::make('repar_txt'),
            ])->columns(2),

            'periodo_section' => Section::make('periodo')->schema([
                'dal' => TextInput::make('dal'),
                'al' => TextInput::make('al'),
                'anno' => TextInput::make('anno'),
            ])->columns(4),

            'assenze_section' => Section::make('assenze')->schema([
                'gg_presenza_dalal' => TextInput::make('gg_presenza_dalal')
                    ->suffixAction(FieldRefreshAction::make('gg_presenza_dalal')),
                'gg_assenza_dalal' => TextInput::make('gg_assenza_dalal')
                    ->suffixAction(FieldRefreshAction::make('gg_assenza_dalal')),
                'hh_assenza_dalal' => TextInput::make('hh_assenza_dalal')
                    ->suffixAction(FieldRefreshAction::make('hh_assenza_dalal')),

            ])->columns(4),
            // 'criteri_section' => Section::make('criteri')->schema(fn($record)=>static::getFormSchemaCriteri($record))->columns(4),
        ];
    }
}
