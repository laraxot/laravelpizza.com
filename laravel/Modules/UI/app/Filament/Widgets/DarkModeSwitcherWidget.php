<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

final class DarkModeSwitcherWidget extends XotBaseWidget
{
    public ?array $data = [];

    public bool $darkMode = false;

    protected string $view = 'ui::filament.widgets.dark-mode-switcher';

    public function mount(): void
    {
        // @var mixed darkMode = filter_var(request(;
    }

    public function toggleDarkMode(): void
    {
        // @var mixed darkMode = ! $this->darkMode;

        // Set cookie for persistence
        Cookie::queue('dark_mode', // @var mixed darkMode ? 'true' : 'false', 60 * 24 * 30;

        // Dispatch event for frontend to handle theme switching
        // @var mixed dispatch('darkModeUpdated', ['darkMode' => $this->darkMode];
    }

    /**
     * Schema del form per la configurazione del widget.
     *
     * @return array<int, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [];
    }

    public function render(): View
    {
        return view(// @var mixed view, [
            'darkMode' => // @var mixed darkMode,
        ]);
    }
}
