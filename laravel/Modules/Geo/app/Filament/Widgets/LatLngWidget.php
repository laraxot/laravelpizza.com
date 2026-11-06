<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Widget per coordinate lat/lng.
 *
 * Estende XotBaseWidget per coerenza con l'architettura XotBase.
 */
class LatLngWidget extends XotBaseWidget
{
    /** @var view-string */
    protected string $view;

    public function __construct()
    {
        /** @var view-string $view */
        $view = 'geo::filament.widgets.lat-lng';
        $this->view = $view;

        parent::__construct();
    }

    public float $lat = 0;

    public float $lng = 0;

    public ?int $err_code = null;

    public ?string $err_message = null;
}
