<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Modules\Geo\Filament\Forms\LocationForm;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * Widget per la selezione della località.
 *
 * Questo widget fornisce un form per la selezione della località utilizzando
 * il form LocationForm.
 *
 * @see \Modules\Geo\docs\json-database.md
 */
class LocationWidget extends XotBaseSchemaWidget
{
    /**
     * Dati del widget.
     */
    public ?array $data = [];

    /**
     * Titolo del widget.
     */
    public string $title = 'geo::widgets.location.title';

    /**
     * Icona del widget.
     */
    public string $icon = 'heroicon-o-map-pin';

    /**
     * Ordine di visualizzazione del widget.
     */
    protected static ?int $sort = 1;

    /**
     * Numero di colonne occupate dal widget.
     */
    protected int|string|array $columnSpan = 'full';

    /** @var view-string */
    protected string $view;

    /**
     * Form per la selezione della località.
     */
    private LocationForm $locationForm;

    /**
     * Costruttore.
     */
    public function __construct()
    {
        /** @var view-string $view */
        $view = 'geo::filament.widgets.location';
        $this->view = $view;

        $this->locationForm = new LocationForm();

        parent::__construct();
    }

    /**
     * Inizializza il widget.
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Ottiene lo schema del form.
     *
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return $this->locationForm->getSchema();
    }

    /**
     * Gestisce l'invio del form.
     */
    public function submit(): void
    {
        $data = $this->form->getState();

        $this->dispatch('location-selected', $data);

        // Utilizzo metodo Livewire per notifiche
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('geo::widgets.location.messages.success'),
        ]);
    }

    /**
     * Verifica se il widget può essere visualizzato.
     */
    public static function canView(): bool
    {
        return true;
    }
}
