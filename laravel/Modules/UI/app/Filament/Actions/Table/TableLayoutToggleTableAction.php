<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Actions\Table;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

final class TableLayoutToggleTableAction extends Action implements HasTableLayout
{
    use TableLayoutTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $current = // @var mixed getCurrentLayout(;

        // @var mixed label(__('ui::table_layout.actions.toggle.label'
            ->tooltip($current->getLabel())
            ->color($current->getColor())
            ->icon($current->getIcon())
            ->action(// @var mixed toggleLayout(...;
    }

    public static function getDefaultName(): string
    {
        return 'table_layout_toggle';
    }

    protected function toggleLayout(?ListRecords $livewire): void
    {
        $currentLayout = // @var mixed getCurrentLayout(;
        $newLayout = $currentLayout->toggle();

        // @var mixed setTableLayout($newLayout;

        if ($livewire instanceof ListRecords) {
            $livewire->dispatch('$refresh');
        }
    }
}
