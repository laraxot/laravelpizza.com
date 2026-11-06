@php
/** @var \Modules\Geo\Filament\Forms\Components\GeopointPicker $field */
$statePath = $field->getStatePath();
$id = $field->getId();
$height = $field->getHeight() ?: '400px';

$labels = [
    'zoom_in' => __('geo::coordinate-picker.zoom_in'),
    'zoom_out' => __('geo::coordinate-picker.zoom_out'),
    'fullscreen' => __('geo::coordinate-picker.fullscreen'),
    'close_fullscreen'=> __('geo::coordinate-picker.close_fullscreen'),
    'use_location' => __('geo::coordinate-picker.use_my_location'),
    'locating' => __('geo::coordinate-picker.locating'),
    'location_unavailable' => __('geo::coordinate-picker.location_unavailable'),
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

                // The Lit map already reverse-geocodes client-side; do not
                // dispatch a second Livewire schema RPC from the wrapper.
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

                // Search results already contain their address payload.
            },

            handleFullscreenChanged(event) {
                this.isFullscreen = event.detail.isFullscreen;
            },

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
                @if($field->getGeolocateWhenEmpty()) geolocate-when-empty @endif
                default-view='@json($field->getMapDefaultView())'
                labels='@json($labels)'
            ></coordinate-picker-lit>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[10px] sm:text-xs text-gray-500 bg-gray-50 p-2 rounded-md border border-gray-100"
            x-show="!isFullscreen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:leave="transition ease-in duration-150"
        >
            <div class="flex flex-wrap gap-x-4 gap-y-1">
                <span>{{ __('geo::coordinate-picker.latitude_abbr') }}: <strong class="text-gray-700" x-text="(state && (state.latitude != null || state.latitude === 0)) ? Number(state.latitude).toFixed(6) : '--'"></strong></span>
                <span>{{ __('geo::coordinate-picker.longitude_abbr') }}: <strong class="text-gray-700" x-text="(state && (state.longitude != null || state.longitude === 0)) ? Number(state.longitude).toFixed(6) : '--'"></strong></span>
            </div>
            <div class="truncate max-w-full sm:max-w-[400px]" x-show="state?.address" :title="state?.address || ''">
                <span x-text="state?.address || ''"></span>
            </div>
        </div>
    </div>
</x-dynamic-component>
