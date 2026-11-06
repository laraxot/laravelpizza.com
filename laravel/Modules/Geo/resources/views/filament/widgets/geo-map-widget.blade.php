<?php

declare(strict_types=1);

/** @var \Modules\Geo\Filament\Widgets\GeoMapWidget $this */
$widgetId = 'geo-map-widget-'.spl_object_id($this);
?>

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-4">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h3 class="text-base font-semibold text-gray-950 dark:text-white">{{ __('geo::geo_map_widget.sections.title.title') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('geo::geo_map_widget.sections.description.description') }}
                    </p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-600 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    <div>{{ __('geo::geo_map_widget.stats.features.label') }}: {{ $this->getDatasetStats()['total'] }}</div>
                    <div>{{ __('geo::geo_map_widget.stats.points.label') }}: {{ $this->getDatasetStats()['points'] }} · {{ __('geo::geo_map_widget.stats.zones.label') }}: {{ $this->getDatasetStats()['zones'] }}</div>
                    <div>{{ __('geo::geo_map_widget.stats.categories.label') }}: {{ implode(', ', $this->getCategories()) }}</div>
                </div>
            </div>

            <geo-map-widget
                id="{{ $widgetId }}"
                class="block"
                data-config='@json($this->getMapConfig())'
                data-dataset='@json($this->getDataset())'
            ></geo-map-widget>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
