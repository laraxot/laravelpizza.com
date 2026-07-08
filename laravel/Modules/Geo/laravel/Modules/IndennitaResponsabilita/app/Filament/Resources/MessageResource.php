<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Modules\IndennitaResponsabilita\Filament\Resources\MessageResource\Pages\CreateMessage;
use Modules\IndennitaResponsabilita\Filament\Resources\MessageResource\Pages\EditMessage;
use Modules\IndennitaResponsabilita\Filament\Resources\MessageResource\Pages\ListMessages;
use Modules\IndennitaResponsabilita\Models\Message;
use Modules\Ptv\Filament\Resources\BaseMessageResource;
use Override;

class MessageResource extends BaseMessageResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = Message::class;

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMessages::route('/'),
            'create' => CreateMessage::route('/create'),
            'edit' => EditMessage::route('/{record}/edit'),
        ];
    }
}
