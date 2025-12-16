<?php

declare(strict_types=1);

namespace Modules\Xot\Interfaces;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\Column;

interface HasTableFunctions
{
    /**
     * Get the table columns for the list view.
     *
     * @return array<string, Column>
     */
    public function getTableColumns(): array;

    /**
     * Get the table actions.
     *
     * @return array<string, Action>
     */
    public function getTableActions(): array;

    /**
     * Get the table bulk actions.
     *
     * @return array<string, BulkAction>
     */
    public function getTableBulkActions(): array;
}
