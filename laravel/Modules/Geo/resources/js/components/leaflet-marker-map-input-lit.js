import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import { mapPickerStyles } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
import 'leaflet/dist/leaflet.css';

/**
 * LeafletMarkerMapInputLit
 * Technical implementation of a Leaflet map with a draggable marker.
 * Zen: Light DOM for stability in wizard/dynamic contexts.
 */
export class LeafletMarkerMapInputLit extends LitElement {
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
        this.zoom = 15;
        this.height = '400px';

        this._map = null;
        this._marker = null;
        this._mapReady = false;
        this._resizeObserver = null;
    }

    render() {
        return html`
            <style>
                leaflet-marker-map-input-lit { display: block; width: 100%; }
                ${mapPickerStyles}
            </style>
            <div class="map-container" style="--map-height: ${this.height}">
                ${guard([], () => html`<div class="leaflet-marker-map-pane" style="height: 100%;"></div>`)}
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
        if (this._mapReady && (changed.has('latitude') || changed.has('longitude'))) {
            this._updateInternal(this.latitude, this.longitude, false);
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
        const el = this.querySelector('.leaflet-marker-map-pane');
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

        this._map.on('click', (e) => this._updateInternal(e.latlng.lat, e.latlng.lng, true));

        this._mapReady = true;
        this._updateInternal(lat, lng, false);
        
        setTimeout(() => this._map.invalidateSize(), 300);
    }

    _updateInternal(lat, lng, emit = true) {
        if (!this._map) return;

        if (!this._marker) {
            this._marker = L.marker([lat, lng], {
                draggable: true,
                icon: createMapPickerLeafletIcon(L),
            }).addTo(this._map);
            this._marker.on('dragend', () => {
                const pos = this._marker.getLatLng();
                this._updateInternal(pos.lat, pos.lng, true);
            });
        } else {
            this._marker.setLatLng([lat, lng]);
        }

        if (emit) {
            this.dispatchEvent(new CustomEvent('map-coords-changed', {
                detail: { latitude: lat, longitude: lng },
                bubbles: true,
                composed: true,
            }));
        }
    }
}

if (!customElements.get('leaflet-marker-map-input-lit')) {
    customElements.define('leaflet-marker-map-input-lit', LeafletMarkerMapInputLit);
}
