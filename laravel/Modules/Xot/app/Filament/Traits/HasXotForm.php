<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Filament\Schemas\Schema;
use Modules\UI\Enums\TableLayoutEnum;

/**
 * Trait HasXotTable.
 *
 * Provides enhanced table functionality with translations and optimized structure.
 *
 * @property TableLayoutEnum $layoutView
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 * @SuppressWarnings("PHPMD.CyclomaticComplexity")
 * @SuppressWarnings("PHPMD.NPathComplexity")
 */
trait HasXotForm
{
    /** @var array<string, mixed> */
    public array $data = [];

    abstract public function getFormSchema(): array;

    final public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->columns(2)
            ->statePath('data');
    }
}
