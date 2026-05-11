import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import { controlIcons, mapPickerStyles } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
import 'leaflet/dist/leaflet.css';

/**
 * GeoLatLngInput
 * Dual input fields with map assistance.
 * Zen: Light DOM for stability and unified styling.
 */
export class GeoLatLngInput extends LitElement {
    static properties = {
        lat: { type: Number },
        lng: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        statePath: { type: String, attribute: 'state-path' },
        _isFullscreen: { type: Boolean, state: true }
    };

    createRenderRoot() {
        return this;
    }

    constructor() {
        super();
        this.lat = 41.9028;
        this.lng = 12.4964;
        this.zoom = 13;
        this.height = '340px';
        this.statePath = '';
        this._isFullscreen = false;

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
        return html`
            <style>
                geo-latlng-input { display: block; width: 100%; }
                ${mapPickerStyles}
                .coordinate-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 1rem; }
                .input-group { display: flex; flex-direction: column; gap: 0.25rem; }
                .input-group label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #6b7280; }
                .input-group input { padding: 0.625rem 0.875rem; font-size: 0.875rem; border: 1px solid #d1d5db; border-radius: 0.5rem; }
            </style>
            
            <div class="geo-latlng-shell">
                <div class="map-container ${this._isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
                    ${guard([], () => html`<div class="map-canvas" style="height: 100%;"></div>`)}
                    
                    <div class="layer-controls-overlay">
                        <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
                            ${controlIcons.fullscreen}
                        </button>
                        <button class="ctrl-btn" type="button" @click="${this._handleGeolocation}" title="Mia posizione">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="3"></circle>
                                <line x1="12" y1="2" x2="12" y2="4"></line>
                                <line x1="12" y1="20" x2="12" y2="22"></line>
                                <line x1="2" y1="12" x2="4" y2="12"></line>
                                <line x1="20" y1="12" x2="22" y2="12"></line>
                            </svg>
                        </button>
                        <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
                            ${controlIcons.layer}
                        </button>
                        <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomIn()}" title="Zoom In">
                            ${controlIcons.zoomIn}
                        </button>
                        <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomOut()}" title="Zoom Out">
                            ${controlIcons.zoomOut}
                        </button>
                    </div>

                    <div class="loading-overlay ${this._loading ? 'active' : ''}">
                        <div class="spinner"></div>
                    </div>
                </div>

                <div class="coordinate-inputs">
                    <div class="input-group">
                        <label>Latitudine</label>
                        <input type="number" step="0.000001" .value="${this.lat?.toFixed(6)}" @change="${this.onLatitudeChange}">
                    </div>
                    <div class="input-group">
                        <label>Longitudine</label>
                        <input type="number" step="0.000001" .value="${this.lng?.toFixed(6)}" @change="${this.onLongitudeChange}">
                    </div>
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
        
        document.addEventListener('fullscreenchange', () => {
            this._isFullscreen = !!document.fullscreenElement;
            if (this._map) setTimeout(() => this._map.invalidateSize(), 150);
        });
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this._resizeObserver?.disconnect();
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }

    updated(changed) {
        if ((changed.has('lat') || changed.has('lng')) && !this._isProgrammaticUpdate) {
            if (this._mapReady && this.lat !== null && this.lng !== null) {
                this._syncMarkerToState(this.lat, this.lng);
            }
        }
    }

    _initMap() {
        const el = this.querySelector('.map-canvas');
        if (!el || this._map) return;

        this._map = L.map(el, {
            center: [this.lat, this.lng],
            zoom: this.zoom,
            zoomControl: false,
            attributionControl: false
        });

        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 });
        this._layers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19 });
        this._layers.topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17 });
        this._layers.terrain = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19 });

        this._layers.street.addTo(this._map);
        this._mapReady = true;
        this._syncMarkerToState(this.lat, this.lng);

        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng));

        setTimeout(() => this._map.invalidateSize(), 350);
    }

    _handleInteraction(lat, lng) {
        this._isProgrammaticUpdate = true;
        this.lat = parseFloat(lat.toFixed(6));
        this.lng = parseFloat(lng.toFixed(6));
        this._syncMarkerToState(this.lat, this.lng);

        this.dispatchEvent(new CustomEvent('geo-latlng-change', {
            detail: { lat: this.lat, lng: this.lng },
            bubbles: true,
            composed: true,
        }));

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
        const layers = ['street', 'satellite', 'topo', 'terrain'];
        const currentIndex = layers.indexOf(this._currentLayer);
        const nextIndex = (currentIndex + 1) % layers.length;
        const nextLayer = layers[nextIndex];

        this._map.removeLayer(this._layers[this._currentLayer]);
        this._layers[nextLayer].addTo(this._map);
        this._currentLayer = nextLayer;
    }

    _handleGeolocation() {
        if (!navigator.geolocation) return;
        this._loading = true;
        this.requestUpdate();
        navigator.geolocation.getCurrentPosition((pos) => {
            this._handleInteraction(pos.coords.latitude, pos.coords.longitude);
            if (this._map) this._map.setView([pos.coords.latitude, pos.coords.longitude], 16);
            this._loading = false;
            this.requestUpdate();
        }, () => {
            this._loading = false;
            this.requestUpdate();
        });
    }

    _toggleFullscreen() {
        const container = this.querySelector('.map-container');
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            container.requestFullscreen();
        }
    }

    onLatitudeChange(e) {
        this._handleInteraction(parseFloat(e.target.value), this.lng);
    }

    onLongitudeChange(e) {
        this._handleInteraction(this.lat, parseFloat(e.target.value));
    }
}

if (!customElements.get('geo-latlng-input')) {
    customElements.define('geo-latlng-input', GeoLatLngInput);
}