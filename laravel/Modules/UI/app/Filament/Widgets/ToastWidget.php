<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * Widget di notifica toast.
 *
 * Sostituisce il vecchio componente HTTP `Http\Livewire\Toast`: stessa vista
 * `ui::filament.widgets.toast` (contenuto identico, un contenitore vuoto —
 * il rendering delle notifiche vero e proprio e' gestito altrove), nessun
 * comportamento aggiunto o rimosso rispetto all'originale.
 *
 * @see DarkModeSwitcherWidget per lo stesso pattern di conversione HTTP->widget
 */
final class ToastWidget extends XotBaseSchemaWidget
{
    /** @var view-string */
    protected string $view = 'ui::filament.widgets.toast';

    /**
     * Non è una dashboard card: si monta esplicitamente nel layout FO
     * (`@livewire(\Modules\UI\Filament\Widgets\ToastWidget::class)`).
     */
    protected static bool $isDiscovered = false;

    /**
     * Schema del form: il widget non espone campi editabili.
     *
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }
}
