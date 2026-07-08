<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Resources\WebServiceResource\Tables;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class WebServicesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, CreateAction>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'name' => TextColumn::make('name'),
        ];
    }
}
