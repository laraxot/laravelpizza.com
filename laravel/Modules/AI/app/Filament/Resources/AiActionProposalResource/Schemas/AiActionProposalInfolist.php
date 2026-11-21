<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiActionProposalResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class AiActionProposalInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'type' => TextEntry::make('type'),
            'status' => TextEntry::make('status')->badge(),
            'preview' => TextEntry::make('preview')->columnSpanFull(),
            'error' => TextEntry::make('error')->columnSpanFull(),
            'confirmed_at' => TextEntry::make('confirmed_at')->dateTime(),
            'executed_at' => TextEntry::make('executed_at')->dateTime(),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'updated_at' => TextEntry::make('updated_at')->dateTime(),
        ];
    }
}
