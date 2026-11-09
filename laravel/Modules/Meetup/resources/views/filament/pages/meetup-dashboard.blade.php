<x-filament-panels::page>
    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::dashboard.widgets.start', scopes: [null, \Filament\Facades\Filament::getCurrentPanel()?->getId()]) }}
    
    <x-filament-widgets::widgets
        :widgets="$this->getWidgets()"
        :columns="$this->getColumns()"
    />
    
    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::dashboard.widgets.end', scopes: [null, \Filament\Facades\Filament::getCurrentPanel()?->getId()]) }}
</x-filament-panels::page>