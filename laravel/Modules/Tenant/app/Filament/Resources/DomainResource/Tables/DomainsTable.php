<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources\DomainResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Tenant\Models\Domain;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DomainsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Domain>
     */
    protected static string $model = Domain::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable()->wrap(),
            'id' => IDColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
