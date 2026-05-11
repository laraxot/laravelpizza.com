import { geoIcon } from './geo-heroicons.js';
import { LitElement, html, nothing } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import { mapPickerStyles } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';

/**
 * PlacePickerLit
 * ZEN: Simplified selection with readout.
 * Implementation: Light DOM for stability and unified behavior.
 */
export class PlacePickerField extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        address: { type: String },
    };

    createRenderRoot() {
        return this;
    }

    constructor() {
        super();
        this.latitude = null;
        this.longitude = null;
        this.zoom = 13;
        this.height = '400px';
        this.address = null;

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
        const hasCoords = Number.isFinite(this.latitude) && Number.isFinite(this.longitude);

        return html`
            <style>
                place-picker-lit { display: block; width: 100%; }
                ${mapPickerStyles}
                .place-picker-readout {
                    display: flex;
                    flex-wrap: wrap;
                    align-items: center;
                    gap: 12px;
                    padding: 12px 16px;
                    font-size: 11px;
                    font-family: ui-monospace, monospace;
                    background: #fff;
                    border-top: 1px solid #e5e7eb;
                }
                .place-picker-readout__label {
                    text-transform: uppercase;
                    font-size: 9px;
                    color: #6b7280;
                    font-weight: 700;
                }
                .place-picker-readout__value--set { color: #2563eb; font-weight: 600; }
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
            </style>
            
            <div class="map-container ${isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
                ${guard([], () => html`<div class="place-picker-leaflet-pane" style="height: 100%;"></div>`)}
                
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

                <div class="place-picker-readout">
                    <div>
                        <span class="place-picker-readout__label">Lat</span>
                        <span class="place-picker-readout__value ${hasCoords ? 'place-picker-readout__value--set' : ''}">
                            ${hasCoords ? this.latitude.toFixed(6) : '–'}
                        </span>
                    </div>
                    <div>
                        <span class="place-picker-readout__label">Lng</span>
                        <span class="place-picker-readout__value ${hasCoords ? 'place-picker-readout__value--set' : ''}">
                            ${hasCoords ? this.longitude.toFixed(6) : '–'}
                        </span>
                    </div>
                    ${this.address ? html`<div>📍 ${this.address}</div>` : nothing}
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
        document.addEventListener('fullscreenchange', () => this.requestUpdate());
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
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
            if (this._mapReady && this.latitude !== null && this.longitude !== null) {
                this._syncMarkerToState(this.latitude, this.longitude);
            }
        }
    }

    _initMap() {
        const el = this.querySelector('.place-picker-leaflet-pane');
        if (!el || this._map) return;

        const centerLat = this.latitude || 45.4654;
        const centerLng = this.longitude || 12.3354;

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
            this.dispatchEvent(new CustomEvent('place-changed', {
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

if (!customElements.get('place-picker-lit')) {
    customElements.define('place-picker-lit', PlacePickerField);
}