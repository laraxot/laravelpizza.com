@php
    $latitude = is_object($record ?? null) ? $record->getAttribute('latitude') : null;
    $longitude = is_object($record ?? null) ? $record->getAttribute('longitude') : null;
    $hasCoordinates = is_numeric($latitude) && is_numeric($longitude);
    $mapId = 'geo-location-map-'.\Illuminate\Support\Str::random(8);
    $googleMapsUrl = $hasCoordinates
        ? 'https://www.google.com/maps/search/?api=1&query='.rawurlencode((string) $latitude.','. (string) $longitude)
        : null;
    $viaMichelinUrl = $hasCoordinates
        ? 'https://www.viamichelin.com/web/Maps?address='.rawurlencode((string) $latitude.','. (string) $longitude)
        : null;
@endphp

<div>
    <h3 class="text-sm font-semibold leading-6 text-gray-950 dark:text-white mb-3">
        {{ __('geo::coordinates.address_form.map.heading') }}
    </h3>
    @if ($hasCoordinates)
        <link rel="stylesheet" href="{{ $asset_base }}/leaflet.css">
        <div
            id="{{ $mapId }}"
            role="region"
            aria-label="{{ __('geo::coordinates.address_form.map.aria_label') }}"
            tabindex="0"
            style="height: 300px; width: 100%; border-radius: 0.5rem;"
        ></div>
        <div class="mt-3 flex flex-wrap gap-2">
            <a class="fi-btn fi-btn-color-primary fi-btn-size-sm" href="{{ $googleMapsUrl }}" target="_blank" rel="noopener noreferrer">
                {{ __('geo::coordinates.address_form.map.google_maps') }}
            </a>
            <a class="fi-btn fi-btn-color-gray fi-btn-size-sm" href="{{ $viaMichelinUrl }}" target="_blank" rel="noopener noreferrer">
                {{ __('geo::coordinates.address_form.map.viamichelin') }}
            </a>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            {{ number_format((float) $latitude, 6) }}, {{ number_format((float) $longitude, 6) }}
        </p>
    @else
        <p class="text-sm text-gray-500">
            {{ __('geo::coordinates.address_form.map.missing') }}
        </p>
    @endif
</div>

@if ($hasCoordinates)
    @script
    <script>
        (() => {
            const mapId = @js($mapId);
            const latitude = @js((float) $latitude);
            const longitude = @js((float) $longitude);
            const assetBase = @js($asset_base);

            const initialize = () => {
                const element = document.getElementById(mapId);
                if (!element || typeof L === 'undefined' || element.dataset.ready === '1') {
                    return;
                }
                element.dataset.ready = '1';
                const map = L.map(element, { scrollWheelZoom: false }).setView([latitude, longitude], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                }).addTo(map);
                L.marker([latitude, longitude]).addTo(map);
            };

            if (typeof L === 'undefined' && !document.querySelector('script[data-geo-location-leaflet]')) {
                const script = document.createElement('script');
                script.src = `${assetBase}/leaflet.js`;
                script.dataset.geoLocationLeaflet = '1';
                script.onload = initialize;
                document.body.appendChild(script);
            } else {
                initialize();
            }
        })();
    </script>
    @endscript
@endif
