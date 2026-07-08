<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MailTemplateResource\Schemas;

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
            'slug' => TextEntry::make('slug'),
            'name' => TextEntry::make('name'),
            'subject' => TextEntry::make('subject'),
            'html_layout_path' => TextEntry::make('html_layout_path'),
            'html_template' => TextEntry::make('html_template'),
            'notify::filament.components.params-badges' => TextEntry::make('notify::filament.components.params-badges'),
            'text_template' => TextEntry::make('text_template'),
            'sms_template' => TextEntry::make('sms_template'),
            'counter' => TextEntry::make('counter'),
        ];
    }
}
