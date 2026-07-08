<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class NotificationInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'message' => TextEntry::make('message')
                ->limit(120),
            'type' => TextEntry::make('type'),
            'read_at' => TextEntry::make('read_at')
                ->dateTime(),
            'tenant_id' => TextEntry::make('tenant_id'),
            'user_id' => TextEntry::make('user_id'),
            'subject_type' => TextEntry::make('subject_type'),
            'subject_id' => TextEntry::make('subject_id'),
            'channels' => TextEntry::make('channels')
                ->limit(120),
            'status' => TextEntry::make('status'),
            'sent_at' => TextEntry::make('sent_at')
                ->dateTime(),
            'data' => TextEntry::make('data')
                ->limit(120),
            'notifiable_type' => TextEntry::make('notifiable_type'),
            'notifiable_id' => TextEntry::make('notifiable_id'),
            'title' => TextEntry::make('title'),
            'content' => TextEntry::make('content')
                ->limit(120),
            'error' => TextEntry::make('error')
                ->limit(120),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
            'channel' => TextEntry::make('channel'),
            'recipient' => TextEntry::make('recipient'),
            'subject' => TextEntry::make('subject'),
            'error_message' => TextEntry::make('error_message')
                ->limit(120),
            'metadata' => TextEntry::make('metadata')
                ->limit(120),
        ];
    }
}
