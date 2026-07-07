@php
/** @var \Modules\Geo\Filament\Forms\Components\GeopointPicker $field */
$statePath = $field->getStatePath();
$id = $field->getId();
<<<<<<< HEAD
$state = $field->getState();
$initLat = is_array($state) ? ($state['latitude'] ?? null) : null;
$initLng = is_array($state) ? ($state['longitude'] ?? null) : null;
// Force valid height
$height = $field->getHeight() ?: '400px';
@endphp

<!-- Remove guard directive to ensure map container persistence -->
<div class="map-container" style="--map-height: {{ $height }}">
    <div class="geopoint-leaflet-pane">
        <!-- Map content will be rendered here by GeopointPickerLit -->
    </div>

    <div x-data="{
            _lat: @json($initLat),
            _lng: @json($initLng),
            _suppressUpdate: false,
            _isFullscreen: false,
            address: '',
            structured: null,

            init() {
                // Force current position on load
                this.$wire.$watch('{{ $statePath }}', (val) => {
                    if (this._suppressUpdate) return;
                    this._lat = (val?.latitude !== undefined && val?.latitude !== null) ? parseFloat(val.latitude) : null;
                    this._lng = (val?.longitude !== undefined && val?.longitude !== null) ? parseFloat(val.longitude) : null;
                    if (this._lat && this._lng && !this.address) {
                        void this.reverseGeocode(this._lat, this._lng);
                    }
                });
            },

                async searchAddress() {
                    if (!this.searchQuery || this.searchQuery.length < 3) return;
                    this.isSearching = true;
                    try {
                        const results = await this.$wire.callSchemaComponentMethod(
                            '{{ $id }}',
                            'searchAddress',
                            { query: this.searchQuery }
                        );
                        if (results && results.length > 0) {
                            this.searchResults = results;
                            this.showResults = true;
                        }
                    } catch (e) {
                        console.error('Search failed:', e);
                    } finally {
                        this.isSearching = false;
                    }
                },

                selectAddress(result) {
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);
                    this._lat = lat;
                    this._lng = lng;
                    this.address = result.display_name || '';
                    this.searchQuery = result.display_name || '';
                    this.showResults = false;
                    this.searchResults = [];

                    // Update Livewire state
                    const newState = {
                        latitude: lat,
                        longitude: lng,
                        address: this.address,
                    };
                    this.$wire.$set('{{ $statePath }}', newState);

                    // Move map to selected address
                    const picker = this.$el.querySelector('geopoint-picker-lit');
                    if (picker && typeof picker.setCoordinates === 'function') {
                        picker.setCoordinates(lat, lng, 'search');
                    }
                },

                handleGeopointChanged(event) {
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
=======
$height = $field->getHeight() ?: '400px';

$labels = [
    'zoom_in' => __('geo::coordinate-picker.zoom_in'),
    'zoom_out' => __('geo::coordinate-picker.zoom_out'),
    'fullscreen' => __('geo::coordinate-picker.fullscreen'),
    'close_fullscreen'=> __('geo::coordinate-picker.close_fullscreen'),
    'use_location' => __('geo::coordinate-picker.use_my_location'),
    'locating' => __('geo::coordinate-picker.locating'),
    'search' => __('geo::coordinate-picker.search'),
    'search_placeholder' => __('geo::coordinate-picker.search_placeholder'),
    'close_search' => __('geo::coordinate-picker.close_search'),
    'switch_layer' => __('geo::coordinate-picker.switch_layer'),
    'latitude' => __('geo::coordinate-picker.latitude'),
    'longitude' => __('geo::coordinate-picker.longitude'),
    'address' => __('geo::coordinate-picker.address'),
];
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            isFullscreen: false,
            labels: @js($labels),

            handleCoordsChanged(event) {
                const detail = event.detail ?? {};
                const latitude = detail.latitude ?? detail.lat ?? null;
                const longitude = detail.longitude ?? detail.lng ?? null;
                const next = {
                    ...(this.state ?? {}),
                    latitude,
                    longitude,
                    lat: latitude,
                    lng: longitude,
                    source: detail.source ?? this.state?.source ?? null,
                };
                if ('address' in detail) {
                    next.address = detail.address;
                }
                if ('display_name' in detail) {
                    next.display_name = detail.display_name;
                }
                this.state = next;

                @if($field->hasReverseGeocoding())
                if (latitude !== null && longitude !== null) {
                    void this.reverseGeocode(latitude, longitude);
                }
                @endif
            },

            handleAddressSelected(event) {
                const detail = event.detail ?? {};
                const latitude = detail.latitude ?? detail.lat ?? null;
                const longitude = detail.longitude ?? detail.lng ?? null;
                const payload = (detail.payload && typeof detail.payload === 'object') ? detail.payload : {};

                this.state = {
                    ...(this.state ?? {}),
                    ...payload,
                    latitude,
                    longitude,
                    lat: latitude,
                    lng: longitude,
                    address: payload.address ?? detail.address ?? detail.result?.display_name ?? this.state?.address ?? null,
                    address_details: payload.address_details ?? payload.structured ?? this.state?.address_details ?? null,
                    provider: payload.provider ?? 'nominatim',
                    raw: payload.raw ?? detail.result ?? this.state?.raw ?? null,
                };

                @if($field->hasReverseGeocoding())
                if (latitude !== null && longitude !== null) {
                    void this.reverseGeocode(latitude, longitude);
                }
>>>>>>> 40b96bcd6 (.)
                @endif
            },

            handleFullscreenChanged(event) {
<<<<<<< HEAD
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
        class="geopoint-picker-field-wrapper space-y-2"
        @geopoint-changed.stop="handleGeopointChanged($event)"
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
    >
        <geopoint-picker-lit
            :latitude="_lat !== null ? _lat : @json($field->getLatitude())"
            :longitude="_lng !== null ? _lng : @json($field->getLongitude())"
            zoom="{{ $field->getZoom() }}"
            height="{{ $height }}"
            show-search="{{ $field->showSearch() ? 'true' : 'false' }}"
        ></geopoint-picker-lit>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[10px] sm:text-xs text-gray-500 bg-gray-50 p-2 rounded-md border border-gray-100"
            x-show="!_isFullscreen"
=======
                this.isFullscreen = event.detail.isFullscreen;
            },

            async reverseGeocode(lat, lng) {
                try {
                    let result = await this.$wire.callSchemaComponentMethod('{{ $id }}', 'reverseGeocode', { latitude: lat, longitude: lng });
                    if (typeof result === 'string') {
                        result = { display_name: result, address: result };
                    }
                    if (result && typeof result === 'object') {
                        this.state = {
                            ...(this.state ?? {}),
                            ...result,
                            latitude: lat,
                            longitude: lng,
                            lat,
                            lng,
                            address: result.display_name ?? result.address ?? this.state?.address ?? null,
                            address_details: result.structured ?? result.address_details ?? this.state?.address_details ?? null,
                            provider: result.provider ?? 'nominatim',
                        };
                    }
                } catch (_e) {}
            }
        }"
        class="geopoint-picker-field-wrapper space-y-2"
        @coords-changed.stop="handleCoordsChanged($event)"
        @address-selected.stop="handleAddressSelected($event)"
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
    >
        <div wire:ignore class="map-container-wrapper p-0 m-0" style="width: 100%; max-width: none; height: {{ $height }};">
            <coordinate-picker-lit
                :state="state"
                zoom="{{ $field->getZoom() }}"
                height="{{ $height }}"
                x-bind:show-search="@js($field->isSearchVisible())"
                geolocate-when-empty="{{ $field->getGeolocateWhenEmpty() ? 'true' : 'false' }}"
                labels='@json($labels)'
            ></coordinate-picker-lit>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[10px] sm:text-xs text-gray-500 bg-gray-50 p-2 rounded-md border border-gray-100"
            x-show="!isFullscreen"
>>>>>>> 40b96bcd6 (.)
            x-transition:enter="transition ease-out duration-200"
            x-transition:leave="transition ease-in duration-150"
        >
            <div class="flex flex-wrap gap-x-4 gap-y-1">
<<<<<<< HEAD
                <span>Lat: <strong class="text-gray-700" x-text="_lat !== null ? Number(_lat).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong class="text-gray-700" x-text="_lng !== null ? Number(_lng).toFixed(6) : '--'"></strong></span>
            </div>
            <div class="truncate max-w-full sm:max-w-[400px]" x-show="address" :title="address">
                <span x-text="address"></span>
            </div>
        </div>
    </div>
</div>
=======
                <span>Lat: <strong class="text-gray-700" x-text="(state && (state.latitude != null || state.latitude === 0)) ? Number(state.latitude).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong class="text-gray-700" x-text="(state && (state.longitude != null || state.longitude === 0)) ? Number(state.longitude).toFixed(6) : '--'"></strong></span>
            </div>
            <div class="truncate max-w-full sm:max-w-[400px]" x-show="state?.address" :title="state?.address || ''">
                <span x-text="state?.address || ''"></span>
            </div>
        </div>
    </div>
</x-dynamic-component>
>>>>>>> 40b96bcd6 (.)
