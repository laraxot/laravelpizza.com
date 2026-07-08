<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Modules\Activity\Filament\Resources\SnapshotResource\Pages\CreateSnapshot;
use Modules\Activity\Filament\Resources\SnapshotResource\Pages\EditSnapshot;
use Modules\Activity\Filament\Resources\SnapshotResource\Pages\ListSnapshots;
use Modules\Activity\Models\Snapshot;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class SnapshotResource extends XotBaseResource
{
    protected static ?string $model = Snapshot::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'model_type' => TextInput::make('model_type')->required()->maxLength(255),
            'model_id' => TextInput::make('model_id')->numeric()->required(),
            'state' => KeyValue::make('state')->columnSpanFull(),
            'created_by_type' => TextInput::make('created_by_type')->maxLength(255),
            'created_by_id' => TextInput::make('created_by_id')->numeric(),
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
            'index' => ListSnapshots::route('/'),
            'create' => CreateSnapshot::route('/create'),
            'edit' => EditSnapshot::route('/{record}/edit'),
        ];
    }
}
