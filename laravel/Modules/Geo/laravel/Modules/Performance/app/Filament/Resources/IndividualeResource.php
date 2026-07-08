<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\CreateIndividuale;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\EditIndividuale;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\FillOutTheForm;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\ListIndividuales;
use Modules\Performance\Models\CriteriValutazione;
use Modules\Performance\Models\Individuale;
use Modules\Ptv\Filament\Resources\BaseSchedaResource;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\CompilaScheda;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;
use ReflectionClass;
use Webmozart\Assert\Assert;

use function Safe\date;

class IndividualeResource extends BaseSchedaResource
{
    protected static ?string $model = Individuale::class;

    #[Override]
    public static function getNavigationBadge(): ?string
    {
        return null;
    }

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            ...parent::getFormSchema(),
            /*
            'id' => TextInput::make('id')->disabled(),

            'diritto_section' => Section::make('diritto')
                ->headerActions([
                    Action::make('refresh')
                        ->label('')
                        ->tooltip('ricalcola')
                        ->icon('heroicon-o-arrow-path')
                        ->action(function ($record) {
                            dddx($record);
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
                'gg_assenza_dalal' => TextInput::make('gg_assenza_dalal'),
                'hh_assenza_dalal' => TextInput::make('hh_assenza_dalal'),
            ])->columns(4),
            */
        ];
    }

  
    public static function getPages(): array
    {

        return [
            ...parent::getPages(),
            'fill_out_the_form' => FillOutTheForm::route('/{record}/fill'),
            'compila' => CompilaScheda::route('/{record}/compila'),
        ];
    }

    /**
     * @param array{stabi_repar_anno?: array{anno?: int|string}} $data
     * @return list<string|null>
     */
    public static function getXlsFields(array $data): array
    {
        $anno = Arr::get($data, 'stabi_repar_anno.anno', intval(date('Y')) - 1);
        $criteri = CriteriValutazione::where('anno', $anno)
            ->where('post_type', 'po')
            ->orderBy('posizione')
            ->get();

        $fields = [
            'id',
            'matr',
            'cognome',
            'nome',
            'type',
            'email',
            'dal',
            'al',
            'anno',
            'ha_diritto',
            'valutatore_id',
            'perc_parttimepond_dalal',
            'gg_presenza_dalal',
            'gg_assenza_dalal',
            'hh_assenza_dalal',
            'quota_teorica',
            'budget_assegnato',
            'quota_effettiva',
            'resti',
            'resti_pond',
            'importo_totale',
        ];
        $transKey = app(GetTransKeyAction::class)->execute(static::class);
        $trans = trans($transKey);

        foreach ($criteri as $criterio) {
            $nome = $criterio->nome;
            if (! is_string($nome) || $nome === '') {
                continue;
            }

            $fields[] = $nome;
            Arr::set($trans, 'fields.'.$nome, $criterio->label);
        }
        app(SaveTransAction::class)->execute($transKey, $trans);
        $fields[] = 'excellence';
        $fields[] = 'totale_punteggio';

        return $fields;
    }


    

}
