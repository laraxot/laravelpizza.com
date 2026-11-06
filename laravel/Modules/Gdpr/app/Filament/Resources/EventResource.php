<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Modules\Gdpr\Filament\Resources\EventResource\Pages\CreateEvent;
use Modules\Gdpr\Filament\Resources\EventResource\Pages\EditEvent;
use Modules\Gdpr\Filament\Resources\EventResource\Pages\ListEvents;
use Modules\Gdpr\Models\Event;
use Modules\Xot\Filament\Resources\XotBaseResource;

class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
