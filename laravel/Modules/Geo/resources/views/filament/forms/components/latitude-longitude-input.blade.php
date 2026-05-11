@php
/** @var \Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput $field */
$statePath = $field->getStatePath();
$id = $field->getId();
$state = $field->getState();
$initLat = is_array($state) ? ($state['latitude'] ?? null) : null;
$initLng = is_array($state) ? ($state['longitude'] ?? null) : null;
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
                    this._lat = Number(val?.latitude) || null;
                    this._lng = Number(val?.longitude) || null;
                });
            },

            handleGeoLatLngChange(event) {
                const { lat, lng } = event.detail;
                this._suppressUpdate = true;
                this._lat = lat;
                this._lng = lng;
                this.$wire.$set('{{ $statePath }}', { latitude: lat, longitude: lng });
                setTimeout(() => { this._suppressUpdate = false; }, 350);
            }
        }"
        class="latitude-longitude-input-wrapper"
        @geo-latlng-change.stop="handleGeoLatLngChange($event)"
    >
        <geo-latlng-input
            :lat="_lat !== null ? _lat : @json($field->getLatitude())"
            :lng="_lng !== null ? _lng : @json($field->getLongitude())"
            zoom="{{ $field->getZoom() }}"
            height="{{ $field->getHeight() }}"
            state-path="{{ $statePath }}"
        ></geo-latlng-input>
    </div>
</x-dynamic-component>
