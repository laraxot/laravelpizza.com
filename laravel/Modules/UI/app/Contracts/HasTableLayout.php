<?php

declare(strict_types=1);

namespace Modules\UI\Contracts;

use Modules\UI\Enums\TableLayoutEnum;

/**
 * Contratto layout tabella Filament — implementato da TableLayoutTrait.
 */
interface HasTableLayout
{
    public function getTableLayout(): TableLayoutEnum;

    public function setTableLayout(TableLayoutEnum $layout): void;
}
