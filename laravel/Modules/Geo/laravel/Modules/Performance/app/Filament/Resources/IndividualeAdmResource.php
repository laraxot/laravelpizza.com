<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\Performance\Models\IndividualeAdm;
use Modules\Ptv\Filament\Resources\BaseSchedaResource;
use Override;

use function Safe\date;

class IndividualeAdmResource extends BaseSchedaResource
{
    protected static ?string $model = IndividualeAdm::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'type' => TextInput::make('type')
                ->maxLength(50),
            'post_type' => TextInput::make('post_type')
                ->maxLength(50),
            'ente' => TextInput::make('ente')
                ->required()
                ->numeric()
                ->default(0),
            'matr' => TextInput::make('matr')
                ->numeric(),
            'cognome' => TextInput::make('cognome')
                ->maxLength(250),
            'nome' => TextInput::make('nome')
                ->maxLength(250),
            'email' => TextInput::make('email')
                ->email()
                ->maxLength(250),
            'stabi' => TextInput::make('stabi')
                ->numeric(),
            'repar' => TextInput::make('repar')
                ->numeric(),
            'stabival' => TextInput::make('stabival')
                ->numeric(),
            'reparval' => TextInput::make('reparval')
                ->numeric(),
            'stabi_txt' => TextInput::make('stabi_txt')
                ->maxLength(250),
            'repar_txt' => TextInput::make('repar_txt')
                ->maxLength(250),
            'disci' => TextInput::make('disci')
                ->numeric(),
            'disci_txt' => TextInput::make('disci_txt')
                ->maxLength(100),
            'rep2kd' => TextInput::make('rep2kd')
                ->numeric(),
            'rep2ka' => TextInput::make('rep2ka')
                ->numeric(),
            'posiz' => TextInput::make('posiz')
                ->numeric(),
            'propro' => TextInput::make('propro')
                ->numeric(),
            'posfun' => TextInput::make('posfun')
                ->numeric(),
            'categoria_eco' => TextInput::make('categoria_eco')
                ->maxLength(50),
            'qua2kd' => TextInput::make('qua2kd')
                ->numeric(),
            'qua2ka' => TextInput::make('qua2ka')
                ->numeric(),
            'dal' => TextInput::make('dal')
                ->numeric(),
            'al' => TextInput::make('al')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric()
                ->default(date('Y')),
            'giornitempodet' => TextInput::make('giornitempodet')
                ->numeric(),
            'ha_diritto' => TextInput::make('ha_diritto')
                ->numeric(),
            'motivo' => TextInput::make('motivo')
                ->maxLength(250),
            'esperienza_acquisita' => TextInput::make('esperienza_acquisita')
                ->numeric(),
            'risultati_ottenuti' => TextInput::make('risultati_ottenuti')
                ->numeric(),
            'arricchimento_professionale' => TextInput::make('arricchimento_professionale')
                ->numeric(),
            'impegno' => TextInput::make('impegno')
                ->numeric(),
            'qualita_prestazione' => TextInput::make('qualita_prestazione')
                ->numeric(),
            'totale_punteggio' => TextInput::make('totale_punteggio')
                ->numeric(),
            'lista_auth' => TextInput::make('lista_auth')
                ->maxLength(250),
            'peso_esperienza_acquisita' => TextInput::make('peso_esperienza_acquisita')
                ->numeric(),
            'peso_risultati_ottenuti' => TextInput::make('peso_risultati_ottenuti')
                ->numeric(),
            'peso_arricchimento_professionale' => TextInput::make('peso_arricchimento_professionale')
                ->numeric(),
            'peso_impegno' => TextInput::make('peso_impegno')
                ->numeric(),
            'peso_qualita_prestazione' => TextInput::make('peso_qualita_prestazione')
                ->numeric(),
            'datemod' => DateTimePicker::make('datemod'),
            'note' => Textarea::make('note')
                ->columnSpanFull(),
            'oree' => TextInput::make('oree')
                ->numeric(),
            'oret' => TextInput::make('oret')
                ->numeric(),
            'perc_parttime' => TextInput::make('perc_parttime')
                ->numeric(),
            'perc_parttimepond' => TextInput::make('perc_parttimepond')
                ->numeric(),
            'gg_parttimevert' => TextInput::make('gg_parttimevert')
                ->numeric(),
            'ore_assenza' => TextInput::make('ore_assenza')
                ->numeric(),
            'giorni_assenza' => TextInput::make('giorni_assenza')
                ->numeric(),
            'giorni_presenza' => TextInput::make('giorni_presenza')
                ->numeric(),
            'categ_coeff' => TextInput::make('categ_coeff')
                ->numeric(),
            'quota_teorica' => TextInput::make('quota_teorica')
                ->numeric(),
            'budget_assegnato' => TextInput::make('budget_assegnato')
                ->numeric(),
            'quota_effettiva' => TextInput::make('quota_effettiva')
                ->numeric(),
            'resti' => TextInput::make('resti')
                ->numeric(),
            'resti_pond' => TextInput::make('resti_pond')
                ->numeric(),
            'importo_totale' => TextInput::make('importo_totale')
                ->numeric(),
            'gg_totale_sigma' => TextInput::make('gg_totale_sigma')
                ->numeric(),
            'gg_validi_sigma' => TextInput::make('gg_validi_sigma')
                ->numeric(),
            'gg_assenz_sigma' => TextInput::make('gg_assenz_sigma')
                ->numeric(),
            'decurtazione_perc' => TextInput::make('decurtazione_perc')
                ->numeric(),
            'gg_tempo_determinato' => TextInput::make('gg_tempo_determinato')
                ->numeric(),
            'gg_posiz_1_in_sede' => TextInput::make('gg_posiz_1_in_sede')
                ->numeric(),
            'gg_assenza_anno' => TextInput::make('gg_assenza_anno')
                ->numeric(),
            'gg_presenza_anno' => TextInput::make('gg_presenza_anno')
                ->numeric(),
            'ore_assenza_anno' => TextInput::make('ore_assenza_anno')
                ->numeric(),
            'posiz_txt' => TextInput::make('posiz_txt')
                ->maxLength(255),
            'clafun' => TextInput::make('clafun')
                ->numeric(),
            'disci1' => TextInput::make('disci1')
                ->numeric(),
            'disci1_txt' => TextInput::make('disci1_txt')
                ->maxLength(255),
            'gg_ruolo' => TextInput::make('gg_ruolo')
                ->numeric(),
            'last_data_assunz' => TextInput::make('last_data_assunz')
                ->numeric(),
            'perc_parttime_anno' => TextInput::make('perc_parttime_anno')
                ->numeric(),
            'perc_parttime_dalal' => TextInput::make('perc_parttime_dalal')
                ->numeric(),
            'gg_parttimevert_anno' => TextInput::make('gg_parttimevert_anno')
                ->numeric(),
            'gg_parttimevert_dalal' => TextInput::make('gg_parttimevert_dalal')
                ->numeric(),
            'perc_parttimepond_anno' => TextInput::make('perc_parttimepond_anno')
                ->numeric(),
            'perc_parttimepond_dalal' => TextInput::make('perc_parttimepond_dalal')
                ->numeric(),
            'gg_presenza_dalal' => TextInput::make('gg_presenza_dalal')
                ->numeric(),
            'gg_assenza_dalal' => TextInput::make('gg_assenza_dalal')
                ->numeric(),
            'hh_assenza_anno' => TextInput::make('hh_assenza_anno')
                ->numeric(),
            'hh_assenza_dalal' => TextInput::make('hh_assenza_dalal')
                ->numeric(),
            'lang' => TextInput::make('lang')
                ->maxLength(3),
            'excellence' => Toggle::make('excellence'),
            'codqua' => TextInput::make('codqua')
                ->numeric(),
            'cont' => TextInput::make('cont')
                ->numeric(),
            'tipco' => TextInput::make('tipco')
                ->numeric(),
            'posizione_eco' => TextInput::make('posizione_eco')
                ->maxLength(191),
            'gg_anno' => TextInput::make('gg_anno')
                ->required()
                ->numeric(),
            'created_by' => TextInput::make('created_by')
                ->maxLength(50)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),

        ];
    }

    /** @return array<int, string> */
    public static function getXlsFields(): array
    {
        return [
            'id',
            'matr',
            'cognome',
            'nome',
            'email',
            'dal',
            'al',
            'anno',
            'ha_diritto',
            'perc_parttimepond_dalal',
            'gg_presenza_dalal',
            'gg_assenza_dalal',
            'hh_assenza_dalal',
            'totale_punteggio',
            'quota_teorica',
            'budget_assegnato',
            'quota_effettiva',
            'resti',
            'resti_pond',
            'importo_totale',
        ];
    }
}
