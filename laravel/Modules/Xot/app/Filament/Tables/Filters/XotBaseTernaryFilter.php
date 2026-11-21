<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Filters;

use Filament\Tables\Filters\TernaryFilter as FilamentTernaryFilter;

/**
 * Ternary filter base — setup di default Filament (form(), non schema()).
 */
abstract class XotBaseTernaryFilter extends FilamentTernaryFilter
{
    protected function setUp(): void
    {
        parent::setUp();
    }
}
