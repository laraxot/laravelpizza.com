import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import { mapPickerStyles } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';

/**
 * MapLocationInputLit
 * Simple click-on-map to set location.
 * Zen: Light DOM for stability and rapid interaction.
 */
export class MapLocationInputLit extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        defaultLatitude: { type: Number, attribute: 'default-latitude' },
        defaultLongitude: { type: Number, attribute: 'default-longitude' },
        zoom: { type: Number },
        height: { type: String },
    };

    createRenderRoot() {
        return this;
    }

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.defaultLatitude = 41.9028;
        this.defaultLongitude = 12.4964;
        this.zoom = 13;
        this.height = '300px';

        this._map = null;
        this._marker = null;
        this._mapReady = false;
        this._loading = false;
        this._isProgrammaticUpdate = false;
        this._resizeObserver = null;
    }

    render() {
        return html`
            <style>
                map-location-input-lit { display: block; width: 100%; }
                ${mapPickerStyles}
            </style>
            <div class="map-container" style="--map-height: ${this.height}">
                html`<div class="map-location-pane" style="height: 100%;"></div>`
                
                <div class="loading-overlay ${this._loading ? 'active' : ''}" style="${this._loading ? 'display:flex; opacity:1;' : 'display:none; opacity:0;'}">
                    <div class="loading-spinner"></div>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        this._resizeObserver = new ResizeObserver(() => this._handleResize());
        this._resizeObserver.observe(this);
        requestAnimationFrame(() => this._handleResize());
    }

    updated(changed) {
        if (changed.has('height')) {
            this.invalidateSize();
        }
        if (this._mapReady && (changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
            this._syncMarkerToState(this.latitude, this.longitude);
        }
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this._resizeObserver?.disconnect();
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }

    invalidateSize() {
        if (this._map) {
            setTimeout(() => this._map.invalidateSize({ animate: false }), 150);
        }
    }

    _handleResize() {
        const rect = this.getBoundingClientRect();
        if (rect.width > 0 && rect.height > 0) {
            if (!this._map) {
                this._initMap();
            } else {
                this._map.invalidateSize({ animate: false });
            }
        }
    }

    _initMap() {
        const el = this.querySelector('.map-location-pane');
        if (!el || this._map) return;

        const lat = Number.isFinite(this.latitude) ? this.latitude : this.defaultLatitude;
        const lng = Number.isFinite(this.longitude) ? this.longitude : this.defaultLongitude;

        this._map = L.map(el, {
            center: [lat, lng],
            zoom: this.zoom,
            zoomControl: true,
            attributionControl: false
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(this._map);

        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng));

        this._mapReady = true;
        
        if (this.latitude !== null && this.longitude !== null) {
            this._syncMarkerToState(this.latitude, this.longitude);
        } else {
            // Auto centering on mount
            void this._handleGeolocation(false);
        }

        setTimeout(() => this._map.invalidateSize(), 350);
    }

    _handleInteraction(lat, lng, emit = true) {
        this._isProgrammaticUpdate = true;
        this.latitude = parseFloat(lat.toFixed(6));
        this.longitude = parseFloat(lng.toFixed(6));
        
        this._syncMarkerToState(this.latitude, this.longitude);

        if (emit) {
            this.dispatchEvent(new CustomEvent('location-changed', {
                detail: { latitude: this.latitude, longitude: this.longitude },
                bubbles: true,
                composed: true,
            }));
        }

        setTimeout(() => { this._isProgrammaticUpdate = false; }, 100);
    }

    _syncMarkerToState(lat, lng) {
        if (!this._map) return;
        if (!this._marker) {
            this._marker = L.marker([lat, lng], {
                draggable: true,
                icon: createMapPickerLeafletIcon(L),
            }).addTo(this._map);
            this._marker.on('dragend', () => {
                const pos = this._marker.getLatLng();
                this._handleInteraction(pos.lat, pos.lng, true);
            });
        } else {
            this._marker.setLatLng([lat, lng]);
        }
        this._map.setView([lat, lng], this._map.getZoom());
    }

    async _handleGeolocation(emit = true) {
        if (!navigator.geolocation) return;
        this._loading = true;
        this.requestUpdate();
        return new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this._handleInteraction(pos.coords.latitude, pos.coords.longitude, emit);
                    if (this._map) this._map.setView([pos.coords.latitude, pos.coords.longitude], 16);
                    this._loading = false;
                    this.requestUpdate();
                    resolve(true);
                },
                () => {
                    this._loading = false;
                    this.requestUpdate();
                    resolve(false);
                },
                { enableHighAccuracy: true, timeout: 5000 }
            );
        });
    }
}

if (!customElements.get('map-location-input-lit')) {
    customElements.define('map-location-input-lit', MapLocationInputLit);
}
