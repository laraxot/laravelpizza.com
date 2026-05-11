<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MailTemplateInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'mailable' => TextEntry::make('mailable'),
            'name' => TextEntry::make('name'),
            'slug' => TextEntry::make('slug'),
            'subject' => TextEntry::make('subject'),
            'html_layout_path' => TextEntry::make('html_layout_path'),
            'html_template' => TextEntry::make('html_template'),
            'text_template' => TextEntry::make('text_template'),
            'sms_template' => TextEntry::make('sms_template'),
            'whatsapp_template' => TextEntry::make('whatsapp_template'),
            'params' => TextEntry::make('params'),
            'counter' => TextEntry::make('counter'),
        ];
    }
}
