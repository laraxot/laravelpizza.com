<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\Ptv\Filament\Resources\BaseStabiDirigenteResource;
use Override;

class StabiDirigenteResource extends BaseStabiDirigenteResource
{
    protected static ?string $model = StabiDirigente::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            'quadrimestre' => TextInput::make('quadrimestre'),
        ];
    }
}
