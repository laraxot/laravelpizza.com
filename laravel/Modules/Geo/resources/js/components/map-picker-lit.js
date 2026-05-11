import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { mapPickerStyles, mapPickerStylesText } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';
import { geoIcon } from './geo-heroicons.js';

/**
 * MapPickerLit
 * ZEN: The definitive map picker with search and coordinate synchronization.
 * Implementation: Light DOM for stability and unified behavior.
 */
export class MapPickerLit extends LitElement {
    static properties = {
        latitude: { type: Number },
        longitude: { type: Number },
        defaultLatitude: { type: Number, attribute: 'default-latitude' },
        defaultLongitude: { type: Number, attribute: 'default-longitude' },
        zoom: { type: Number },
        height: { type: String },
        showSearch: { type: Boolean, attribute: 'show-search' },
        geolocateWhenEmpty: { type: Boolean, attribute: 'geolocate-when-empty' },
        address: { type: String, attribute: 'address' },
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
        this.showSearch = true;
        this.geolocateWhenEmpty = false;
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

        return html`
            <style>
                map-picker-lit { display: block; width: 100%; }
                ${mapPickerStyles}
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
                .ctrl-btn svg { width: 1.25rem !important; height: 1.25rem !important; }
                .ctrl-btn:hover svg { color: #60a5fa !important; }
            </style>
            <div class="map-container ${isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">

                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}

                ${this.showSearch ? this._renderSearch() : ''}

                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="Fullscreen">
                        ${this._renderIcon('arrows-pointing-out')}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${() => this._handleGeolocation(true)}" title="Mia posizione">
                        ${this._renderIcon('map-pin')}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="Cambia Layer">
                        ${this._renderIcon('squares-2x2')}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomIn()}" title="Zoom In">
                        ${this._renderIcon('plus')}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${() => this._map?.zoomOut()}" title="Zoom Out">
                        ${this._renderIcon('minus')}
                    </button>
                </div>

                <div class="loading-overlay ${this._loading ? 'active' : ''}">
                    <div class="spinner"></div>
                </div>
            </div>
        `;
    }

    _renderIcon(name) {
        return geoIcon(name);
    }

    _renderSearch() {
        return html`
            <div class="search-box">
                <input
                    type="text"
                    class="map-picker-search-input"
                    placeholder="Cerca indirizzo..."
                    @keydown="${(e) => e.key === 'Enter' && this._handleSearch()}"
                    autocomplete="off"
                />
                <button class="ctrl-btn" @click="${this._handleSearch}" type="button" aria-label="Cerca">
                    ${this._renderIcon('magnifying-glass')}
                </button>
            </div>
        `;
    }

    connectedCallback() {
        super.connectedCallback();
        document.addEventListener('fullscreenchange', () => this._onFullscreenChange());

        // MutationObserver — rileva toggle class="hidden" del wizard Filament 5 (depth 20)
        this._mutationObserver = new MutationObserver(() => {
            if (this.offsetParent !== null && this._map) {
                setTimeout(() => this._map.invalidateSize(), 150);
            }
        });
        let parent = this.parentElement;
        for (let i = 0; i < 20 && parent; i++) {
            this._mutationObserver.observe(parent, {
                attributes: true,
                attributeFilter: ['class', 'style', 'hidden'],
            });
            parent = parent.parentElement;
        }
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        document.removeEventListener('fullscreenchange', () => this._onFullscreenChange());
        this._mutationObserver?.disconnect();
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
        this._resizeObserver?.disconnect();
    }

    firstUpdated() {
        this._initMap();
    }

    updated(changed) {
        if ((changed.has('latitude') || changed.has('longitude')) && !this._isProgrammaticUpdate) {
            if (this._mapReady && this.latitude && this.longitude) {
                this._syncMarkerToState(this.latitude, this.longitude);
            }
        }
    }

    _refreshMapSize() {
        [0, 80, 180, 350, 700, 1200].forEach((delay) => {
            setTimeout(() => {
                if (this._map && this.offsetParent !== null) {
                    this._map.invalidateSize();
                }
            }, delay);
        });
    }

    _initMap() {
        const el = this.querySelector('.map-picker-leaflet-pane');
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

        if (this.latitude && this.longitude) {
            this._syncMarkerToState(this.latitude, this.longitude);
        } else if (this.geolocateWhenEmpty) {
            void this._handleGeolocation(false);
        }

        this._map.on('click', (e) => this._handleInteraction(e.latlng.lat, e.latlng.lng, true));

        this._resizeObserver = new ResizeObserver(() => {
            if (this._map) this._map.invalidateSize();
        });
        this._resizeObserver.observe(this);

        this._refreshMapSize();
    }

    _handleInteraction(lat, lng, emit = true) {
        this._isProgrammaticUpdate = true;
        this.latitude = parseFloat(lat.toFixed(6));
        this.longitude = parseFloat(lng.toFixed(6));

        this._syncMarkerToState(this.latitude, this.longitude);

        if (emit) {
            this.dispatchEvent(new CustomEvent('coords-changed', {
                detail: { latitude: this.latitude, longitude: this.longitude },
                bubbles: true,
                composed: true
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
                this._handleInteraction(pos.lat, pos.lng, true);
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
                () => {
                    this._loading = false;
                    this.requestUpdate();
                    resolve(false);
                },
                { enableHighAccuracy: true, timeout: 5000 }
            );
        });
    }

    async _handleSearch() {
        const input = this.querySelector('.map-picker-search-input');
        if (!input?.value) return;
        this._loading = true;
        this.requestUpdate();
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(input.value)}&limit=1`);
            const data = await res.json();
            if (data?.[0]) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);
                this._handleInteraction(lat, lon, true);
                this._map?.setView([lat, lon], 16);
            }
        } finally {
            this._loading = false;
            this.requestUpdate();
        }
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

    _onFullscreenChange() {
        this.requestUpdate();
        if (this._map) {
            setTimeout(() => this._map.invalidateSize(), 300);
        }
    }

    _getFullscreenIcon() {
        return document.fullscreenElement ? 'arrows-pointing-in' : 'arrows-pointing-out';
    }
}

if (!customElements.get('map-picker-lit')) {
    customElements.define('map-picker-lit', MapPickerLit);
}
