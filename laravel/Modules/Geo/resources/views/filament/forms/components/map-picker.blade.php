@php
/** @var \Modules\Geo\Filament\Forms\Components\MapPicker $field */
$statePath = $field->getStatePath();
$id = $field->getId();
$state = $field->getState();
$initLat = is_array($state) ? ($state['latitude'] ?? null) : null;
$initLng = is_array($state) ? ($state['longitude'] ?? null) : null;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
            _lat: @json($initLat),
            _lng: @json($initLng),
            _suppressUpdate: false,
            _isFullscreen: false,
            address: '',
            structured: null,

            init() {
                this.$wire.$watch('{{ $statePath }}', (val) => {
                    if (this._suppressUpdate) return;
                    this._lat = val?.latitude ?? null;
                    this._lng = val?.longitude ?? null;
                    if (val?.latitude && val?.longitude && !this.address) {
                        void this.reverseGeocode(val.latitude, val.longitude);
                    }
                });
            },

            handleCoordsChanged(event) {
                const { latitude, longitude } = event.detail;
                this._suppressUpdate = true;
                this._lat = latitude;
                this._lng = longitude;

                // Update state with structured data
                const newState = {
                    latitude,
                    longitude,
                    address: this.address,
                    address_details: this.structured
                };

                this.$wire.$set('{{ $statePath }}', newState);
                setTimeout(() => { this._suppressUpdate = false; }, 350);

                @if($field->hasReverseGeocoding())
                void this.reverseGeocode(latitude, longitude);
                @endif
            },

            handleFullscreenChanged(event) {
                this._isFullscreen = event.detail.isFullscreen;
            },

            async reverseGeocode(lat, lng) {
                if (!lat || !lng) return;
                try {
                    const result = await this.$wire.callSchemaComponentMethod(
                        '{{ $id }}',
                        'reverseGeocode',
                        { latitude: lat, longitude: lng }
                    );

                    if (result) {
                        this.address = result.display_name || '';
                        this.structured = result.structured || null;

                        // Push structured data back to Livewire state
                        this.$wire.$set('{{ $statePath }}.address', this.address);
                        this.$wire.$set('{{ $statePath }}.address_details', this.structured);
                    } else {
                        this.address = '';
                        this.structured = null;
                    }
                } catch (_e) {
                    this.address = '';
                    this.structured = null;
                }
            }
        }" 
        class="map-picker-field-wrapper space-y-2" 
        @coords-changed.stop="handleCoordsChanged($event)"
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
    >
        <map-picker-lit 
            :latitude="typeof _lat !== 'undefined' && _lat !== null ? _lat : @json($field->getLatitude())"
            :longitude="typeof _lng !== 'undefined' && _lng !== null ? _lng : @json($field->getLongitude())" 
            zoom="{{ $field->getZoom() }}"
            height="{{ $field->getHeight() }}"
        ></map-picker-lit>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[10px] sm:text-xs text-gray-500 bg-gray-50 p-2 rounded-md border border-gray-100"
            x-show="typeof _isFullscreen === 'undefined' || !_isFullscreen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:leave="transition ease-in duration-150"
        >
            <div class="flex flex-wrap gap-x-4 gap-y-1">
                <span>Lat: <strong class="text-gray-700" x-text="typeof _lat !== 'undefined' && _lat !== null ? Number(_lat).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong class="text-gray-700" x-text="typeof _lng !== 'undefined' && _lng !== null ? Number(_lng).toFixed(6) : '--'"></strong></span>
                <template x-if="typeof structured !== 'undefined' && structured?.city">
                    <span>Città: <strong class="text-gray-700" x-text="structured.city"></strong></span>
                </template>
            </div>
            <div class="truncate max-w-full sm:max-w-[400px]" x-show="typeof address !== 'undefined' && address" x-bind:title="typeof address !== 'undefined' ? address : ''">
                <span x-text="typeof address !== 'undefined' ? address : ''"></span>
            </div>
            <template x-if="typeof _lat === 'undefined' || _lat === null">
                <span class="text-orange-500 italic text-xs">{{ __('geo::coordinate-picker.no_position') }}</span>
            </template>
        </div>
    </div>
</x-dynamic-component>
