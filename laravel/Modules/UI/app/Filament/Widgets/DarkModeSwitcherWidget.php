<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Modules\UI\Datas\UIConfigData;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

final class DarkModeSwitcherWidget extends XotBaseSchemaWidget
{
    public ?array $data = [];

    public bool $darkMode = false;

    /** @var view-string */
    protected string $view = 'ui::filament.widgets.dark-mode-switcher';

    public function mount(): void
    {
        $this->darkMode = filter_var(request()->cookie('dark_mode', 'false'), FILTER_VALIDATE_BOOLEAN);
    }

    public function toggleDarkMode(): void
    {
        $this->darkMode = ! $this->darkMode;

        // Set cookie for persistence
        Cookie::queue('dark_mode', $this->darkMode ? 'true' : 'false', 60 * 24 * 30);

        // Dispatch event for frontend to handle theme switching
        $this->dispatch('darkModeUpdated', ['darkMode' => $this->darkMode]);
    }

    /**
     * Schema del form per la configurazione del widget.
     *
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Disabilitabile dalla SettingPage di UI (default: visibile).
     */
    public static function canView(): bool
    {
        return UIConfigData::make()->dark_mode_switcher_enabled;
    }

    public function render(): View
    {
        return view($this->view, [
            'darkMode' => $this->darkMode,
        ]);
    }
}
