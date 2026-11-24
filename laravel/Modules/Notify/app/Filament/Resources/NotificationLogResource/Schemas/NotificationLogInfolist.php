<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationLogResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Notify\Enums\ChannelEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class NotificationLogInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'channel' => TextEntry::make('channel')
                ->badge()
                ->formatStateUsing(fn (string $state): string => ChannelEnum::from($state)->getLabel() ?? $state),
            // `status` e' castato a NotificationLogStatusEnum: Filament ricava label/colore/icona dall'enum.
            'status' => TextEntry::make('status')->badge(),
            'notifiable_type' => TextEntry::make('notifiable_type'),
            'notifiable_id' => TextEntry::make('notifiable_id'),
            'status_message' => TextEntry::make('status_message'),
            'data' => TextEntry::make('data')
                ->formatStateUsing(fn (array|string|null $state): string => $this->formatJsonState($state))
                ->columnSpanFull(),
            'metadata' => TextEntry::make('metadata')
                ->formatStateUsing(fn (array|string|null $state): string => $this->formatJsonState($state))
                ->columnSpanFull(),
            'tenant_id' => TextEntry::make('tenant_id'),
            'sent_at' => TextEntry::make('sent_at')->dateTime(),
            'delivered_at' => TextEntry::make('delivered_at')->dateTime(),
            'failed_at' => TextEntry::make('failed_at')->dateTime(),
            'opened_at' => TextEntry::make('opened_at')->dateTime(),
            'clicked_at' => TextEntry::make('clicked_at')->dateTime(),
            'created_at' => TextEntry::make('created_at')->dateTime(),
        ];
    }

    /**
     * @param  array<array-key, mixed>|string|null  $state  Stato di colonna JSON (cast `array`) o stringa grezza
     */
    private function formatJsonState(array|string|null $state): string
    {
        if (\is_array($state)) {
            return json_encode($state, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        }

        if (\is_string($state)) {
            return $state;
        }

        return '';
    }
}
