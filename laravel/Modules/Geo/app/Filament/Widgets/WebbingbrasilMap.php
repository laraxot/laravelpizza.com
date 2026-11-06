<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Widget mappa temporaneamente disabilitato per migrazione Filament v4.
 * Il pacchetto Webbingbrasil\FilamentMaps non è compatibile con Filament v4.
 *
 * @see https://github.com/webbingbrasil/filament-maps/issues
 */
class WebbingbrasilMap extends XotBaseWidget
{
    /** @var view-string */
    protected string $view;

    public function __construct()
    {
        /** @var view-string $view */
        $view = 'geo::filament.widgets.webbingbrasil-map-stub';
        $this->view = $view;

        parent::__construct();
    }

    protected int|string|array $columnSpan = 2;

    protected bool $hasBorder = false;

    /**
     * Determina se il widget può essere visualizzato.
     * Temporaneamente disabilitato per compatibilità Filament v4.
     */
    public static function canView(): bool
    {
        return false;
    }
}
