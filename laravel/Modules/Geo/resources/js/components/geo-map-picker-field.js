/**
 * Alpine.js component for GeoMapPicker field orchestration.
 * Interacts with the <geo-map-picker> web component.
 */
export default (config) => ({
    latitude: config.latitude,
    longitude: config.longitude,
    geolocateWhenEmpty: config.geolocateWhenEmpty,
    reverseGeocoding: config.reverseGeocoding,
    zoom: config.zoom,
    latitudeStatePath: config.latitudeStatePath,
    longitudeStatePath: config.longitudeStatePath,
    formattedAddress: '',
    statusLabel: 'Waiting for coordinates',
    hasServerErrors: config.hasServerErrors,
    reverseGeocodeTimer: null,

    init() {
        this.syncToMap(true);

        this.$watch('latitude', () => {
            this.updateStatus();
            this.syncToMap();
            this.scheduleReverseGeocoding();
        });

        this.$watch('longitude', () => {
            this.updateStatus();
            this.syncToMap();
            this.scheduleReverseGeocoding();
        });

        this.updateStatus();
        this.scheduleReverseGeocoding();
    },

    handleCoordsChanged(event) {
        const nextLatitude = this.normalize(event.detail.latitude);
        const nextLongitude = this.normalize(event.detail.longitude);

        if (nextLatitude !== null) {
            this.latitude = nextLatitude;
        }

        if (nextLongitude !== null) {
            this.longitude = nextLongitude;
        }
    },

    syncToMap(recenter = false) {
        if (!this.$refs.map) {
            return;
        }

        // map-picker-lit.js web component properties
        this.$refs.map.zoom = this.zoom;
        
        // Use applyExternalLocation if available, or set lat/lng directly
        if (typeof this.$refs.map.applyExternalLocation === 'function') {
            this.$refs.map.applyExternalLocation({
                latitude: this.latitude,
                longitude: this.longitude
            });
        } else {
            this.$refs.map.latitude = this.latitude;
            this.$refs.map.longitude = this.longitude;
        }
    },

    scheduleReverseGeocoding() {
        if (!this.reverseGeocoding || !this.coordinatesAreValid()) {
            this.formattedAddress = '';
            return;
        }

        window.clearTimeout(this.reverseGeocodeTimer);

        this.reverseGeocodeTimer = window.setTimeout(async () => {
            const url = new URL('https://nominatim.openstreetmap.org/reverse');
            url.searchParams.set('format', 'jsonv2');
            url.searchParams.set('lat', this.latitude);
            url.searchParams.set('lon', this.longitude);
            url.searchParams.set('zoom', '18');
            url.searchParams.set('addressdetails', '1');

            try {
                const response = await fetch(url, {
                    headers: {
                        Accept: 'application/json',
                    },
                });

                if (!response.ok) {
                    return;
                }

                const payload = await response.json();
                this.formattedAddress = payload.display_name ?? '';
            } catch (_error) {
                this.formattedAddress = '';
            }
        }, 400);
    },

    coordinatesAreValid() {
        return this.latitudeValid && this.longitudeValid;
    },

    normalize(value) {
        if (value === null || value === undefined || value === '') {
            return null;
        }

        const normalized = Number.parseFloat(value);

        return Number.isFinite(normalized) ? Number.parseFloat(normalized.toFixed(6)) : null;
    },

    get latitudeValid() {
        return this.latitude !== null && this.latitude >= -90 && this.latitude <= 90;
    },

    get longitudeValid() {
        return this.longitude !== null && this.longitude >= -180 && this.longitude <= 180;
    },

    updateStatus() {
        if (this.hasServerErrors) {
            this.statusLabel = 'Validation error from server';
            return;
        }

        if (this.coordinatesAreValid()) {
            this.statusLabel = 'Coordinates synced';
            return;
        }

        if (this.latitude === null && this.longitude === null) {
            this.statusLabel = 'Waiting for geolocation or manual input';
            return;
        }

        this.statusLabel = 'Invalid coordinates';
    },

    inputClass(isValid) {
        return {
            'border-success-500 focus:border-success-500 focus:ring-success-500': isValid && !this.hasServerErrors,
            'border-danger-500 focus:border-danger-500 focus:ring-danger-500': !isValid || this.hasServerErrors,
            'border-gray-300 focus:border-primary-500 focus:ring-primary-500': !this.coordinatesAreValid() && !this.hasServerErrors,
        };
    },

    statusDotClass() {
        if (this.hasServerErrors || !this.coordinatesAreValid()) {
            return 'bg-danger-500';
        }

        return 'bg-success-500';
    },
});
