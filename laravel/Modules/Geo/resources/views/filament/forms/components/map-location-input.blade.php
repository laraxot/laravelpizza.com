@php
/** @var \Modules\Geo\Filament\Forms\Components\MapLocationInput $field */
$statePath = $field->getStatePath();
$id = $field->getId();
$state = $field->getState();
$initLat = is_array($state) ? ($state['latitude'] ?? null) : null;
$initLng = is_array($state) ? ($state['longitude'] ?? null) : null;
$height = $field->getHeight() ?: '300px';
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{
            _lat: @json($initLat),
            _lng: @json($initLng),
            _suppressUpdate: false,

            init() {
                this.$wire.$watch('{{ $statePath }}', (val) => {
                    if (this._suppressUpdate) return;
                    this._lat = val?.latitude ?? null;
                    this._lng = val?.longitude ?? null;
                });
            },

            handleLocationChanged(event) {
                const { latitude, longitude } = event.detail;
                this._suppressUpdate = true;
                this._lat = latitude;
                this._lng = longitude;
                this.$wire.$set('{{ $statePath }}', { latitude, longitude });
                setTimeout(() => { this._suppressUpdate = false; }, 350);
            }
        }"
        class="map-location-input-field-wrapper"
        @location-changed.stop="handleLocationChanged($event)"
    >
        <div class="map-container" style="--map-height: {{ $height }}">
            <div class="map-location-pane" style="height: 100%;"></div>
        </div>
        <map-location-input-lit
            :latitude="_lat !== null ? _lat : @json($field->getLatitude())"
            :longitude="_lng !== null ? _lng : @json($field->getLongitude())"
            zoom="{{ $field->getZoom() }}"
            height="{{ $height }}"
        ></map-location-input-lit>
    </div>
</x-dynamic-component>
