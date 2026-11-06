<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Filament\Resources\Pages\ListRecords;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Traits\HasTableLayoutPage;

/**
 * ListRecords + HasTableLayoutPage — copre il ramo resetTable() in TableLayoutToggle.
 * Costruttore bypassato: serve solo instanceof + trait.
 */
final class UiCoverageLayoutListRecords extends ListRecords
{
    use HasTableLayoutPage;

    public function __construct()
    {
        // non bootare Livewire/Filament: basta instanceof ListRecords
        $this->layoutView = TableLayoutEnum::GRID;
    }

    public function resetTable(): void
    {
        // covered side-effect branch
    }
}
