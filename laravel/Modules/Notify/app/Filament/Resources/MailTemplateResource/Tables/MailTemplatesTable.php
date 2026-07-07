<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MailTemplatesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'mailable' => TextColumn::make('mailable')->searchable()->sortable(),
            'slug' => TextColumn::make('slug')->searchable(),
            'counter' => TextColumn::make('counter')->sortable(),
            'version' => TextColumn::make('version')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
