<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class NotifyThemeInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'lang' => TextEntry::make('lang'),
            'type' => TextEntry::make('type'),
            'subject' => TextEntry::make('subject'),
            'body' => TextEntry::make('body')
                ->limit(120),
            'body_html' => TextEntry::make('body_html'),
            'from' => TextEntry::make('from'),
            'from_email' => TextEntry::make('from_email'),
            'post_type' => TextEntry::make('post_type'),
            'post_id' => TextEntry::make('post_id'),
            'theme' => TextEntry::make('theme'),
            'logo_src' => TextEntry::make('logo_src'),
            'logo_width' => TextEntry::make('logo_width'),
            'logo_height' => TextEntry::make('logo_height'),
            'view_params' => TextEntry::make('view_params'),
        ];
    }
}
