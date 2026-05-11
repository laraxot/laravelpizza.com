@php
    $sprite = $sprite ?? '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg';
@endphp

{{-- Address field with geolocation button — Design Comuni parity --}}
{{-- Owned by Geo module: geolocation is a cross-cutting geo-spatial concern --}}
<div class="cmp-card mb-40">
    <div class="card has-bkg-grey shadow-sm p-big p-lg-4">
        <div class="card-header border-0 p-0 mb-lg-20 m-0">
            <div class="d-flex">
                <h2 class="title-xxlarge mb-1">{{ __('geo::address.fields.address.label') }}</h2>
            </div>
            <p class="subtitle-small mb-0">{{ __('geo::address.fields.address.placeholder') }}</p>
        </div>
        <div class="card-body p-0">
            <div class="form-group bg-white p-3 mb-0 mt-3">
                <label class="label-input d-none mb-2" for="wizard-address">{{ __('geo::address.fields.address.label') }} *</label>
                <input
                    type="text"
                    class="form-control"
                    id="wizard-address"
                    wire:model.live="data.address"
                    placeholder="{{ __('geo::address.fields.address.placeholder') }}"
                    required
                >
                <div class="link-wrapper mt-3">
                    <a
                        class="list-item active icon-left"
                        href="#"
                        x-on:click.prevent="useMyLocation()"
                        aria-label="{{ __('geo::address.fields.use_my_location.label') }}"
                    >
                        <span class="list-item-title-icon-wrapper">
                            <svg class="icon icon-sm icon-primary mb-1" aria-hidden="true">
                                <use href="{{ $sprite }}#it-map-marker"></use>
                            </svg>
                            <span class="list-item-title t-primary">{{ __('geo::address.fields.use_my_location.label') }}</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Geolocation script — scoped to this component --}}
<script>
function useMyLocation() {
    if (!navigator.geolocation) {
        alert('{{ __('geo::address.geolocation.not_supported') }}');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Reverse geocoding via Nominatim (OpenStreetMap) — free, no API key
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language={{ app()->getLocale() }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        // Update Livewire state via window.Livewire (works outside @this context)
                        const component = window.Livewire?.components?.components()?.find(c =>
                            c.el.closest('.fi-sch-step') !== null || c.el.querySelector('#wizard-address') !== null
                        );
                        if (component) {
                            component.set('data.address', data.display_name);
                        }
                    } else {
                        alert('{{ __('geo::address.geolocation.address_not_found') }}');
                    }
                })
                .catch(error => {
                    console.error('Geolocation error:', error);
                    alert('{{ __('geo::address.geolocation.error') }}');
                });
        },
        function(error) {
            console.error('Geolocation error:', error);
            alert('{{ __('geo::address.geolocation.permission_denied') }}');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}
</script>
