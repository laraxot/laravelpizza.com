<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Modules\Performance\Models\Organizzativa;
use Modules\Ptv\Filament\Resources\BaseSchedaResource;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\CompilaScheda;
use Override;

class OrganizzativaResource extends BaseSchedaResource
{
    /** @var class-string<Model>|null */
    protected static ?string $model = Organizzativa::class;

    

    #[Override]
    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
            // 'fill_out_the_form' => FillOutTheForm::route('/{record}/fill'),
            'compila' => CompilaScheda::route('/{record}/compila'),
        ];
    }

    /**
     * @return array<int, string>
     */
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
            'quota_teorica',
            'budget_assegnato',
            'quota_effettiva',
            'resti',
            'resti_pond',
            'importo_totale',
        ];
    }
}
