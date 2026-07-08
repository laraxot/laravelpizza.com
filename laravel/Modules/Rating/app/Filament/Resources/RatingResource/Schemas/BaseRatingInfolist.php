<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

/**
 * Infolist rating condiviso tra moduli che estendono BaseRatingResource.
 *
 * Le classi concrete nei moduli figli estendono questa base e sovrascrivono
 * getInfolistSchema() quando l'UI differisce.
 */
abstract class BaseRatingInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'title' => TextEntry::make('title'),
            'color' => TextEntry::make('color'),
            'txt' => TextEntry::make('txt'),
            'rule' => TextEntry::make('rule'),
            'is_disabled' => TextEntry::make('is_disabled')->badge(),
            'is_readonly' => TextEntry::make('is_readonly')->badge(),
            'order_column' => TextEntry::make('order_column'),
            'slug' => TextEntry::make('slug'),
        ];
    }
}
