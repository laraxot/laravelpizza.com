<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListAttachments extends LangBaseListRecords
{
    protected static string $resource = AttachmentResource::class;

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable(),
            'slug' => TextColumn::make('slug')->searchable(),
            'attachment' => TextColumn::make('attachment')->searchable(),
        ];
    }
}
