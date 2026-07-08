<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\MyLogResource\Pages\CreateMyLog;
use Modules\Progressioni\Filament\Resources\MyLogResource\Pages\EditMyLog;
use Modules\Progressioni\Filament\Resources\MyLogResource\Pages\ListMyLogs;
use Modules\Progressioni\Models\MyLog;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class MyLogResource extends XotBaseResource
{
    protected static ?string $model = MyLog::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'id_tbl' => TextInput::make('id_tbl')->numeric(),
            'tbl' => TextInput::make('tbl'),
            'id_approvaz' => TextInput::make('id_approvaz')->numeric(),
            'note' => Textarea::make('note')->rows(3),
            'obj' => TextInput::make('obj'),
            'act' => TextInput::make('act'),
            'data' => KeyValue::make('data'),
            'datemod' => TextInput::make('datemod'),
            'handle' => TextInput::make('handle'),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMyLogs::route('/'),
            'create' => CreateMyLog::route('/create'),
            'edit' => EditMyLog::route('/{record}/edit'),
        ];
    }
}
