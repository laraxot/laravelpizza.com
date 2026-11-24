<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Notify\Models\MailTemplate;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MailTemplatesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<MailTemplate>
     */
    protected static string $model = MailTemplate::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'mailable' => TextColumn::make('mailable')->searchable()->sortable(),
            'slug' => TextColumn::make('slug')->searchable()->sortable()->copyable(),
            'counter' => TextColumn::make('counter')->numeric()->sortable(),
            'version' => TextColumn::make('version')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)];
    }

    /**
     * @return array<string, TextColumn>
     */
    public static function mailTemplateTableColumns(): array
    {
        return [
            'slug' => TextColumn::make('slug')->searchable()->sortable(),
            // TextColumn::make('mailable')->searchable()->sortable(),
            'subject' => TextColumn::make('subject')->searchable()->sortable(),
            'counter' => TextColumn::make('counter')->searchable()->sortable()];
    }
}
