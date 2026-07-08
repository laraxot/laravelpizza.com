<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\CriteriValutazioneResource\Pages\CreateCriteriValutazione;
use Modules\Progressioni\Filament\Resources\CriteriValutazioneResource\Pages\EditCriteriValutazione;
use Modules\Progressioni\Filament\Resources\CriteriValutazioneResource\Pages\ListCriteriValutaziones;
use Modules\Progressioni\Models\CriteriValutazione;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class CriteriValutazioneResource extends XotBaseResource
{
    protected static ?string $model = CriteriValutazione::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'ente' => TextInput::make('ente'),
            'matr' => TextInput::make('matr'),
            'cognome' => TextInput::make('cognome'),
            'nome' => TextInput::make('nome'),
            'stabi' => TextInput::make('stabi'),
            'stabi_txt' => TextInput::make('stabi_txt'),
            'repar' => TextInput::make('repar'),
            'repar_txt' => TextInput::make('repar_txt'),
            'qua2kd' => TextInput::make('qua2kd'),
            'qua2ka' => TextInput::make('qua2ka'),
            'propro' => TextInput::make('propro'),
            'posfun' => TextInput::make('posfun'),
            'categoria_eco' => TextInput::make('categoria_eco'),
            'posiz' => TextInput::make('posiz'),
            'posiz_txt' => TextInput::make('posiz_txt'),
            'disci1' => TextInput::make('disci1'),
            'disci1_txt' => TextInput::make('disci1_txt'),
            'dal' => TextInput::make('dal'),
            'al' => TextInput::make('al'),
            'gg_no_asz' => TextInput::make('gg_no_asz'),
            'gg_cateco_posfun_no_asz' => TextInput::make('gg_cateco_posfun_no_asz'),
            'gg_cateco_no_posfun_no_asz' => TextInput::make('gg_cateco_no_posfun_no_asz'),
            'gg_in_sede' => TextInput::make('gg_in_sede'),
            'gg_fuori_sede' => TextInput::make('gg_fuori_sede'),
            'gg_cateco_in_sede' => TextInput::make('gg_cateco_in_sede'),
            'gg_cateco_fuori_sede' => TextInput::make('gg_cateco_fuori_sede'),
            'gg_cateco_posfun_in_sede' => TextInput::make('gg_cateco_posfun_in_sede'),
            'gg_cateco_posfun_fuori_sede' => TextInput::make('gg_cateco_posfun_fuori_sede'),
            'gg_asz_in_sede' => TextInput::make('gg_asz_in_sede'),
            'gg_asz_fuori_sede' => TextInput::make('gg_asz_fuori_sede'),
            'gg_asz_cateco_in_sede' => TextInput::make('gg_asz_cateco_in_sede'),
            'gg_asz_cateco_fuori_sede' => TextInput::make('gg_asz_cateco_fuori_sede'),
            'gg_asz_cateco_posfun_in_sede' => TextInput::make('gg_asz_cateco_posfun_in_sede'),
            'gg_asz_cateco_posfun_fuori_sede' => TextInput::make('gg_asz_cateco_posfun_fuori_sede'),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriValutaziones::route('/'),
            'create' => CreateCriteriValutazione::route('/create'),
            'edit' => EditCriteriValutazione::route('/{record}/edit'),
        ];
    }
}
