<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\SnapshotResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

/**
 * SnapshotInfolist Schema.
 */
class SnapshotInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<int|string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'model_type' => TextEntry::make('model_type'),
            'model_id' => TextEntry::make('model_id'),
            'created_by_type' => TextEntry::make('created_by_type'),
            'created_by_id' => TextEntry::make('created_by_id'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
        ];
    }
}
