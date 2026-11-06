{{-- Geo address-input geolocation — Alpine factory + Nominatim reverse geocode. --}}
{{-- Extracted partial: shallow nesting for claude-audit static gate. --}}
{{-- Canon: Modules/Geo/docs/wiki — Filament address field geolocation UX. --}}
<script>
(function() {
    /** Reverse-geocode GPS coordinates via Nominatim (locale-aware). */
    async function reverseGeocodeDisplayName(lat, lng, locale) {
        const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=${locale}`,
            { headers: { 'Accept-Language': locale } },
        );
        const data = await response.json();
        return data.display_name || null;
    }

    /** Resolve geolocation error code to a user-facing alert message. */
    function geolocationErrorMessage(error, messages) {
        if (error.code === GeolocationPositionError.TIMEOUT) {
            return messages.timeout;
        }
        if (error.code === GeolocationPositionError.POSITION_UNAVAILABLE) {
            return messages.unavailable;
        }
        return messages.permissionDenied;
    }

    /** Apply reverse-geocoded address to the Livewire state path. */
    async function applyGeolocationToField(livewire, statePath, position, locale, messages) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        const displayName = await reverseGeocodeDisplayName(lat, lng, locale);
        if (!displayName) {
            alert(messages.notFound);
            return;
        }
        livewire.set(statePath, displayName);
    }

    window.getAddressLocation = function(livewire, statePath) {
        const locale = @json($locale);
        const messages = {
            notFound: @json($geolocationAddressNotFound),
            error: @json($geolocationError),
            permissionDenied: @json($geolocationPermissionDenied),
            timeout: @json($geolocationTimeout),
            unavailable: @json($geolocationUnavailable),
            notSupported: @json($geolocationNotSupported),
        };

        return {
            loading: false,
            _lw: livewire,
            _path: statePath,

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
                    (error) => this.onGeoError(error),
                    {
                        enableHighAccuracy: true,
                        timeout: 20000,
                        maximumAge: 0,
                    },
                );
            },

            async onPosition(position) {
                try {
                    await applyGeolocationToField(this._lw, this._path, position, locale, messages);
                } catch {
                    alert(messages.error);
                } finally {
                    this.loading = false;
                }
            },

            onGeoError(error) {
                alert(geolocationErrorMessage(error, messages));
                this.loading = false;
            },
        };
    };
})();
</script>
