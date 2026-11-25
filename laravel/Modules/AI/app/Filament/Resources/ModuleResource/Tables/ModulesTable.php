<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ModuleResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Models\Module;

class ModulesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Module>
     */
    protected static string $model = Module::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'description' => TextColumn::make('description')->searchable()->wrap()->limit(100),
            'status' => IconColumn::make('status')->boolean()->sortable(),
            'priority' => TextColumn::make('priority')->numeric()->sortable(),
            'path' => TextColumn::make('path')->limit(60)->wrap()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
