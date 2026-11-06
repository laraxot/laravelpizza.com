{{--
    Mappa di sola lettura di un punto. Classe: Modules\Geo\View\Components\PointMap.
    Nessuno stile per slug: solo stili inline minimi e classi del componente (`geo-point-map*`).
--}}
@if ($lat !== null && $lng !== null)
    <div {{ $attributes->class(['geo-point-map']) }} id="{{ $mapId }}" role="region" aria-label="{{ $ariaLabel }}" wire:key="{{ $wireKey }}">
        {{-- wire:ignore: Livewire non deve distruggere il DOM che Leaflet crea dentro il web component. --}}
        <div wire:ignore style="width:100%;height:{{ $height }}">
            <coordinate-picker-lit
                readonly
                state="{{ $stateJson }}"
                zoom="{{ $zoom }}"
                height="{{ $height }}"
                labels="{{ $labelsJson }}"
            ></coordinate-picker-lit>
        </div>
        {{-- Alternativa testuale: funziona anche senza JS e per i lettori di schermo (la mappa Leaflet non ha testo). --}}
        <p class="geo-point-map__caption" style="margin:.5rem 0 0;font-size:.875rem;line-height:1.4">
            @if ($address !== '')
                <span>{{ __('geo::coordinate-picker.address') }}: <strong>{{ $address }}</strong></span><br>
            @endif
            <span>{{ __('geo::coordinate-picker.latitude') }}: {{ $latText }}</span>
            <span>{{ __('geo::coordinate-picker.longitude') }}: {{ $lngText }}</span><br>
            <a href="{{ $osmUrl }}" target="_blank" rel="noopener noreferrer">{{ __('geo::point-map.open_in_osm') }}</a>
            <span aria-hidden="true">&middot;</span>
            <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">&copy; OpenStreetMap</a>
        </p>
    </div>
@else
    <p {{ $attributes->class(['geo-point-map', 'geo-point-map--empty']) }}>{{ __('geo::point-map.empty') }}</p>
@endif
