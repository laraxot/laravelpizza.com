{{-- Geo wizard address-field geolocation — Alpine factory + Nominatim. --}}
{{-- Extracted partial: shallow nesting for claude-audit static gate. --}}
{{-- Canon: Modules/Geo/docs/wiki — Fixcity segnalazione wizard address UX. --}}
<script>
(function() {
    async function reverseGeocode(lat, lng, locale) {
        const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=${locale}`,
        );
        const data = await response.json();
        return data.display_name || null;
    }

    async function applyWizardAddress(displayName, messages) {
        const component = window.Livewire?.all?.()?.[0];
        if (!component) {
            return;
        }
        component.$set('data.address', displayName);
    }

    /** Apply reverse-geocoded address to the wizard Livewire component. */
    async function applyGeolocationToWizard(position, locale, messages) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        const displayName = await reverseGeocode(lat, lng, locale);
        if (!displayName) {
            alert(messages.notFound);
            return;
        }
        await applyWizardAddress(displayName, messages);
    }

    window.useMyLocation = function useMyLocation() {
        const locale = @json(app()->getLocale());
        const messages = {
            notSupported: @json(__('fixcity::segnalazione.geolocation.not_supported')),
            notFound: @json(__('fixcity::segnalazione.geolocation.address_not_found')),
            error: @json(__('fixcity::segnalazione.geolocation.error')),
            permissionDenied: @json(__('fixcity::segnalazione.geolocation.permission_denied')),
        };

        return {
            loading: false,
            getLocation() {
                if (this.loading) {
                    return;
                }
                this.loading = true;

                if (!navigator.geolocation) {
                    alert(messages.notSupported);
                    this.loading = false;
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    (position) => { void this.onPosition(position); },
                    () => this.onGeoError(),
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0,
                    },
                );
            },
            async onPosition(position) {
                try {
                    await applyGeolocationToWizard(position, locale, messages);
                } catch {
                    alert(messages.error);
                } finally {
                    this.loading = false;
                }
            },
            onGeoError() {
                alert(messages.permissionDenied);
                this.loading = false;
            },
        };
    };
})();
</script>
