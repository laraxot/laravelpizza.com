@php
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
];
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            isFullscreen: false,
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
            },

            handleFullscreenChanged(event) {
                this.isFullscreen = event.detail.isFullscreen;
            },

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
                    }
                } catch (e) {}
            }
        }"
        class="coordinate-picker-field-wrapper space-y-2"
        @coords-changed.stop="handleCoordsChanged($event)"
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
    </div>
</x-dynamic-component>
