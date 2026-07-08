<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\RatingMorphResource\Schemas;

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
            'id' => TextEntry::make('id')
                ->dateTime(),
            'rating' => TextEntry::make('rating')
                ->dateTime(),
            'ratingable_type' => TextEntry::make('ratingable_type')
                ->dateTime(),
            'ratingable_id' => TextEntry::make('ratingable_id')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
