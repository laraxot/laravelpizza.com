<?php

declare(strict_types=1);

namespace Modules\UI\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\UI\Filament\Widgets\DarkModeSwitcherWidget;

/**
 * Componente Blade per il Dark Mode Switcher.
 *
 * Wrappa il DarkModeSwitcherWidget per l'uso nei temi tramite sintassi Blade.
 */
final class DarkModeSwitcher extends Component
{
    /**
     * Widget associato al componente.
     */
    protected DarkModeSwitcherWidget $widget;

    /**
     * Crea una nuova istanza del componente.
     */
    public function __construct()
    {
        $this->widget = new DarkModeSwitcherWidget;
    }

    /**
     * Renderizza il componente.
     */
    public function render(): View
    {
        // Verifica se il widget può essere visualizzato
        if (! DarkModeSwitcherWidget::canView()) {
            /** @var view-string $emptyView */
            $emptyView = 'ui::components.empty';

            return view($emptyView);
        }

        // Ottiene i dati dal widget
        $viewData = ['darkMode' => $this->widget->darkMode];

        /** @var view-string $widgetView */
        $widgetView = 'ui::filament.widgets.dark-mode-switcher';

        return view($widgetView, $viewData);
    }
}
