<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\RatingResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Rating\Filament\Resources\RatingResource\Schemas\BaseRatingInfolist;

class RatingInfolist extends BaseRatingInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'extra_attributes.type' => TextEntry::make('extra_attributes.type'),
            'extra_attributes.anno' => TextEntry::make('extra_attributes.anno'),
            'title' => TextEntry::make('title'),
            'color' => TextEntry::make('color'),
            'rule' => TextEntry::make('rule'),
            'is_disabled' => TextEntry::make('is_disabled'),
            'is_readonly' => TextEntry::make('is_readonly'),
            'txt' => TextEntry::make('txt'),
            'filter' => TextEntry::make('filter'),
            'anno' => TextEntry::make('anno'),
            'copy_from_last_year' => TextEntry::make('copy_from_last_year'),
        ];
    }
}
