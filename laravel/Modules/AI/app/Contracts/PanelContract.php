<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Filament\Panel;

/**
 * @phpstan-require-extends Panel
 */
interface PanelContract
{
    public function getNavigationIcon(): string;

    public function getNavigationLabel(): string;

    public function getNavigationSort(): int;

    public function getPath(): string;
}
