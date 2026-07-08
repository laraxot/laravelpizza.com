<?php

declare(strict_types=1);

?>
<x-filament-panels::page class="fi-dashboard-page">
    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif

    <x-filament-widgets::widgets 
        :columns="$this->getColumns()" 
        :data="[...(data_get($this, 'filters') !== null ? ['filters' => data_get($this, 'filters')] : []), ...$this->getWidgetData()]" 
        :widgets="$this->getVisibleWidgets()" 
    />
</x-filament-panels::page>
