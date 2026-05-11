@php
    $sprite = $sprite ?? '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg';
@endphp

{{-- Address field with geolocation button - Design Comuni parity --}}
<div class="cmp-card mb-40">
    <div class="card has-bkg-grey shadow-sm p-big p-lg-4">
        <div class="card-header border-0 p-0 mb-lg-20 m-0">
            <div class="d-flex">
                <h2 class="title-xxlarge mb-1">{{ __('fixcity::segnalazione.fields.address.label') }}</h2>
            </div>
            <p class="subtitle-small mb-0">{{ __('fixcity::segnalazione.fields.address.placeholder') }}</p>
        </div>
        <div class="card-body p-0">
            <div class="form-group bg-white p-3 mb-0 mt-3">
                <label class="label-input d-none mb-2" for="wizard-address">{{ __('fixcity::segnalazione.fields.address.label') }} *</label>
                <input
                    type="text"
                    class="form-control"
                    id="wizard-address"
                    wire:model.live="data.address"
                    placeholder="{{ __('fixcity::segnalazione.create.address.placeholder') }}"
                    required
                >
                <div class="link-wrapper mt-3">
                    <a
                        class="list-item active icon-left"
                        href="#"
                        x-data="useMyLocation()"
                        x-on:click.prevent="getLocation()"
                        :class="{ 'opacity-50 pointer-events-none': loading }"
                        aria-label="{{ __('fixcity::segnalazione.fields.use_my_location.label') }}"
                    >
                        <span class="list-item-title-icon-wrapper">
                            <template x-if="loading">
                                <svg class="icon icon-sm icon-primary mb-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <template x-if="!loading">
                                <svg class="icon icon-sm icon-primary mb-1" aria-hidden="true">
                                    <use href="{{ $sprite }}#it-map-marker"></use>
                                </svg>
                            </template>
                            <span class="list-item-title t-primary">{{ __('fixcity::segnalazione.fields.use_my_location.label') }}</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Geolocation script - scoped to this component --}}
<script>
function useMyLocation() {
    return {
        loading: false,
        async getLocation() {
            if (this.loading) return;
            this.loading = true;

            if (!navigator.geolocation) {
                alert('{{ __('fixcity::segnalazione.geolocation.not_supported') }}');
                this.loading = false;
                return;
            }

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language={{ app()->getLocale() }}`);
                        const data = await response.json();
                        if (data.display_name) {
                            if (window.Livewire) {
                                const component = window.Livewire.all().first();
                                if (component) {
                                    component.$set('data.address', data.display_name);
                                }
                            }
                        } else {
                            alert('{{ __('fixcity::segnalazione.geolocation.address_not_found') }}');
                        }
                    } catch (error) {
                        console.error('Geolocation error:', error);
                        alert('{{ __('fixcity::segnalazione.geolocation.error') }}');
                    } finally {
                        this.loading = false;
                    }
                },
                (error) => {
                    console.error('Geolocation error:', error);
                    alert('{{ __('fixcity::segnalazione.geolocation.permission_denied') }}');
                    this.loading = false;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }
    };
}
</script>
