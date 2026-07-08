<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

class FilterFormWidget extends XotBaseSchemaWidget
{
    // protected static string $view = 'filament.resources.your-resource.widgets.filter-form-widget';

    // protected int|string|array $columnSpan = 'full';

    // public ?array $data = [];

    // public array $form_schema = [];

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /*
    public function mount(): void
    {
        $this->form->fill();
    }



    public function applyFilters(): void
    {
        // Emetti un evento per aggiornare la pagina principale
        $this->dispatch('filtersUpdated', filters: $this->data);
    }

    public function resetFilters(): void
    {
        $this->form->fill();
        $this->dispatch('filtersUpdated', filters: []);
    }
    */
}
