<x-filament-panels::page>
    {{ $this->calendar }}
    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::dashboard.widgets.start', scopes: [null, $this->getPanel()->getId()]) }}
    
    <x-filament-widgets::widgets
        :widgets="$this->getWidgets()"
        :columns="$this->getColumns()"
    />
    
    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::dashboard.widgets.end', scopes: [null, $this->getPanel()->getId()]) }}
</x-filament-panels::page>