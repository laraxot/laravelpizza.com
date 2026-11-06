<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Notify\Models\NotifyTheme;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class NotifyThemesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<NotifyTheme>
     */
    protected static string $model = NotifyTheme::class;

    public function getTableFilters(): array
    {
        return [
            'lang' => SelectFilter::make('lang')->options(
                fn (): array => NotifyThemeResource::fieldOptions('lang'),
            ),
            'post_type' => SelectFilter::make('post_type')->options(
                fn (): array => NotifyThemeResource::fieldOptions('post_type'),
            ),
            'type' => SelectFilter::make('type')->options(
                fn (): array => NotifyThemeResource::fieldOptions('type'),
            )];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->sortable(),
            'lang' => TextColumn::make('lang')->sortable(),
            'type' => TextColumn::make('type')->sortable(),
            'post_type' => TextColumn::make('post_type')->sortable(),
            'post_id' => TextColumn::make('post_id')->sortable()->toggleable(isToggledHiddenByDefault: true),
            'logo_src' => TextColumn::make('logo_src')->sortable()->toggleable(isToggledHiddenByDefault: true),
            'subject' => TextColumn::make('subject')->searchable()->sortable()->wrap(),
            'theme' => TextColumn::make('theme')->searchable()->sortable(),
            'from_email' => TextColumn::make('from_email')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)];
    }
}
