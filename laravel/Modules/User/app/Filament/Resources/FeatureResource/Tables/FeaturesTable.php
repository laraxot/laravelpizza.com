<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\FeatureResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\Feature;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FeaturesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Feature>
     */
    protected static string $model = Feature::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'scope' => TextColumn::make('scope')->searchable()->sortable(),
            'value' => TextColumn::make('value')->limit(60)->wrap(),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
            'deleted_at' => TextColumn::make('deleted_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
