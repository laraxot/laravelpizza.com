mport { geoIcon } from './geo-heroicons.js'/
import { LitElement, html } from 'lit';
mport { geoIcon } from './geo-heroicons.js'/
import { guard } from 'lit/directives/guard.js';
mport { geoIcon } from './geo-heroicons.js'/
import L from 'leaflet';
mport { geoIcon } from './geo-heroicons.js'/
import { mapPickerStyles } from './map-picker-styles.js';
mport { geoIcon } from './geo-heroicons.js'/
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
/**
mport { geoIcon } from './geo-heroicons.js'/
 * MapPositionerLit
mport { geoIcon } from './geo-heroicons.js'/
 * ZEN: Stateless UI Component for geographic positioning.
mport { geoIcon } from './geo-heroicons.js'/
 * Implementation: Light DOM for stability and unified behavior.
mport { geoIcon } from './geo-heroicons.js'/
 */
mport { geoIcon } from './geo-heroicons.js'/
export class MapPositionerLit extends LitElement {
mport { geoIcon } from './geo-heroicons.js'/
    static properties = {
mport { geoIcon } from './geo-heroicons.js'/
        latitude: { type: Number },
mport { geoIcon } from './geo-heroicons.js'/
        longitude: { type: Number },
mport { geoIcon } from './geo-heroicons.js'/
        defaultLatitude: { type: Number, attribute: 'default-latitude' },
mport { geoIcon } from './geo-heroicons.js'/
        defaultLongitude: { type: Number, attribute: 'default-longitude' },
mport { geoIcon } from './geo-heroicons.js'/
        zoom: { type: Number },
mport { geoIcon } from './geo-heroicons.js'/
        height: { type: String },
mport { geoIcon } from './geo-heroicons.js'/
        showSearch: { type: Boolean, attribute: 'show-search' },
mport { geoIcon } from './geo-heroicons.js'/
    };
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    createRenderRoot() {
mport { geoIcon } from './geo-heroicons.js'/
        return this;
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    constructor() {
mport { geoIcon } from './geo-heroicons.js'/
        super();
mport { geoIcon } from './geo-heroicons.js'/
        this.latitude = null;
mport { geoIcon } from './geo-heroicons.js'/
        this.longitude = null;
mport { geoIcon } from './geo-heroicons.js'/
        this.defaultLatitude = 41.9028;
mport { geoIcon } from './geo-heroicons.js'/
        this.defaultLongitude = 12.4964;
mport { geoIcon } from './geo-heroicons.js'/
        this.zoom = 13;
mport { geoIcon } from './geo-heroicons.js'/
        this.height = '400px';
mport { geoIcon } from './geo-heroicons.js'/
        this.showSearch = true;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._marker = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._layers = {};
mport { geoIcon } from './geo-heroicons.js'/
        this._mapReady = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._loading = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._isProgrammaticUpdate = false;
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver = null;
mport { geoIcon } from './geo-heroicons.js'/
        this._pendingLocation = null;
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    render() {
mport { geoIcon } from './geo-heroicons.js'/
        const isFullscreen = !!document.fullscreenElement;
mport { geoIcon } from './geo-heroicons.js'/
        
mport { geoIcon } from './geo-heroicons.js'/
        return html`
mport { geoIcon } from './geo-heroicons.js'/
            <style>
mport { geoIcon } from './geo-heroicons.js'/
                map-positioner-lit { display: block; width: 100%; }
mport { geoIcon } from './geo-heroicons.js'/
                ${mapPickerStyles}
mport { geoIcon } from './geo-heroicons.js'/
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
mport { geoIcon } from './geo-heroicons.js'/
                .ctrl-btn svg { width: 1.5rem; height: 1.5rem; color: #374151; }
mport { geoIcon } from './geo-heroicons.js'/
                .ctrl-btn:hover svg { color: #ef4444; }
mport { geoIcon } from './geo-heroicons.js'/
            </style>
mport { geoIcon } from './geo-heroicons.js'/
            <div class="map-container ${isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
mport { geoIcon } from './geo-heroicons.js'/
                
mport { geoIcon } from './geo-heroicons.js'/
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
mport { geoIcon } from './geo-heroicons.js'/
                
mport { geoIcon } from './geo-heroicons.js'/
                ${this.showSearch ? this._renderSearch() : ''}
mport { geoIcon } from './geo-heroicons.js'/
                
mport { geoIcon } from './geo-heroicons.js'/
                <div class="layer-controls-overlay">
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${this._handleGeolocation}" title="Mia posizione">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('map-pin')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomIn()}" title="Zoom In">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('plus')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomOut()}" title="Zoom Out">
mport { geoIcon } from './geo-heroicons.js'/
                        ${geoIcon('minus')}
mport { geoIcon } from './geo-heroicons.js'/
                    </button>
mport { geoIcon } from './geo-heroicons.js'/
                </div>
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
                <div class="loading-overlay ${this._loading ? 'active' : ''}">
mport { geoIcon } from './geo-heroicons.js'/
                    <div class="spinner"></div>
mport { geoIcon } from './geo-heroicons.js'/
                </div>
mport { geoIcon } from './geo-heroicons.js'/
            </div>
mport { geoIcon } from './geo-heroicons.js'/
        `;
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _renderSearch() {
mport { geoIcon } from './geo-heroicons.js'/
        return html`
mport { geoIcon } from './geo-heroicons.js'/
            <div class="search-box">
mport { geoIcon } from './geo-heroicons.js'/
                <input
mport { geoIcon } from './geo-heroicons.js'/
                    type="text"
mport { geoIcon } from './geo-heroicons.js'/
                    class="map-picker-search-input"
mport { geoIcon } from './geo-heroicons.js'/
                    placeholder="Cerca indirizzo..."
mport { geoIcon } from './geo-heroicons.js'/
                    @keydown="${(e) => e.key === 'Enter' && this._handleSearch()}"
mport { geoIcon } from './geo-heroicons.js'/
                    autocomplete="off"
mport { geoIcon } from './geo-heroicons.js'/
                />
mport { geoIcon } from './geo-heroicons.js'/
                <button class="ctrl-btn" @click="${this._handleSearch}" type="button" aria-label="Cerca">
mport { geoIcon } from './geo-heroicons.js'/
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
mport { geoIcon } from './geo-heroicons.js'/
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
mport { geoIcon } from './geo-heroicons.js'/
                    </svg>
mport { geoIcon } from './geo-heroicons.js'/
                </button>
mport { geoIcon } from './geo-heroicons.js'/
            </div>
mport { geoIcon } from './geo-heroicons.js'/
        `;
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    firstUpdated() {
mport { geoIcon } from './geo-heroicons.js'/
        this._initMap();
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver = new ResizeObserver(() => {
mport { geoIcon } from './geo-heroicons.js'/
            if (this._map) this._map.invalidateSize();
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver.observe(this);
mport { geoIcon } from './geo-heroicons.js'/
        
mport { geoIcon } from './geo-heroicons.js'/
        document.addEventListener('fullscreenchange', () => this.requestUpdate());
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    disconnectedCallback() {
mport { geoIcon } from './geo-heroicons.js'/
        super.disconnectedCallback();
mport { geoIcon } from './geo-heroicons.js'/
        this._resizeObserver?.disconnect();
mport { geoIcon } from './geo-heroicons.js'/
        if (this._map) {
mport { geoIcon } from './geo-heroicons.js'/
            this._map.remove();
mport { geoIcon } from './geo-heroicons.js'/
            this._map = null;
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    updated(changed) {
mport { geoIcon } from './geo-heroicons.js'/
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
mport { geoIcon } from './geo-heroicons.js'/
            if (this._mapReady && this.latitude !== null && this.longitude !== null) {
mport { geoIcon } from './geo-heroicons.js'/
                this._syncMarkerToState(this.latitude, this.longitude);
mport { geoIcon } from './geo-heroicons.js'/
            }
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _initMap() {
mport { geoIcon } from './geo-heroicons.js'/
        const el = this.querySelector('.map-picker-leaflet-pane');
mport { geoIcon } from './geo-heroicons.js'/
        if (!el || this._map) return;
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        const centerLat = Number(this.latitude ?? this.defaultLatitude);
mport { geoIcon } from './geo-heroicons.js'/
        const centerLng = Number(this.longitude ?? this.defaultLongitude);
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map = L.map(el, {
mport { geoIcon } from './geo-heroicons.js'/
            center: [centerLat, centerLng],
mport { geoIcon } from './geo-heroicons.js'/
            zoom: this.zoom,
mport { geoIcon } from './geo-heroicons.js'/
            zoomControl: false,
mport { geoIcon } from './geo-heroicons.js'/
            attributionControl: false
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this._map);
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng, 'click'));
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this._mapReady = true;
mport { geoIcon } from './geo-heroicons.js'/
        
mport { geoIcon } from './geo-heroicons.js'/
        if (this.latitude !== null && this.longitude !== null) {
mport { geoIcon } from './geo-heroicons.js'/
            this._syncMarkerToState(this.latitude, this.longitude);
mport { geoIcon } from './geo-heroicons.js'/
        } else {
mport { geoIcon } from './geo-heroicons.js'/
            void this._handleGeolocation(false);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        setTimeout(() => this._map.invalidateSize(), 350);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _handleInteraction(lat, lng, source = 'manual') {
mport { geoIcon } from './geo-heroicons.js'/
        this._isProgrammaticUpdate = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.latitude = parseFloat(lat.toFixed(6));
mport { geoIcon } from './geo-heroicons.js'/
        this.longitude = parseFloat(lng.toFixed(6));
mport { geoIcon } from './geo-heroicons.js'/
        
mport { geoIcon } from './geo-heroicons.js'/
        this._syncMarkerToState(this.latitude, this.longitude);
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        this.dispatchEvent(new CustomEvent('position-changed', {
mport { geoIcon } from './geo-heroicons.js'/
            detail: { latitude: this.latitude, longitude: this.longitude, source },
mport { geoIcon } from './geo-heroicons.js'/
            bubbles: true,
mport { geoIcon } from './geo-heroicons.js'/
            composed: true,
mport { geoIcon } from './geo-heroicons.js'/
        }));
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
        setTimeout(() => { this._isProgrammaticUpdate = false; }, 100);
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    _syncMarkerToState(lat, lng) {
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._map) return;
mport { geoIcon } from './geo-heroicons.js'/
        if (!this._marker) {
mport { geoIcon } from './geo-heroicons.js'/
            this._marker = L.marker([lat, lng], { 
mport { geoIcon } from './geo-heroicons.js'/
                draggable: true,
mport { geoIcon } from './geo-heroicons.js'/
                icon: createMapPickerLeafletIcon(L) 
mport { geoIcon } from './geo-heroicons.js'/
            }).addTo(this._map);
mport { geoIcon } from './geo-heroicons.js'/
            this._marker.on('dragend', (e) => {
mport { geoIcon } from './geo-heroicons.js'/
                const pos = e.target.getLatLng();
mport { geoIcon } from './geo-heroicons.js'/
                this._handleInteraction(pos.lat, pos.lng, 'drag');
mport { geoIcon } from './geo-heroicons.js'/
            });
mport { geoIcon } from './geo-heroicons.js'/
        } else {
mport { geoIcon } from './geo-heroicons.js'/
            this._marker.setLatLng([lat, lng]);
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
        this._map.setView([lat, lng], this._map.getZoom());
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    async _handleSearch() {
mport { geoIcon } from './geo-heroicons.js'/
        const input = this.querySelector('.map-picker-search-input');
mport { geoIcon } from './geo-heroicons.js'/
        if (!input?.value) return;
mport { geoIcon } from './geo-heroicons.js'/
        this._loading = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
        try {
mport { geoIcon } from './geo-heroicons.js'/
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(input.value)}&limit=1`);
mport { geoIcon } from './geo-heroicons.js'/
            const data = await res.json();
mport { geoIcon } from './geo-heroicons.js'/
            if (data?.[0]) {
mport { geoIcon } from './geo-heroicons.js'/
                const lat = parseFloat(data[0].lat);
mport { geoIcon } from './geo-heroicons.js'/
                const lon = parseFloat(data[0].lon);
mport { geoIcon } from './geo-heroicons.js'/
                this._handleInteraction(lat, lon, 'search');
mport { geoIcon } from './geo-heroicons.js'/
                this._map?.setView([lat, lon], 16);
mport { geoIcon } from './geo-heroicons.js'/
            }
mport { geoIcon } from './geo-heroicons.js'/
        } finally {
mport { geoIcon } from './geo-heroicons.js'/
            this._loading = false;
mport { geoIcon } from './geo-heroicons.js'/
            this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
        }
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
    async _handleGeolocation(emit = true) {
mport { geoIcon } from './geo-heroicons.js'/
        if (!navigator.geolocation) return;
mport { geoIcon } from './geo-heroicons.js'/
        this._loading = true;
mport { geoIcon } from './geo-heroicons.js'/
        this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
        return new Promise((resolve) => {
mport { geoIcon } from './geo-heroicons.js'/
            navigator.geolocation.getCurrentPosition(
mport { geoIcon } from './geo-heroicons.js'/
                (pos) => {
mport { geoIcon } from './geo-heroicons.js'/
                    this._handleInteraction(pos.coords.latitude, pos.coords.longitude, 'geolocation');
mport { geoIcon } from './geo-heroicons.js'/
                    if (this._map) this._map.setView([pos.coords.latitude, pos.coords.longitude], 16);
mport { geoIcon } from './geo-heroicons.js'/
                    this._loading = false;
mport { geoIcon } from './geo-heroicons.js'/
                    this.requestUpdate();
mport { geoIcon } from './geo-heroicons.js'/
                    resolve(true);
mport { geoIcon } from './geo-heroicons.js'/
                },
mport { geoIcon } from './geo-heroicons.js'/
                () => { this._loading = false; this.requestUpdate(); resolve(false); },
mport { geoIcon } from './geo-heroicons.js'/
                { enableHighAccuracy: true, timeout: 5000 }
mport { geoIcon } from './geo-heroicons.js'/
            );
mport { geoIcon } from './geo-heroicons.js'/
        });
mport { geoIcon } from './geo-heroicons.js'/
    }
mport { geoIcon } from './geo-heroicons.js'/
}
mport { geoIcon } from './geo-heroicons.js'/

mport { geoIcon } from './geo-heroicons.js'/
if (!customElements.get('map-positioner-lit')) {
mport { geoIcon } from './geo-heroicons.js'/
    customElements.define('map-positioner-lit', MapPositionerLit);
mport { geoIcon } from './geo-heroicons.js'/
}
