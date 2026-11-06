<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Tables\Columns\TextColumn;
use Modules\Gdpr\Filament\Resources\ConsentResource\Pages\CreateConsent;
use Modules\Gdpr\Filament\Resources\ConsentResource\Pages\EditConsent;
use Modules\Gdpr\Filament\Resources\ConsentResource\Pages\ListConsents;
use Modules\Gdpr\Models\Consent;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ConsentResource extends XotBaseResource
{
    protected static ?string $model = Consent::class;

    /**
     * @return array<int|string, TextColumn>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->searchable(),
            TextColumn::make('treatment.name')->searchable(),
            'subject_id' => TextColumn::make('subject_id')->searchable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListConsents::route('/'),
            'create' => CreateConsent::route('/create'),
            'edit' => EditConsent::route('/{record}/edit'),
        ];
    }
}
