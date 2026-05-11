<?php

declare(strict_types=1);

$geoMapWidget = app(\Modules\Geo\Filament\Widgets\GeoMapWidget::class);
$componentId = 'geo-farmshops-map-'.spl_object_id($geoMapWidget);
?>

<geo-map-widget
    id="{{ $componentId }}"
    {{ $attributes->class('block') }}
    data-config='@json($geoMapWidget->getMapConfig())'
    data-dataset='@json($geoMapWidget->getDataset())'
></geo-map-widget>

@once
    <script type="module" src="{{ asset('modules/geo/geo-map-widget.js') }}"></script>
@endonce
