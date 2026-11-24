<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiKnowledgeEntryResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AiKnowledgeEntriesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->sortable()->searchable(),
            'collection' => TextColumn::make('collection')
                ->badge()
                ->sortable()
                ->searchable(),
            'question' => TextColumn::make('question')
                ->limit(60)
                ->searchable(),
            'answer' => TextColumn::make('answer')
                ->limit(60)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            'is_active' => IconColumn::make('is_active')
                ->boolean()
                ->sortable(),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
        ];
    }
}
