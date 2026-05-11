import L from 'leaflet';
import { LitElement, html } from 'lit';

delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
    iconRetinaUrl: new URL('leaflet/dist/images/marker-icon-2x.png', import.meta.url).href,
    iconUrl: new URL('leaflet/dist/images/marker-icon.png', import.meta.url).href,
    shadowUrl: new URL('leaflet/dist/images/marker-shadow.png', import.meta.url).href,
});

const DEFAULT_CENTER = {
    latitude: 41.9028,
    longitude: 12.4964,
};

const reverseGeocode = async (latitude, longitude) => {
    const url = new URL('https://nominatim.openstreetmap.org/reverse');
    url.searchParams.set('format', 'jsonv2');
    url.searchParams.set('lat', String(latitude));
    url.searchParams.set('lon', String(longitude));
    url.searchParams.set('zoom', '18');
    url.searchParams.set('addressdetails', '1');

    const response = await fetch(url, {
        headers: {
            Accept: 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error(`Reverse geocoding failed with status ${response.status}`);
    }

    return response.json();
};

const roundCoordinate = (value) => {
    const numericValue = Number.parseFloat(String(value));

    if (!Number.isFinite(numericValue)) {
        return null;
    }

    return Number.parseFloat(numericValue.toFixed(6));
};

const coordinatesSignature = (latitude, longitude) => {
    if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
        return null;
    }

    return `${latitude.toFixed(6)}:${longitude.toFixed(6)}`;
};

class GeoMapPickerElement extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        zoom: { type: Number },
        geolocateWhenEmpty: { type: Boolean, attribute: 'geolocate-when-empty' },
    };

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.zoom = 15;
        this.geolocateWhenEmpty = true;
        this.map = null;
        this.marker = null;
        this.resizeObserver = null;
        this.intersectionObserver = null;
        this.fullscreenHandler = null;
        this.lastSignature = null;
        this.isApplyingExternalState = false;
    }

    render() {
        return html`
            <div class="geo-map-picker-element__shell">
                <div class="geo-map-picker-element__toolbar">
                    <div class="geo-map-picker-element__title">
                        <span class="geo-map-picker-element__eyebrow">Map Picker</span>
                        <span class="geo-map-picker-element__subtitle">Leaflet + Lit web component</span>
                    </div>
                    <button
                        type="button"
                        class="geo-map-picker-element__fullscreen"
                        @click=${this.toggleFullscreen}
                    >
                        Fullscreen
                    </button>
                </div>
                <div class="geo-map-picker-element__map" id="map"></div>
            </div>
        `;
    }

    createRenderRoot() {
        return this;
    }

    firstUpdated() {
        this.initializeMap();
        this.bindObservers();
    }

    updated(changedProperties) {
        if (!this.map) {
            return;
        }

        if (changedProperties.has('latitude') || changedProperties.has('longitude')) {
            this.syncFromExternalState();
        }

        if (changedProperties.has('zoom') && Number.isFinite(this.zoom)) {
            this.map.setZoom(this.zoom);
        }
    }

    disconnectedCallback() {
        super.disconnectedCallback();

        this.resizeObserver?.disconnect();
        this.intersectionObserver?.disconnect();

        if (this.fullscreenHandler) {
            document.removeEventListener('fullscreenchange', this.fullscreenHandler);
        }

        this.map?.remove();
        this.map = null;
        this.marker = null;
    }

    bindObservers() {
        this.resizeObserver = new ResizeObserver(() => {
            this.invalidateMapSize();
        });

        this.resizeObserver.observe(this);

        this.intersectionObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    this.invalidateMapSize();
                }
            });
        }, { threshold: 0.1 });

        this.intersectionObserver.observe(this);

        this.fullscreenHandler = () => {
            window.setTimeout(() => this.invalidateMapSize(), 180);
        };

        document.addEventListener('fullscreenchange', this.fullscreenHandler);
    }

    initializeMap() {
        const center = this.hasCoordinates()
            ? [this.latitude, this.longitude]
            : [DEFAULT_CENTER.latitude, DEFAULT_CENTER.longitude];

        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19,
        });

        const satelliteLayer = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            {
                attribution: 'Tiles &copy; Esri',
                maxZoom: 19,
            },
        );

        this.map = L.map(this.renderRoot.querySelector('#map'), {
            center,
            zoom: this.zoom,
            layers: [streetLayer],
        });

        L.control.layers(
            {
                Street: streetLayer,
                Satellite: satelliteLayer,
            },
            {},
            { position: 'topright' },
        ).addTo(this.map);

        this.marker = L.marker(center, {
            draggable: true,
        }).addTo(this.map);

        this.marker.on('dragstart', () => {
            this.isApplyingExternalState = false;
        });

        this.marker.on('dragend', () => {
            const markerCoordinates = this.marker?.getLatLng();

            if (!markerCoordinates) {
                return;
            }

            this.applyCoordinates(markerCoordinates.lat, markerCoordinates.lng, {
                source: 'marker',
                recenter: false,
            });
        });

        this.map.on('click', (event) => {
            this.applyCoordinates(event.latlng.lat, event.latlng.lng, {
                source: 'map-click',
                recenter: false,
            });
        });

        this.invalidateMapSize();

        if (this.hasCoordinates()) {
            this.applyCoordinates(this.latitude, this.longitude, {
                source: 'external',
                recenter: true,
                silent: true,
            });

            return;
        }

        if (this.geolocateWhenEmpty && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                this.applyCoordinates(position.coords.latitude, position.coords.longitude, {
                    source: 'geolocation',
                    recenter: true,
                });
            });
        }
    }

    async toggleFullscreen() {
        if (document.fullscreenElement === this) {
            await document.exitFullscreen();
        } else {
            await this.requestFullscreen();
        }

        window.setTimeout(() => this.invalidateMapSize(), 180);
    }

    setCoordinates(latitude, longitude, options = {}) {
        this.applyCoordinates(latitude, longitude, {
            source: 'external',
            recenter: options.recenter ?? true,
            silent: options.silent ?? true,
        });
    }

    syncFromExternalState() {
        if (!this.hasCoordinates()) {
            return;
        }

        this.applyCoordinates(this.latitude, this.longitude, {
            source: 'external',
            recenter: false,
            silent: true,
        });
    }

    applyCoordinates(latitude, longitude, options = {}) {
        const normalizedLatitude = roundCoordinate(latitude);
        const normalizedLongitude = roundCoordinate(longitude);

        if (
            normalizedLatitude === null ||
            normalizedLongitude === null ||
            !this.map ||
            !this.marker
        ) {
            return;
        }

        const nextSignature = coordinatesSignature(normalizedLatitude, normalizedLongitude);

        if (nextSignature === null || nextSignature === this.lastSignature) {
            return;
        }

        this.lastSignature = nextSignature;
        this.latitude = normalizedLatitude;
        this.longitude = normalizedLongitude;

        this.marker.setLatLng([normalizedLatitude, normalizedLongitude]);

        if (options.recenter ?? true) {
            this.map.setView([normalizedLatitude, normalizedLongitude], this.map.getZoom(), {
                animate: true,
            });
        }

        if (options.silent ?? false) {
            return;
        }

        this.dispatchEvent(new CustomEvent('coords-changed', {
            bubbles: true,
            composed: true,
            detail: {
                latitude: normalizedLatitude,
                longitude: normalizedLongitude,
                source: options.source ?? 'external',
            },
        }));
    }

    invalidateMapSize() {
        if (!this.map) {
            return;
        }

        window.requestAnimationFrame(() => {
            this.map?.invalidateSize();
        });
    }

    hasCoordinates() {
        return Number.isFinite(this.latitude) && Number.isFinite(this.longitude);
    }
}

if (!window.customElements.get('geo-map-picker')) {
    window.customElements.define('geo-map-picker', GeoMapPickerElement);
}

const registerMapPickerField = () => {
    if (!window.Alpine || window.__geoMapPickerFieldRegistered === true) {
        return;
    }

    window.__geoMapPickerFieldRegistered = true;

    window.Alpine.data('geoMapPickerField', (config) => ({
        latitude: roundCoordinate(config.state?.latitude ?? config.latitude),
        longitude: roundCoordinate(config.state?.longitude ?? config.longitude),
        geolocateWhenEmpty: config.geolocateWhenEmpty,
        reverseGeocoding: config.reverseGeocoding,
        zoom: config.zoom,
        formattedAddress: '',
        statusLabel: 'Waiting for coordinates',
        hasServerErrors: config.hasServerErrors,
        isSyncingFromMap: false,
        reverseGeocodeTimer: null,
        lastMapSignature: null,
        unwatchState: null,

        init() {
            this.unwatchState = this.$wire?.$watch?.(config.statePath, (state) => {
                const nextLatitude = roundCoordinate(state?.latitude);
                const nextLongitude = roundCoordinate(state?.longitude);
                const nextSignature = coordinatesSignature(nextLatitude, nextLongitude);

                if (nextSignature === null || nextSignature === this.lastMapSignature) {
                    return;
                }

                this.latitude = nextLatitude;
                this.longitude = nextLongitude;
                this.syncToMap(true);
                this.updateStatus();
            });

            this.updateStatus();
            this.syncToMap(true);
            this.scheduleReverseGeocoding();

            this.$watch('latitude', () => {
                if (this.isSyncingFromMap) {
                    this.updateStatus();
                    this.scheduleReverseGeocoding();

                    return;
                }

                this.updateStatus();
                this.syncToMap();
                this.scheduleReverseGeocoding();
            });

            this.$watch('longitude', () => {
                if (this.isSyncingFromMap) {
                    this.updateStatus();
                    this.scheduleReverseGeocoding();

                    return;
                }

                this.updateStatus();
                this.syncToMap();
                this.scheduleReverseGeocoding();
            });
        },

        handleCoordsChanged(event) {
            const nextLatitude = roundCoordinate(event.detail?.latitude);
            const nextLongitude = roundCoordinate(event.detail?.longitude);
            const nextSignature = coordinatesSignature(nextLatitude, nextLongitude);

            if (nextSignature === null || nextSignature === this.lastMapSignature) {
                return;
            }

            this.lastMapSignature = nextSignature;
            this.isSyncingFromMap = true;
            this.latitude = nextLatitude;
            this.longitude = nextLongitude;

            queueMicrotask(() => {
                this.isSyncingFromMap = false;
                this.$wire?.$set?.(config.statePath, {
                    latitude: nextLatitude,
                    longitude: nextLongitude,
                }, false);
                this.updateStatus();
                this.scheduleReverseGeocoding();
            });
        },

        syncToMap(recenter = false) {
            if (!this.$refs.map) {
                return;
            }

            const nextLatitude = roundCoordinate(this.latitude);
            const nextLongitude = roundCoordinate(this.longitude);
            const nextSignature = coordinatesSignature(nextLatitude, nextLongitude);

            this.$refs.map.zoom = this.zoom;
            this.$refs.map.geolocateWhenEmpty = this.geolocateWhenEmpty;

            if (nextSignature === null || nextSignature === this.lastMapSignature) {
                return;
            }

            this.lastMapSignature = nextSignature;
            this.$refs.map.setCoordinates(nextLatitude, nextLongitude, {
                recenter,
                silent: true,
            });
        },

        async performReverseGeocoding() {
            if (!this.coordinatesAreValid()) {
                this.formattedAddress = '';

                return;
            }

            try {
                const payload = await reverseGeocode(this.latitude, this.longitude);
                this.formattedAddress = payload.display_name ?? '';
            } catch (_error) {
                this.formattedAddress = '';
            }
        },

        scheduleReverseGeocoding() {
            if (!this.reverseGeocoding) {
                this.formattedAddress = '';

                return;
            }

            window.clearTimeout(this.reverseGeocodeTimer);

            if (!this.coordinatesAreValid()) {
                this.formattedAddress = '';

                return;
            }

            this.reverseGeocodeTimer = window.setTimeout(() => {
                void this.performReverseGeocoding();
            }, 350);
        },

        coordinatesAreValid() {
            return this.latitudeValid && this.longitudeValid;
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
    }));
};

if (window.Alpine) {
    registerMapPickerField();
} else {
    document.addEventListener('alpine:init', registerMapPickerField, { once: true });
}
