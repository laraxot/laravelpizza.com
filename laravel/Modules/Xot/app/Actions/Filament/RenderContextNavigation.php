<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Spatie\QueueableAction\QueueableAction;

class RenderContextNavigation
{
    use QueueableAction;

    /**
     * Render context navigation hooks for Filament sidebar.
     *
     * @param string $module   Module name
     * @param string $_context Context (unused but kept for compatibility)
     */
    public function execute(string $module, string $_context): void
    {
        FilamentView::registerRenderHook(
            'sidebar.start',
            static fn (): string => Blade::render('<div class="p-2 px-6 bg-primary-100 font-black w-full">'.
                sprintf('%s Module</div>', $module)),
        );
        FilamentView::registerRenderHook(
            'sidebar.end',
            static fn (): string => Blade::render('<a class="p-2 px-6 bg-primary-100 font-black w-full inline-flex space-x-2" href="'.
            route('filament.pages.dashboard').
                '"><x-heroicon-o-arrow-left class="w-5"/> Main Module</a>'),
        );

        /* -- esiste in filament 3
         * Filament::registerRenderHook(
         * 'user-menu.start',
         * fn (): string => Blade::render('@livewire(\'switchable-team\')'),
         * );
         */
    }
}
