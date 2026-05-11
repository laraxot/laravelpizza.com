import { geoIcon } from './geo-heroicons.js';
import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import { mapPickerStyles } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
import 'leaflet/dist/leaflet.css';
/**
 * LocationPickerLit
 * ZEN: Standardized geographical picker with address support.
 * Implementation: Light DOM for stability in dynamic/wizard contexts.
 * Logic: Stateless UI, synchronization via coordinates-changed event.
 */
export class LocationPickerLit extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        zoom: { type: Number },
        height: { type: String },
        address: { type: String },
        isLocating: { type: Boolean, state: true },
        isFullscreen: { type: Boolean, state: true },
    };

    createRenderRoot() {
        return this;
    }

    constructor() {
        super();
        this.latitude = 41.9028;
        this.longitude = 12.4964;
        this.zoom = 13;
        this.height = '400px';
        this.address = '';
        this.isLocating = false;
        this.isFullscreen = false;

        this._map = null;
        this._marker = null;
        this._isProgrammaticUpdate = false;
        this._resizeObserver = null;
        this._currentLayer = 'street';
        this._layers = {};
    }

    render() {
        return html`
            <style>
                location-picker-lit { display: block; width: 100%; }
                ${mapPickerStyles}
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
                .ctrl-btn svg { width: 1.5rem; height: 1.5rem; color: #374151; }
                .ctrl-btn:hover svg { color: #ef4444; }
                .close-fullscreen-btn { background: #ef4444 !important; color: white !important; }
            </style>
                        
            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
                
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}

                <div class="layer-controls-overlay">
                     ${this.isFullscreen ? html`
                        <button class="ctrl-btn close-fullscreen-btn" type="button" @click="${this._toggleFullscreen}" title="Chiudi">
                             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        </button>
                    ` : html`
                        <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
                            ${geoIcon('arrows-pointing-out')}
                        </button>
                    `}
                    
                    <button class="ctrl-btn" type="button" @click="${this._handleGeolocation}" ?disabled="${this.isLocating}" title="Mia posizione">
                        ${this.isLocating 
                            ? html`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`
                            : geoIcon('map-pin')
                        }
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

                <div class="loading-overlay ${this.isLocating ? 'active' : ''}">
                    <div class="spinner"></div>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        this._initMap();
        this._resizeObserver = new ResizeObserver(() => {
            if (this._map) setTimeout(() => this._map.invalidateSize(), 350);
        });
        this._resizeObserver.observe(this);
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isFullscreen) this._toggleFullscreen();
        });
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
        this._resizeObserver?.disconnect();
    }

    updated(changed) {
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
            this._syncMarkerToState();
        }
    }

    _initMap() {
        const el = this.querySelector('.map-picker-leaflet-pane');
        if (!el || this._map) return;

        this._map = L.map(el, {
            center: [this.latitude, this.longitude],
            zoom: this.zoom,
            zoomControl: false,
            attributionControl: false
        });

        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this._map);
        this._layers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19 });
        this._layers.topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17 });

        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng, 'click'));

        this._syncMarkerToState();
        setTimeout(() => this._map.invalidateSize(), 350);
    }

    _handleInteraction(lat, lng, source = 'manual') {
        this._isProgrammaticUpdate = true;
        this.latitude = parseFloat(lat.toFixed(6));
        this.longitude = parseFloat(lng.toFixed(6));
        
        this._syncMarkerToState();

        this.dispatchEvent(new CustomEvent('location-changed', {
            detail: { latitude: this.latitude, longitude: this.longitude, source },
            bubbles: true,
            composed: true,
        }));

        setTimeout(() => { this._isProgrammaticUpdate = false; }, 100);
    }

    _syncMarkerToState() {
        if (!this._map) return;
        if (!this._marker) {
            this._marker = L.marker([this.latitude, this.longitude], { 
                draggable: true, 
                icon: createMapPickerLeafletIcon(L) 
            }).addTo(this._map);
            this._marker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                this._handleInteraction(pos.lat, pos.lng, 'drag');
            });
        } else {
            this._marker.setLatLng([this.latitude, this.longitude]);
        }
        this._map.setView([this.latitude, this.longitude], this._map.getZoom());
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

    _toggleFullscreen() {
        this.isFullscreen = !this.isFullscreen;
        if (this.isFullscreen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
        this.dispatchEvent(new CustomEvent('fullscreen-changed', {
            detail: { isFullscreen: this.isFullscreen },
            bubbles: true,
            composed: true,
        }));
    }

    async _handleGeolocation() {
        if (!navigator.geolocation) return;
        this.isLocating = true;
        this.requestUpdate();
        return new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this._handleInteraction(pos.coords.latitude, pos.coords.longitude, 'geolocation');
                    if (this._map) this._map.setView([pos.coords.latitude, pos.coords.longitude], 16);
                    this.isLocating = false;
                    this.requestUpdate();
                    resolve(true);
                },
                () => { this.isLocating = false; this.requestUpdate(); resolve(false); },
                { enableHighAccuracy: true, timeout: 5000 }
            );
        });
    }
}

if (!customElements.get('location-picker-lit')) {
    customElements.define('location-picker-lit', LocationPickerLit);
}
