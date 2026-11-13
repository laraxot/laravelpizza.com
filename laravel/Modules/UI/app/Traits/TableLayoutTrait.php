<?php

declare(strict_types=1);

namespace Modules\UI\Traits;

use Illuminate\Support\Facades\Session;
use Modules\UI\Enums\TableLayoutEnum;

trait TableLayoutTrait
{
    public function getTableLayout(): TableLayoutEnum
    {
        $value = Session::get('table_layout');

        if ($value instanceof TableLayoutEnum) {
            return $value;
        }

        if (is_string($value) || is_int($value)) {
            return TableLayoutEnum::tryFrom((string) $value) ?? TableLayoutEnum::GRID;
        }

        return TableLayoutEnum::GRID;
    }

    public function setTableLayout(TableLayoutEnum $layout): void
    {
        Session::put('table_layout', $layout->value);
    }

    public function refreshTable(): void
    {
        $this->dispatch('$refresh');
        $this->resetTable();
    }

    public function resetTable(): void
    {
        // Implementazione predefinita - le classi che usano questo trait dovrebbero sovrascrivere questo metodo
        $this->dispatch('reset-table');
    }
}
