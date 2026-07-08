<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Ptv\Actions\CriteriEsclusione\Check;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\CompilaScheda;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Ptv\Models\Scheda;
use Modules\Xot\Filament\Actions\Form\FieldRefreshAction;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

abstract class BaseSchedaResource extends XotBaseResource
{
    // protected static ?string $model = Scheda::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        $schema = [
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

        return $schema;
    }

    /**
     * @return array<string, \Filament\Forms\Components\TextInput>
     */
    public static function getFormSchemaCriteri(SchedaContract $record): array
    {
        $schema = [];

        $criteriEsclusione = $record->criteriEsclusione;
        if ($criteriEsclusione === null) {
            return $schema;
        }

        $fields = $criteriEsclusione->where('field_name', '!=', '')->pluck('field_name')->unique()->toArray();
        foreach ($fields as $field) {
            if (! is_string($field) || $field === '') {
                continue;
            }

            $schema[$field] = TextInput::make($field)
                ->suffixAction(FieldRefreshAction::make($field));
            // 'propro' => TextInput::make('propro')
            //        ->suffixAction(FieldRefreshAction::make('propro')),
        }

        return $schema;
    }

    /**
     * @return array<string, RelationManager>
     */
    #[Override]
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
            'compila' => CompilaScheda::route('/{record}/compila'),
        ];
    }

    /**
     * @return class-string<Model>
     */
    public static function getModel(): string
    {
        return parent::getModel();
    }
}
