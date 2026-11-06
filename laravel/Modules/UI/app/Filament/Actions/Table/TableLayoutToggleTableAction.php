<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Actions\Table;

use Filament\Tables\Contracts\HasTable;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Actions\XotBaseAction;

final class TableLayoutToggleTableAction extends XotBaseAction implements HasTableLayout
{
    use TableLayoutTrait;

    protected function setUp(): void
    {
        parent::setUp();

        // Bottone neutro, non icona nuda: su cellulare e' il comando che porta alla griglia e
        // deve sembrare cliccabile. Grigio perche' cambia la vista, non i dati.
        $this->button()
            ->color('gray')
            ->label(fn (): string => $this->resolveTargetLayout()->getLabel())
            ->hiddenLabel()
            ->tooltip(fn (): string => $this->resolveTargetLayout()->getLabel())
            ->icon(fn (): string => $this->resolveTargetLayout()->getIcon())
            ->action($this->toggleLayout(...));
    }

    public static function getDefaultName(): string
    {
        return 'table_layout_toggle';
    }

    protected function toggleLayout(): void
    {
        $livewire = $this->getLivewire();

        if (! is_object($livewire)) {
            return;
        }

        // Le list page delle Resource non usano HasTableLayoutPage (la tabella la costruisce la
        // `*Table` class): prima qui si usciva e la preferenza non veniva mai salvata.
        $newLayout = $this->resolveLayout($livewire)->toggle();

        $this->setTableLayout($newLayout);
        // Componenti con HasTableLayoutPage (widget, relation manager) tengono anche la proprieta'.
        // Chiamata sull'istanza: `HasTableLayoutPage::applyLayoutTo()` e' un metodo statico di
        // trait chiamato direttamente, deprecato da PHP 8.1 e segnalato a runtime in 8.4.
        if (method_exists($livewire, 'applyLayoutView')) {
            $livewire->applyLayoutView($newLayout);
        }

        // Ricostruisce la tabella con il nuovo layout. Non resetTable(): in Filament 5 azzera
        // anche i filtri, e passando a griglia si perdeva per esempio l'anno filtrato.
        if ($livewire instanceof HasTable && method_exists($livewire, 'bootedInteractsWithTable')) {
            $livewire->bootedInteractsWithTable();
        }
    }

    private function resolveTargetLayout(?object $livewire = null): TableLayoutEnum
    {
        return $this->resolveLayout($livewire)->toggle();
    }

    private function resolveLayout(?object $livewire = null): TableLayoutEnum
    {
        foreach ([$livewire, $this->getLivewire()] as $component) {
            $layout = is_object($component) ? data_get($component, 'layoutView') : null;

            if ($layout instanceof TableLayoutEnum) {
                return $layout;
            }
        }

        // List page delle Resource: niente proprieta' sul componente, vale la sessione.
        return $this->getCurrentLayout();
    }
}
