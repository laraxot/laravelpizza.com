<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthPersonalAccessClientResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OauthPersonalAccessClientForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'oauth_personal_access_client' => Section::make('OAuth Personal Access Client Information')
                ->schema([
                    Select::make('client_id')
                        ->label('Client')
                        ->relationship('client', 'name')
                        ->required()
                        ->searchable()
                        ->helperText('Associated OAuth client'),
                ])
                ->columns(2),
        ];
    }
}
