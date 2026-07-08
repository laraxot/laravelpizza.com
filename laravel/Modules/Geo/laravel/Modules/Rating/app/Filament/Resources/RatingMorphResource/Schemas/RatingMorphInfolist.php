<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingMorphResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class RatingMorphInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'model_id' => TextEntry::make('model_id'),
            'model_type' => TextEntry::make('model_type'),
            'rating_id' => TextEntry::make('rating_id'),
            'user_id' => TextEntry::make('user_id'),
            'note' => TextEntry::make('note')->limit(100),
            'value' => TextEntry::make('value'),
            'is_winner' => TextEntry::make('is_winner')->badge(),
            'reward' => TextEntry::make('reward'),
        ];
    }
}
