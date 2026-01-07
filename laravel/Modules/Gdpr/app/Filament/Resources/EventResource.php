<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Gdpr\Filament\Resources\EventResource\Pages\CreateEvent;
use Modules\Gdpr\Filament\Resources\EventResource\Pages\EditEvent;
use Modules\Gdpr\Filament\Resources\EventResource\Pages\ListEvents;
use Modules\Gdpr\Models\Event;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'treatment_id' => TextInput::make('treatment_id')->maxLength(36)->default(null),
            'consent_id' => Select::make('consent_id')->relationship('consent', 'id'),
            'subject_id' => TextInput::make('subject_id')->required()->maxLength(191),
            'ip' => TextInput::make('ip')->required()->maxLength(191),
            'action' => TextInput::make('action')->required()->maxLength(191),
            'payload' => Textarea::make('payload')->required()->columnSpanFull(),
        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
