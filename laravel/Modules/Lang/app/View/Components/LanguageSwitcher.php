<?php

declare(strict_types=1);

namespace Modules\Lang\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Lang\Filament\Widgets\LanguageSwitcherWidget;

/**
 * Componente Blade per il Language Switcher.
 *
 * Wrappa il LanguageSwitcherWidget per l'uso nei temi tramite sintassi Blade.
 *
 * @see Modules/Lang/docs/contracts/language-switcher-component.md
 */
class LanguageSwitcher extends Component
{
    /**
     * Widget associato al componente.
     */
    protected LanguageSwitcherWidget $widget;

    /**
     * Crea una nuova istanza del componente.
     */
    public function __construct()
    {
        $this->widget = new LanguageSwitcherWidget;
    }

    /**
     * Renderizza il componente con URL già risolti dal widget.
     *
     * @see Modules/Lang/docs/contracts/language-switcher-component.md
     */
    public function render(): View
    {
        if (! LanguageSwitcherWidget::canView()) {
            return view('lang::components.empty');
        }

        $availableLocales = $this->widget->getAvailableLocales()
            ->map(fn (array $locale): array => [
                ...$locale,
                'url' => $this->widget->getLanguageUrl($locale['code']),
            ]);

        $viewData = [
            'current_locale' => app()->getLocale(),
            'available_locales' => $availableLocales,
            'widget_id' => 'language-switcher-'.uniqid(),
        ];

        return view('lang::components.language-switcher', $viewData);
    }
}
