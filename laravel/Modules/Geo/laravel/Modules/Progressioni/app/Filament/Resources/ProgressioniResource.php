<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Arr;
use Modules\Performance\Actions\HasExcellenceByYearAction;
use Modules\Progressioni\Filament\Resources\ProgressioniResource\Pages\ListSchedaLogActivities;
use Modules\Progressioni\Models\Progressioni;
use Modules\Progressioni\Models\SchedaCriteri;
use Modules\Ptv\Actions\GetValutatoriOptions;
use Modules\Ptv\Filament\Fields\ValutatoreField;
use Modules\Ptv\Filament\Resources\AnagResource\RelationManagers as PtvRelationManagers;
use Modules\Xot\Filament\Actions\Form\FieldRefreshAction;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class ProgressioniResource extends XotBaseResource
{
    protected static ?string $model = Progressioni::class;

    /**
     * @param array<string, mixed> $filters
     * @return array<int, string>
     */
    public static function getXlsFields(array $filters = []): array
    {
        /** @var array<int, string> $fields */
        $fields = [
            'id',
            'ha_diritto',
            'motivo',
            // ------------------------------------
            'ente',
            'matr',
            'cognome',
            'nome',
            'eta',
            'excellences_count_last_3_years',
            'gg_integ_params',
            // ---------------------------------
            'stabi',
            'stabi_txt',
            'repar',
            'repar_txt',
            // --------------------------------
            'qua2kd',
            'qua2ka',
            'propro',
            'posfun',
            'categoria_eco',
            'posiz',
            'posiz_txt',
            'disci1',
            'disci1_txt',
            // -------------------------------------
            'dal',
            'al',
            // 'gg_no_asz',
            // 'gg_cateco_posfun_no_asz',
            // 'gg_cateco_no_posfun_no_asz',
            'perf_ind_media',
            'gg_integ_params',
            'gg_in_sede',
            'gg_fuori_sede',
            'gg_cateco_in_sede',
            'gg_cateco_fuori_sede',
            'gg_cateco_posfun_in_sede',
            'gg_cateco_posfun_fuori_sede',
            'gg_asz_in_sede',
            'gg_asz_fuori_sede',
            'gg_asz_cateco_in_sede',
            'gg_asz_cateco_fuori_sede',
            'gg_asz_cateco_posfun_in_sede',
            'gg_asz_cateco_posfun_fuori_sede',
        ];

        /*
        $year = Arr::get($filters, 'anno.value');

        $rows = SchedaCriteri::where('anno', $year)->get();
        foreach ($rows as $row) {
            $fields[] = $row->field_name;
        }
        */

        return array_values(array_unique($fields));
    }

    /**
     * @return array<string, Component>
    */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),

            'diritto' => Section::make('diritto')
                ->headerActions([
                    /*
                        Action::make('refresh')
                            ->label('')
                            ->tooltip('ricalcola')
                            ->icon('heroicon-o-arrow-path')
                            ->action(function ($record) {
                                // ...
                                // dddx($record);
                            }),
                        */
                ])
                ->schema([
                    // TextInput::make('ha_diritto')->columnSpan(1),
                    'ha_diritto' => Toggle::make('ha_diritto'),
                    'motivo' => Textarea::make('motivo')->columnSpan(3),
                ])
                ->columns(4),

            'lavoratore' => Section::make('lavoratore')->schema([
                'matr' => TextInput::make('matr'),
                'cognome' => TextInput::make('cognome'),
                'nome' => TextInput::make('nome'),
                'email' => TextInput::make('email'),
            ])->columns(4),
            'qua' => Section::make('qua')->schema([
                'propro' => TextInput::make('propro')
                    ->suffixAction(FieldRefreshAction::make('propro')),
                'posfun' => TextInput::make('posfun'),
                'posiz' => TextInput::make('posiz'),
                'posiz_txt' => TextInput::make('posiz_txt'),
                'categoria_eco' => TextInput::make('categoria_eco'),
                'categoria_ecoval' => TextInput::make('categoria_ecoval'),
                'posfunval' => TextInput::make('posfunval'),
                'disci1' => TextInput::make('disci1'),
                'disci1_txt' => TextInput::make('disci1_txt'),
            ])->columns(5),
            'rep' => Section::make('rep')->schema([
                'stabi' => TextInput::make('stabi'),
                'stabi_txt' => TextInput::make('stabi_txt'),
                'repar' => TextInput::make('repar'),
                'repar_txt' => TextInput::make('repar_txt'),
            ])->columns(2),
            'periodo' => Section::make('periodo')->schema([
                'dal' => TextInput::make('dal'),
                'al' => TextInput::make('al'),
                'anno' => TextInput::make('anno'),
            ])->columns(4),
            // ValutatoreField::make('valutatore_id'),
            'valutatore_id' => Select::make('valutatore_id')->options(
                function (Progressioni $record): array {
                    /** @var int|string|null $anno */
                    $anno = $record->anno;

                    return app(GetValutatoriOptions::class)->execute('Progressioni', $anno);
                }
            ),
            'excellences' => Section::make('excellences')->schema([
                'excellences_'.(intval(date('Y')) - 0) => Toggle::make('excellences_'.(intval(date('Y')) - 0))
                    ->disabled()
                    // ->default(fn ($record) => dddx($record))
                    ->formatStateUsing(fn (?string $state, Progressioni $record): bool => app(HasExcellenceByYearAction::class)->execute($record, intval(date('Y')) - 0)),
                'excellences_'.(intval(date('Y')) - 1) => Toggle::make('excellences_'.(intval(date('Y')) - 1))
                    ->disabled()
                    ->formatStateUsing(fn (?string $state, Progressioni $record): bool => app(HasExcellenceByYearAction::class)->execute($record, intval(date('Y')) - 1)),
                'excellences_'.(intval(date('Y')) - 2) => Toggle::make('excellences_'.(intval(date('Y')) - 2))
                    ->disabled()
                    ->formatStateUsing(fn (?string $state, Progressioni $record): bool => app(HasExcellenceByYearAction::class)->execute($record, intval(date('Y')) - 2)),
                'excellences_'.(intval(date('Y')) - 3) => Toggle::make('excellences_'.(intval(date('Y')) - 3))
                    ->disabled()
                    ->formatStateUsing(fn (?string $state, Progressioni $record): bool => app(HasExcellenceByYearAction::class)->execute($record, intval(date('Y')) - 3)),
                'excellences_'.(intval(date('Y')) - 4) => Toggle::make('excellences_'.(intval(date('Y')) - 4))
                    ->disabled()
                    ->formatStateUsing(fn (?string $state, Progressioni $record): bool => app(HasExcellenceByYearAction::class)->execute($record, intval(date('Y')) - 4)),
                'excellences_'.(intval(date('Y')) - 5) => Toggle::make('excellences_'.(intval(date('Y')) - 5))
                    ->disabled()
                    ->formatStateUsing(fn (?string $state, Progressioni $record): bool => app(HasExcellenceByYearAction::class)->execute($record, intval(date('Y')) - 5)),
                'excellences_'.(intval(date('Y')) - 6) => Toggle::make('excellences_'.(intval(date('Y')) - 6))
                    ->disabled()
                    ->formatStateUsing(fn (?string $state, Progressioni $record): bool => app(HasExcellenceByYearAction::class)->execute($record, intval(date('Y')) - 6)),
                'excellences_count_last_3_years' => TextInput::make('excellences_count_last_3_years')
                    ->formatStateUsing(function (?string $state, Progressioni $record): int|string|null {
                        /** @var int|string|null $count */
                        $count = $record->excellences_count_last_3_years;

                        return $count;
                    }),
            ])->columns(4),

            'performance' => Section::make('performance')->schema([
                'perf_ind_'.(intval(date('Y')) - 0) => TextInput::make('perf_ind_'.(intval(date('Y')) - 0))->numeric(),
                'perf_ind_'.(intval(date('Y')) - 1) => TextInput::make('perf_ind_'.(intval(date('Y')) - 1))->numeric(),
                'perf_ind_'.(intval(date('Y')) - 2) => TextInput::make('perf_ind_'.(intval(date('Y')) - 2))->numeric(),
                'perf_ind_'.(intval(date('Y')) - 3) => TextInput::make('perf_ind_'.(intval(date('Y')) - 3))->numeric(),
                'perf_ind_'.(intval(date('Y')) - 4) => TextInput::make('perf_ind_'.(intval(date('Y')) - 4))->numeric(),
                'perf_ind_'.(intval(date('Y')) - 5) => TextInput::make('perf_ind_'.(intval(date('Y')) - 5))->numeric(),
                'perf_ind_'.(intval(date('Y')) - 6) => TextInput::make('perf_ind_'.(intval(date('Y')) - 6))->numeric(),
                'perf_ind_media' => TextInput::make('perf_ind_media')->numeric(),
            ])->columns(4),

            '_gg' => Section::make('_gg')->schema([
                'gg_cateco_in_sede' => TextInput::make('gg_cateco_in_sede')
                    ->suffixAction(FieldRefreshAction::make('gg_cateco_in_sede')),
                'gg_cateco_fuori_sede' => TextInput::make('gg_cateco_fuori_sede')
                    ->suffixAction(FieldRefreshAction::make('gg_cateco_fuori_sede')),
                'gg_cateco' => TextInput::make('gg_cateco')
                    ->suffixAction(FieldRefreshAction::make('gg_cateco')),
                // ---------------------------------------------------
                'gg_cateco_posfun_in_sede' => TextInput::make('gg_cateco_posfun_in_sede')
                    ->suffixAction(FieldRefreshAction::make('gg_cateco_posfun_in_sede')),
                'gg_cateco_posfun_fuori_sede' => TextInput::make('gg_cateco_posfun_fuori_sede')
                    ->suffixAction(FieldRefreshAction::make('gg_cateco_posfun_fuori_sede')),
                'gg_cateco_posfun' => TextInput::make('gg_cateco_posfun')
                    ->suffixAction(FieldRefreshAction::make('gg_cateco_posfun')),
                // -----------------------------------------------------
                // TextInput::make('gg_cateco_posfun_no_asz_in_sede'),
                // TextInput::make('gg_cateco_posfun_no_asz_fuori_sede'),
                'gg_asz_cateco_posfun_in_sede' => TextInput::make('gg_asz_cateco_posfun_in_sede')
                    ->suffixAction(FieldRefreshAction::make('gg_asz_cateco_posfun_in_sede')),
                'gg_asz_cateco_posfun_fuori_sede' => TextInput::make('gg_asz_cateco_posfun_fuori_sede')
                    ->suffixAction(FieldRefreshAction::make('gg_asz_cateco_posfun_fuori_sede')),
                'gg_cateco_posfun_no_asz' => TextInput::make('gg_cateco_posfun_no_asz')
                    ->suffixAction(FieldRefreshAction::make('gg_cateco_posfun_no_asz')),

                'gg_integ_params' => TextInput::make('gg_integ_params')
                    ->suffixAction(FieldRefreshAction::make('gg_integ_params')),
            ])->columns(3),
        ];
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         PtvRelationManagers\Qua00fRelationManager::class,
    //         PtvRelationManagers\Qua03fRelationManager::class,
    //         PtvRelationManagers\AszEffRelationManager::class,
    //     ];
    // }
    #[Override]
    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
            'log-activity' => ListSchedaLogActivities::route('/{record}/log-activity'),
        ];
    }
}
