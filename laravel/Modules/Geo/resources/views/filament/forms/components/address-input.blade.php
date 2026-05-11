@php
    $sprite = $sprite ?? '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg';
    $statePath = $getStatePath();
    $placeholder = $placeholder ?? __('geo::address.fields.address.placeholder');
    $geolocationNotSupported = __('geo::address.geolocation.not_supported');
    $geolocationAddressNotFound = __('geo::address.geolocation.address_not_found');
    $geolocationError = __('geo::address.geolocation.error');
    $geolocationPermissionDenied = __('geo::address.geolocation.permission_denied');
    $geolocationTimeout = __('geo::address.geolocation.timeout');
    $geolocationUnavailable = __('geo::address.geolocation.unavailable');
    $locale = app()->getLocale();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="cmp-card">
        <div class="card has-bkg-grey shadow-sm p-big p-lg-4">
            <div class="card-body p-0">
                <div class="form-group bg-white p-3 mb-0 mt-3" x-data="getAddressLocation(@this, '{{ $statePath }}')">
                    <input
                        type="text"
                        wire:model.live="{{ $statePath }}"
                        id="{{ $statePath }}"
                        class="form-control @error($statePath) is-invalid @enderror"
                        placeholder="{{ $placeholder }}"
                        @if($field->isRequired()) required @endif
                    >
                    @error($statePath)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="link-wrapper mt-3">
                        <a
                            class="list-item active icon-left"
                            href="#"
                            x-on:click.prevent="getLocation()"
                            :class="{ 'opacity-50 pointer-events-none': loading }"
                            :aria-busy="loading ? 'true' : 'false'"
                            :aria-disabled="loading ? 'true' : 'false'"
                            aria-label="{{ __('geo::address.fields.use_my_location.label') }}"
                        >
                            <span class="list-item-title-icon-wrapper">
                                <template x-if="loading">
                                    <svg class="icon icon-sm icon-primary mb-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <template x-if="!loading">
                                    <svg class="icon icon-sm icon-primary mb-1" aria-hidden="true">
                                        <use href="{{ $sprite }}#it-map-marker"></use>
                                    </svg>
                                </template>
                                <span class="list-item-title t-primary" x-show="!loading">{{ __('geo::address.fields.use_my_location.label') }}</span>
                                <span class="list-item-title t-primary" x-show="loading" role="status" aria-live="polite">{{ __('geo::address.geolocation.locating') }}</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>

<script>
/**
 * getLocation — Geolocation with visible spinner (Alpine v3 inline component).
 *
 * Philosophy: "Never leave the user wondering."
 * - Immediate spinner on click → user knows system is working
 * - Spinner stays visible during entire flow (GPS + reverse geocoding)
 * - Spinner disappears on success OR error (always via finally)
 * - No double-clicks (early return if already loading)
 *
 * Design Comuni compliance: Bootstrap Italia icon + Tailwind animate-spin.
 *
 * Called from x-on:click with (livewire, statePath) parameters.
 *
 * @this Blade directive resolves to current Livewire component instance.
 */
(function() {
    window.getAddressLocation = function(livewire, statePath) {
        return {
            loading: false,
            _lw: livewire,
            _path: statePath,

            async getLocation() {
                // Prevent double-clicks
                if (this.loading) return;
                this.loading = true;

                if (!navigator.geolocation) {
                    alert('{{ $geolocationNotSupported }}');
                    this.loading = false;
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        try {
                            const response = await fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language={{ $locale }}`,
                                { headers: { 'Accept-Language': '{{ $locale }}' } }
                            );
                            const data = await response.json();
                            if (data.display_name) {
                                this._lw.set(this._path, data.display_name);
                            } else {
                                alert('{{ $geolocationAddressNotFound }}');
                            }
                        } catch (error) {
                            console.error('[Geo] Reverse geocoding error:', error);
                            alert('{{ $geolocationError }}');
                        } finally {
                            this.loading = false;
                        }
                    },
                    (error) => {
                        console.error('[Geo] Geolocation error:', error);
                        let message = '{{ $geolocationPermissionDenied }}';
                        if (error.code === GeolocationPositionError.TIMEOUT) {
                            message = '{{ $geolocationTimeout }}';
                        } else if (error.code === GeolocationPositionError.POSITION_UNAVAILABLE) {
                            message = '{{ $geolocationUnavailable }}';
                        }
                        alert(message);
                        this.loading = false;
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 20000,
                        maximumAge: 0
                    }
                );
            }
        };
    };
})();
</script>
