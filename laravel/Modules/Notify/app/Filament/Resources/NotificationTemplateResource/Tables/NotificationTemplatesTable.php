<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Notify\Models\NotificationTemplate;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class NotificationTemplatesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<NotificationTemplate>
     */
    protected static string $model = NotificationTemplate::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'code' => TextColumn::make('code')->searchable()->sortable(),
            'type' => TextColumn::make('type')->searchable()->sortable()->badge(),
            'category' => TextColumn::make('category')->searchable()->sortable(),
            'is_active' => IconColumn::make('is_active')->boolean()->sortable(),
            'version' => TextColumn::make('version')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)];
    }
}
