@php
<<<<<<< HEAD
/**
 * CoordinatePicker Blade View
 * Path: laravel/Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php
 * 
 * @var \Modules\Geo\Filament\Forms\Components\CoordinatePicker $field
 */
$statePath = $getStatePath();
$key = $getKey();

$labels = [
    'zoom_in' => __('geo::coordinate-picker.zoom_in'),
    'zoom_out' => __('geo::coordinate-picker.zoom_out'),
    'fullscreen' => __('geo::coordinate-picker.fullscreen'),
    'close_fullscreen'=> __('geo::coordinate-picker.close_fullscreen'),
    'use_location' => __('geo::coordinate-picker.use_my_location'),
    'locating' => __('geo::coordinate-picker.locating'),
    'layers' => [
        'street' => __('geo::coordinate-picker.layers.street'),
        'humanitarian' => __('geo::coordinate-picker.layers.humanitarian'),
        'satellite' => __('geo::coordinate-picker.layers.satellite'),
        'topographic' => __('geo::coordinate-picker.layers.topographic'),
    ],
=======
/** @var \Modules\Geo\Filament\Forms\Components\CoordinatePicker $field */
$statePath = $field->getStatePath();
$id = $field->getId();

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
>>>>>>> 40b96bcd6 (.)
];
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            isFullscreen: false,
<<<<<<< HEAD
            _suppressUpdate: false,

            init() {
                this.$watch('state', (val) => {
                    if (this._suppressUpdate) return;
                    // Force re-sync to Lit if state changes externally
                    const picker = this.$el.querySelector('coordinate-picker-lit');
                    if (picker && val) {
                        picker.lat = val.lat;
                        picker.lng = val.lng;
                    }
                });
            },

            handleCoordsChanged(event) {
                this._suppressUpdate = true;
                const lat = event.detail.lat ?? event.detail.latitude;
                const lng = event.detail.lng ?? event.detail.longitude;

                if (!Number.isFinite(Number(lat)) || !Number.isFinite(Number(lng))) {
                    this._suppressUpdate = false;
                    return;
                }
                
                this.state = {
                    ...(this.state ?? {}),
                    lat: lat,
                    lng: lng,
                    latitude: lat,
                    longitude: lng,
                };
                this.$wire.set(@js($statePath . '.lat'), lat, false);
                this.$wire.set(@js($statePath . '.lng'), lng, false);
                this.$wire.set(@js($statePath . '.latitude'), lat, false);
                this.$wire.set(@js($statePath . '.longitude'), lng, false);

                @if($field->hasReverseGeocoding())
                void this.reverseGeocode(lat, lng);
                @endif
                
                setTimeout(() => { this._suppressUpdate = false; }, 350);
=======
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
                    provider: payload.provider ?? 'nominatim',
                    raw: payload.raw ?? detail.result ?? this.state?.raw ?? null,
                };

                @if($field->hasReverseGeocoding())
                if (latitude !== null && longitude !== null) {
                    void this.reverseGeocode(latitude, longitude);
                }
                @endif
>>>>>>> 40b96bcd6 (.)
            },

            handleFullscreenChanged(event) {
                this.isFullscreen = event.detail.isFullscreen;
            },

<<<<<<< HEAD
            handleAddressSelected(event) {
                const address = event.detail.address || event.detail.result?.display_name || '';
                if (!address) return;
                this.state = {
                    ...(this.state ?? {}),
                    address: address,
                };
                this.$wire.set(@js($statePath . '.address'), address, false);
            },

            async reverseGeocode(lat, lng) {
                try {
                    const result = await this.$wire.callSchemaComponentMethod(@js($key), 'reverseGeocode', { lat: lat, lng: lng });
                    if (result) {
                        this.state = { ...(this.state ?? {}), ...result };
                        Object.entries(result).forEach(([key, value]) => {
                            this.$wire.set(`${@js($statePath)}.${key}`, value, false);
                        });
=======
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
                            provider: result.provider ?? 'nominatim',
                        };
>>>>>>> 40b96bcd6 (.)
                    }
                } catch (e) {}
            }
        }"
        class="coordinate-picker-field-wrapper space-y-2"
        @coords-changed.stop="handleCoordsChanged($event)"
<<<<<<< HEAD
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
        @address-selected.stop="handleAddressSelected($event)"
    >
        {{-- Lit Component Map --}}
        <div wire:ignore class="map-container-wrapper overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700" 
             :style="{ height: isFullscreen ? '100vh' : '{{ $field->getHeight() }}' }">
            <coordinate-picker-lit
                :lat="state?.lat ?? state?.latitude"
                :lng="state?.lng ?? state?.longitude"
                .state="state"
                zoom="{{ $field->getZoom() }}"
                @if($field->getGeolocateWhenEmpty()) geolocate-when-empty @endif
                .labels='@json($labels)'
            ></coordinate-picker-lit>
        </div>

        {{-- Readout Summary --}}
        <div class="rounded-lg bg-gray-50 p-2 text-[11px] text-gray-500 dark:bg-white/5 dark:border-white/10 border border-gray-100">
            <div class="flex flex-wrap gap-x-4">
                <span>Lat: <strong x-text="(state.lat ?? state.latitude) ? Number(state.lat ?? state.latitude).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong x-text="(state.lng ?? state.longitude) ? Number(state.lng ?? state.longitude).toFixed(6) : '--'"></strong></span>
            </div>
            <template x-if="state.address">
                <div class="mt-1 truncate max-w-full" :title="state.address">
                    <x-heroicon-o-map-pin class="inline-block h-3 w-3 mr-1" />
                    <span x-text="state.address"></span>
                </div>
            </template>
        </div>

        {{-- Accessibility Live Region --}}
        <div aria-live="polite" class="sr-only">
            <span x-text="`Lat: ${state.lat || '--'}, Lng: ${state.lng || '--'}${state.address ? ', Address: ' + state.address : ''}`"></span>
        </div>
=======
        @address-selected.stop="handleAddressSelected($event)"
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
    >
        {{-- Lit Component --}}
        {{-- 🛡️ wire:ignore CRITICAL: prevents Livewire from destroying map DOM on re-renders --}}
        <div wire:ignore class="map-container-wrapper p-0 m-0" style="width: 100%; max-width: none; height: {{ $field->getHeight() }};">
            <coordinate-picker-lit
                :state="state"
                zoom="{{ $field->getZoom() }}"
                height="{{ $field->getHeight() }}"
                show-search
                geolocate-when-empty="{{ $field->getGeolocateWhenEmpty() ? 'true' : 'false' }}"
                labels='@json($labels)'
            ></coordinate-picker-lit>
        </div>

        {{-- Readout Summary — visible in normal flow under the map; full payload is preserved in state for persistence --}}
            <div class="geo-coordinate-readout" aria-live="polite">
                <div class="geo-coordinate-readout__coords">
                    <span><span x-text="labels?.latitude || 'Lat'"></span>: <strong x-text="(state && (state.latitude || state.latitude === 0)) ? Number(state.latitude).toFixed(6) : '--'"></strong></span>
                    <span><span x-text="labels?.longitude || 'Lng'"></span>: <strong x-text="(state && (state.longitude || state.longitude === 0)) ? Number(state.longitude).toFixed(6) : '--'"></strong></span>
                </div>
                <div class="geo-coordinate-readout__address" :title="state?.address || ''">
                    <x-heroicon-o-map-pin class="geo-coordinate-readout__icon" />
                    <span><span x-text="labels?.address || 'Address'"></span>: <strong x-text="state?.address || '--'"></strong></span>
                </div>
            </div>
>>>>>>> 40b96bcd6 (.)
    </div>
</x-dynamic-component>
