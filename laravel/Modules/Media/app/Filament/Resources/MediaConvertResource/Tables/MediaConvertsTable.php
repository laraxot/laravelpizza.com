<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaConvertResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MediaConvertsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'media_id' => TextColumn::make('media_id')->sortable(),
            'format' => TextColumn::make('format')->searchable()->sortable(),
            'codec_video' => TextColumn::make('codec_video')->searchable(),
            'codec_audio' => TextColumn::make('codec_audio')->searchable(),
            'preset' => TextColumn::make('preset')->searchable(),
            'bitrate' => TextColumn::make('bitrate')->searchable(),
            'width' => TextColumn::make('width')->sortable(),
            'height' => TextColumn::make('height')->sortable(),
            'percentage' => TextColumn::make('percentage'),
            'execution_time' => TextColumn::make('execution_time'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
