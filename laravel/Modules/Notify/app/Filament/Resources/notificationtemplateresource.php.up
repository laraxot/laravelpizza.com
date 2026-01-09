<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Dotswan\FilamentGrapesjs\Forms\Components\Grapesjs;

class NotificationTemplateResource extends XotBaseResource
{
    protected static ?string $model = NotificationTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationGroup = 'Sistema';

    protected static ?int $navigationSort = 48;

    public static function getNavigationLabel(): string
    {
        return __('notify::template.navigation.label');
    }

    public static function getNavigationGroup(): string
    {
        return __('notify::template.navigation.group');
    }

    public static function getModelLabel(): string
    {
        return __('notify::template.navigation.label');
    }

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('subject')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('body_text')
                        ->required()
                        ->maxLength(65535)
                        ->columnSpan(['lg' => 3]),

                    Forms\Components\Textarea::make('body_html')
                        ->required()
                        ->maxLength(65535)
                        ->columnSpan(['lg' => 3]),

                    Forms\Components\Textarea::make('preview_data')
                        ->json()
                        ->columnSpan(['lg' => 3]),
                ])
                ->columns(['lg' => 3])
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('subject'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotificationTemplates::route('/'),
            'create' => Pages\CreateNotificationTemplate::route('/create'),
            'edit' => Pages\EditNotificationTemplate::route('/{record}/edit'),
        ];
    }
} 