<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Support\Components\Component;
use Modules\Xot\Models\Session;
use Override;

class SessionResource extends XotBaseResource
{
    protected static ?string $model = Session::class;

    /**
     * @return array<int, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('id')->required()->maxLength(255),
            TextInput::make('user_id')->numeric(),
            TextInput::make('ip_address')->maxLength(45),
            TextInput::make('user_agent')->maxLength(255),
            KeyValue::make('payload')->columnSpanFull(),
            TextInput::make('last_activity')->required()->numeric(),
        ];
    }
}
