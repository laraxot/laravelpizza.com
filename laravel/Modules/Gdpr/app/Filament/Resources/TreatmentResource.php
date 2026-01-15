<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\Gdpr\Filament\Resources\TreatmentResource\Pages\CreateTreatment;
use Modules\Gdpr\Filament\Resources\TreatmentResource\Pages\EditTreatment;
use Modules\Gdpr\Filament\Resources\TreatmentResource\Pages\ListTreatments;
use Modules\Gdpr\Models\Treatment;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TreatmentResource extends XotBaseResource
{
    protected static ?string $model = Treatment::class;

    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'active' => Toggle::make('active')->required(),
            'required' => Toggle::make('required')->required(),
            'name' => TextInput::make('name')->required()->maxLength(191),
            'description' => Textarea::make('description')->required()->columnSpanFull(),
            'documentVersion' => TextInput::make('documentVersion')->maxLength(191)->default(null),
            'documentUrl' => TextInput::make('documentUrl')->maxLength(191)->default(null),
            'weight' => TextInput::make('weight')->required()->numeric(),
        ];
    }

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
