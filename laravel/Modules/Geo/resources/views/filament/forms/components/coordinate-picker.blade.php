@php
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
                    provider: payload.provider ?? 'nominatim',
                    raw: payload.raw ?? detail.result ?? this.state?.raw ?? null,
                };

                @if($field->hasReverseGeocoding())
                if (latitude !== null && longitude !== null) {
                    void this.reverseGeocode(latitude, longitude);
                }
                @endif
            },

            handleFullscreenChanged(event) {
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
                            provider: result.provider ?? 'nominatim',
                        };
                    }
                } catch (e) {}
            }
        }"
        class="coordinate-picker-field-wrapper space-y-2"
        @coords-changed.stop="handleCoordsChanged($event)"
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
    </div>
</x-dynamic-component>
