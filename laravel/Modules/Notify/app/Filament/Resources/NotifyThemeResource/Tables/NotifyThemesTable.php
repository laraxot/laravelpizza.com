<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
<<<<<<< HEAD
=======
use Filament\Tables\Filters\SelectFilter;
use Modules\Notify\Filament\Resources\NotifyThemeResource;
>>>>>>> 40b96bcd6 (.)
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class NotifyThemesTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
=======
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
            ),
        ];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'lang' => TextColumn::make('lang')->sortable(),
            'type' => TextColumn::make('type')->sortable(),
            'subject' => TextColumn::make('subject')->searchable(),
            'theme' => TextColumn::make('theme')->sortable(),
            'from_email' => TextColumn::make('from_email')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
