@php
/** @var \Modules\Geo\Filament\Forms\Components\MapPicker $field */
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
                    address_details: payload.address_details ?? payload.structured ?? this.state?.address_details ?? null,
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
                            address_details: result.structured ?? result.address_details ?? this.state?.address_details ?? null,
                            provider: result.provider ?? 'nominatim',
                        };
                    }
                } catch (_e) {}
            }
        }"
        class="map-picker-field-wrapper space-y-2"
        @coords-changed.stop="handleCoordsChanged($event)"
        @address-selected.stop="handleAddressSelected($event)"
        @fullscreen-changed.stop="handleFullscreenChanged($event)"
    >
        <div wire:ignore class="map-container-wrapper p-0 m-0" style="width: 100%; max-width: none; height: {{ $field->getHeight() }};">
            <coordinate-picker-lit
                :state="state"
                zoom="{{ $field->getZoom() }}"
                height="{{ $field->getHeight() }}"
                x-bind:show-search="@js($field->isSearchVisible())"
                geolocate-when-empty="{{ $field->getGeolocateWhenEmpty() ? 'true' : 'false' }}"
                labels='@json($labels)'
            ></coordinate-picker-lit>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[10px] sm:text-xs text-gray-500 bg-gray-50 p-2 rounded-md border border-gray-100"
            x-show="typeof isFullscreen === 'undefined' || !isFullscreen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:leave="transition ease-in duration-150"
        >
            <div class="flex flex-wrap gap-x-4 gap-y-1">
                <span>Lat: <strong class="text-gray-700" x-text="(state && (state.latitude != null || state.latitude === 0)) ? Number(state.latitude).toFixed(6) : '--'"></strong></span>
                <span>Lng: <strong class="text-gray-700" x-text="(state && (state.longitude != null || state.longitude === 0)) ? Number(state.longitude).toFixed(6) : '--'"></strong></span>
                <template x-if="state?.address_details?.city">
                    <span>Città: <strong class="text-gray-700" x-text="state.address_details.city"></strong></span>
                </template>
            </div>
            <div class="truncate max-w-full sm:max-w-[400px]" x-show="state?.address" x-bind:title="state?.address || ''">
                <span x-text="state?.address || ''"></span>
            </div>
            <template x-if="state?.latitude == null && state?.longitude == null">
                <span class="text-orange-500 italic text-xs">{{ __('geo::coordinate-picker.no_position') }}</span>
            </template>
        </div>
    </div>
</x-dynamic-component>
