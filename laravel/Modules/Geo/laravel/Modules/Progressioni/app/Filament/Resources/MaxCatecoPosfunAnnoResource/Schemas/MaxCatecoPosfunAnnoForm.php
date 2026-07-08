<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MaxCatecoPosfunAnnoResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MaxCatecoPosfunAnnoForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'cateco' => TextInput::make('cateco')->required(),
            'posfun' => TextInput::make('posfun')->required(),
            'anno' => TextInput::make('anno')->required()->numeric(),
            'max_gg_tot_pond' => TextInput::make('max_gg_tot_pond')->required(),
            'aventi_diritto' => TextInput::make('aventi_diritto')->numeric(),
            'aventi_diritto_perc' => TextInput::make('aventi_diritto_perc')->numeric(),
            'aventi_diritto_eff' => TextInput::make('aventi_diritto_eff')->numeric(),
        ];
    }
}
