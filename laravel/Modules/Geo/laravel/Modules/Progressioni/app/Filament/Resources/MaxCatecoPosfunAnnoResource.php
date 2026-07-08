<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\MaxCatecoPosfunAnnoResource\Pages\CreateMaxCatecoPosfunAnno;
use Modules\Progressioni\Filament\Resources\MaxCatecoPosfunAnnoResource\Pages\EditMaxCatecoPosfunAnno;
use Modules\Progressioni\Filament\Resources\MaxCatecoPosfunAnnoResource\Pages\ListMaxCatecoPosfunAnnos;
use Modules\Progressioni\Models\MaxCatecoPosfunAnno;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class MaxCatecoPosfunAnnoResource extends XotBaseResource
{
    protected static ?string $model = MaxCatecoPosfunAnno::class;

    #[Override]
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

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMaxCatecoPosfunAnnos::route('/'),
            'create' => CreateMaxCatecoPosfunAnno::route('/create'),
            'edit' => EditMaxCatecoPosfunAnno::route('/{record}/edit'),
        ];
    }
}
