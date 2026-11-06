<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Modules\Gdpr\Filament\Resources\TreatmentResource\Pages\CreateTreatment;
use Modules\Gdpr\Filament\Resources\TreatmentResource\Pages\EditTreatment;
use Modules\Gdpr\Filament\Resources\TreatmentResource\Pages\ListTreatments;
use Modules\Gdpr\Models\Treatment;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TreatmentResource extends XotBaseResource
{
    protected static ?string $model = Treatment::class;

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListTreatments::route('/'),
            'create' => CreateTreatment::route('/create'),
            'edit' => EditTreatment::route('/{record}/edit'),
        ];
    }
}
