<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Modules\Progressioni\Filament\Resources\MessageResource\Pages\CreateMessage;
use Modules\Progressioni\Filament\Resources\MessageResource\Pages\EditMessage;
use Modules\Progressioni\Filament\Resources\MessageResource\Pages\ListMessages;
use Modules\Progressioni\Models\Message;
use Modules\Ptv\Filament\Resources\BaseMessageResource;
use Override;

class MessageResource extends BaseMessageResource
{
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
