@php
/** @var \Modules\Geo\Filament\Forms\Components\MapPositioner $field */
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
                    this._lat = val?.latitude ?? null;
                    this._lng = val?.longitude ?? null;
                });
            },

            handlePositionChanged(event) {
                const { latitude, longitude } = event.detail;
                this._suppressUpdate = true;
                this._lat = latitude;
                this._lng = longitude;
                this.$wire.$set('{{ $statePath }}', { latitude, longitude });
                setTimeout(() => { this._suppressUpdate = false; }, 350);
            }
        }"
        class="map-positioner-field-wrapper"
        @position-changed.stop="handlePositionChanged($event)"
    >
        <map-positioner-lit
            :latitude="_lat !== null ? _lat : @json($field->getLatitude())"
            :longitude="_lng !== null ? _lng : @json($field->getLongitude())"
            zoom="{{ $field->getZoom() }}"
            height="{{ $field->getHeight() }}"
        ></map-positioner-lit>
    </div>
</x-dynamic-component>
