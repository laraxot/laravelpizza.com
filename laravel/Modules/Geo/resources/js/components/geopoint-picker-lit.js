import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { mapPickerStylesText } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
import { geoIcon } from './geo-heroicons.js';

/**
 * GeopointPickerLit
 * ZEN: The sibling component for point selection.
 * Implementation: Light DOM for stability and unified behavior.
 */
export class GeopointPickerLit extends LitElement {
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
        this._layers = {};
        this._currentLayer = 'street';
        this._mapReady = false;
        this._loading = false;
        this._isProgrammaticUpdate = false;
        this._resizeObserver = null;
    }

    render() {
        const isFullscreen = !!document.fullscreenElement;
        const mapHeight = this.height || '400px';

        return html`
            <style>
                geopoint-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${mapPickerStylesText}
                .map-container { min-height: 200px; }
                /* BUG 3 fix: :host CSS vars are ignored in Light DOM — hardcode z-index */
                .layer-controls-overlay { z-index: 1000 !important; display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
                .search-box { z-index: 1000 !important; }
                .ctrl-btn svg { width: 1.5rem; height: 1.5rem; color: #374151; }
                .ctrl-btn:hover svg { color: #ef4444; }
            </style>

            <div class="map-container ${isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${mapHeight}">
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}

                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
                        ${geoIcon('arrows-pointing-out')}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${() => this._handleGeolocation(true)}" title="Mia posizione">
                        ${geoIcon('map-pin')}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
                        ${geoIcon('squares-2x2')}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomIn()}" title="Zoom In">
                        ${geoIcon('plus')}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomOut()}" title="Zoom Out">
                        ${geoIcon('minus')}
                    </button>
                </div>

                <div class="loading-overlay ${this._loading ? 'active' : ''}">
                    <div class="spinner"></div>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        this._initMap();
        this._resizeObserver = new ResizeObserver(() => {
            if (this._map) this._map.invalidateSize();
        });
        this._resizeObserver.observe(this);

        // BUG 4 fix: MutationObserver depth 15 — detects class="hidden" toggle by Filament wizard
        this._mutationObserver = new MutationObserver(() => {
            if (this.offsetParent !== null && this._map) {
                setTimeout(() => this._map.invalidateSize(), 150);
            }
        });
        let parent = this.parentElement;
        for (let i = 0; i < 15 && parent; i++) {
            this._mutationObserver.observe(parent, {
                attributes: true,
                attributeFilter: ['class', 'style', 'hidden'],
            });
            parent = parent.parentElement;
        }
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this._resizeObserver?.disconnect();
        this._mutationObserver?.disconnect();
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }

    updated(changed) {
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
            if (this._mapReady && this.latitude !== null && this.longitude !== null) {
                this._syncMarkerToState(this.latitude, this.longitude);
            }
        }
    }

    _initMap() {
        const el = this.querySelector('.geopoint-leaflet-pane') || this.querySelector('.map-picker-leaflet-pane');
        if (!el || this._map) return;

        const centerLat = this.latitude || this.defaultLatitude;
        const centerLng = this.longitude || this.defaultLongitude;

        this._map = L.map(el, {
            center: [centerLat, centerLng],
            zoom: this.zoom,
            zoomControl: false,
            attributionControl: false
        });

        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this._map);
        this._layers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19 });
        this._layers.topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17 });

        this._mapReady = true;

        if (this.latitude !== null && this.longitude !== null) {
            this._syncMarkerToState(this.latitude, this.longitude);
        } else {
            void this._handleGeolocation(false);
        }

        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng));
        setTimeout(() => this._map.invalidateSize(), 350);
    }

    _handleInteraction(lat, lng, emit = true) {
        this._isProgrammaticUpdate = true;
        this.latitude = parseFloat(lat.toFixed(6));
        this.longitude = parseFloat(lng.toFixed(6));
        this._syncMarkerToState(this.latitude, this.longitude);

        if (emit) {
            this.dispatchEvent(new CustomEvent('geopoint-changed', {
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
                icon: createMapPickerLeafletIcon(L) 
            }).addTo(this._map);
            this._marker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                this._handleInteraction(pos.lat, pos.lng);
            });
        } else {
            this._marker.setLatLng([lat, lng]);
        }
        this._map.setView([lat, lng], this._map.getZoom());
    }

    _switchLayer() {
        const layers = ['street', 'satellite', 'topo'];
        const currentIndex = layers.indexOf(this._currentLayer);
        const nextIndex = (currentIndex + 1) % layers.length;
        const nextLayer = layers[nextIndex];

        this._map.removeLayer(this._layers[this._currentLayer]);
        if (!this._layers[nextLayer]._map) {
            this._layers[nextLayer].addTo(this._map);
        }
        this._currentLayer = nextLayer;
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
                () => { this._loading = false; this.requestUpdate(); resolve(false); },
                { enableHighAccuracy: true, timeout: 5000 }
            );
        });
    }

    setCoordinates(lat, lng, source = 'programmatic') {
        const latitude = parseFloat(lat);
        const longitude = parseFloat(lng);
        if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) return;
        this._handleInteraction(latitude, longitude, source);
        this._map?.setView([latitude, longitude], Math.max(this._map?.getZoom() || this.zoom, 16), { animate: true });
        this._refreshMapSize();
    }

    _toggleFullscreen() {
        const container = this.querySelector('.map-container');
        if (!container) return;
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            container.requestFullscreen();
        }
    }
}

if (!customElements.get('geopoint-picker-lit')) {
    customElements.define('geopoint-picker-lit', GeopointPickerLit);
}
