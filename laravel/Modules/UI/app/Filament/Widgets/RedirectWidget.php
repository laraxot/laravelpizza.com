<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * RedirectWidget - Widget per gestire redirect verso URL specifici.
 *
 * Questo widget è progettato per creare elementi UI (bottoni, link)
 * che reindirizzano l'utente verso URL specifici.
 *
 * Utilizzo tipico in configurazioni JSON:
 * {
 *     "type": "widget",
 *     "data": {
 *         "view": "pub_theme::components.blocks.widget.simple",
 *         "to": "/admin",
 *         "widget": "Modules\\UI\\Filament\\Widgets\\RedirectWidget"
 *     }
 * }
 */
final class RedirectWidget extends XotBaseWidget
{
    public ?string $url = null;

    /**
     * Testo del link/button (opzionale).
     */
    public string $label = '';

    /**
     * Icona da mostrare (opzionale).
     */
    public string $icon = '';

    /**
     * Destinazione del redirect.
     *
     * @SuppressWarnings("PHPMD.ShortVariable")
     */
    public ?string $to = null;

    /**
     * Classe CSS per styling (opzionale).
     */
    public string $class = '';

    /**
     * Determina se aprire in una nuova tab.
     */
    public bool $external = false;

    /**
     * Vista di default per il widget.
     * Può essere sovrascritta dalla configurazione con la chiave 'view'.
     */
    protected string $view = 'ui::filament.widgets.redirect-widget';

    /**
     * Implementazione richiesta da XotBaseWidget.
     * Per questo widget non abbiamo form, quindi restituiamo array vuoto.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Determina se il widget può essere visualizzato.
     * Per il redirect widget, sempre visibile se ha una destinazione.
     */
    public static function canView(): bool
    {
        return true;
    }

    /**
     * Dati da passare alla vista.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'to' => $this->to ?? $this->url,
            'label' => $this->label ?: 'Vai',
            'icon' => $this->icon,
            'class' => $this->class,
            'external' => $this->external,
        ];
    }
}
