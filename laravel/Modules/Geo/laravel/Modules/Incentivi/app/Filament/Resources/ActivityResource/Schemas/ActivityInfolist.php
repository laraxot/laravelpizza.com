<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ActivityInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'nome' => TextEntry::make('nome'),
            'tipo' => TextEntry::make('tipo'),
            'quota_percentuale' => TextEntry::make('quota_percentuale'),
            'importo' => TextEntry::make('importo'),
            'anno_competenza' => TextEntry::make('anno_competenza'),
            'project_nome' => TextEntry::make('project.nome'),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'updated_at' => TextEntry::make('updated_at')->dateTime(),
        ];
    }
}
