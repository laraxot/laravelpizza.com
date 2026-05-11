import { LitElement, html, unsafeCSS } from 'lit';
import { guard } from 'lit/directives/guard.js';
import L from 'leaflet';
import leafletCss from 'leaflet/dist/leaflet.css?inline';
import { mapPickerStyles, controlIcons } from './map-picker-styles.js';
import { createMapPickerLeafletIcon } from './map-picker-marker-config.js';

/**
 * CoordinatePickerField
 * ZEN: Absolute technical precision and wizard stability.
 */
export class CoordinatePickerField extends LitElement {
    static properties = {
        state: { type: Object }, // Accepts {latitude, longitude}
        zoom: { type: Number },
        height: { type: String },
        isLocating: { type: Boolean, state: true },
        isFullscreen: { type: Boolean, state: true },
        geolocateWhenEmpty: { type: Boolean, attribute: 'geolocate-when-empty' },
        labels: { type: Object },
        provider: { type: String },
        showSearch: { type: Boolean, attribute: 'show-search' },
        _isProgrammaticUpdate: { type: Boolean, state: true },
    };

    get _lat() { return this.state?.latitude ?? null; }
    get _lng() { return this.state?.longitude ?? null; }

    constructor() {
        super();
        this.state = null;
        this.zoom = 13;
        this.height = '400px';
        this.isLocating = false;
        this.isFullscreen = false;
        this.geolocateWhenEmpty = false;
        this.labels = {};
        this.provider = 'osm';
        this.showSearch = false;
        this._isProgrammaticUpdate = false;

        this._map = null;
        this._marker = null;
        this._layers = {};
        this._resizeObserver = null;
        this._visibilityObserver = null;
        this._mutationObserver = null;
        this._currentLayer = 'street';
        this._sizeRefreshTimeouts = [];
        this._tileRecoveryTimeouts = [];
        this._lastMeasuredSize = null;

        this._boundRefreshMapSize = () => this._refreshMapSize();
        this._boundSettledRefreshMapSize = () => this._refreshMapSize([80, 180, 350]);
        this._boundFullscreenChange = () => this._syncFullscreenState();
        this._boundEscapeKeyDown = (event) => {
            if (event.key === 'Escape' && this.isFullscreen) {
                void this._toggleFullscreen();
            }
        };

        this._previousBodyOverflow = '';
        this._previousHtmlOverflow = '';
    }

    render() {
        const l = this.labels || {};

        return html`
            <style>
                ${unsafeCSS(leafletCss)}
                coordinate-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${mapPickerStyles}
                .leaflet-container {
                    position: relative;
                    overflow: hidden;
                    width: 100%;
                    height: 100%;
                    background: #ddd;
                    outline-offset: 1px;
                    font-family: inherit;
                }
                .leaflet-pane,
                .leaflet-map-pane,
                .leaflet-tile,
                .leaflet-marker-icon,
                .leaflet-marker-shadow,
                .leaflet-tile-container,
                .leaflet-pane > svg,
                .leaflet-pane > canvas,
                .leaflet-zoom-box,
                .leaflet-image-layer,
                .leaflet-layer {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
                .leaflet-container img.leaflet-tile {
                    max-width: none !important;
                    max-height: none !important;
                    width: 256px;
                    height: 256px;
                }
                .leaflet-tile {
                    filter: inherit;
                    visibility: inherit;
                    border: 0;
                    user-select: none;
                    -webkit-user-drag: none;
                }
                .leaflet-tile-pane { z-index: 200; }
                .leaflet-overlay-pane { z-index: 400; }
                .leaflet-shadow-pane { z-index: 500; }
                .leaflet-marker-pane { z-index: 600; }
                .leaflet-tooltip-pane { z-index: 650; }
                .leaflet-popup-pane { z-index: 700; }
                .map-container { min-height: 200px; }
                .map-container.is-fullscreen {
                    position: fixed !important;
                    inset: 0 !important;
                    width: 100vw !important;
                    height: 100vh !important;
                    border: none !important;
                    border-radius: 0 !important;
                    z-index: 2147483000 !important;
                }
                .map-container.is-fullscreen .map-picker-leaflet-pane { height: 100vh !important; }
                .layer-controls-overlay {
                    display: flex !important;
                    flex-direction: column !important;
                    gap: 0.5rem !important;
                }
            </style>

            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}

                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="${this.isFullscreen ? (l.close_fullscreen || 'Chiudi') : (l.fullscreen || 'Fullscreen')}">
                        ${this.isFullscreen ? controlIcons.fullscreenExit : controlIcons.fullscreen}
                    </button>

                    <button class="ctrl-btn" type="button" @click="${this._requestGeolocation}" ?disabled="${this.isLocating}" title="${l.use_location || 'Mia posizione'}">
                        ${this.isLocating
                            ? html`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`
                            : controlIcons.crosshair}
                    </button>

                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="${l.switch_layer || 'Cambia Layer'}">
                        ${controlIcons.layer}
                    </button>

                    <button class="ctrl-btn" type="button" @click="${this._zoomIn}" title="${l.zoom_in || 'Zoom In'}">
                        ${controlIcons.zoomIn}
                    </button>

                    <button class="ctrl-btn" type="button" @click="${this._zoomOut}" title="${l.zoom_out || 'Zoom Out'}">
                        ${controlIcons.zoomOut}
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
            this._refreshMapSize([0, 120]);
        });
        this._resizeObserver.observe(this);

        this._visibilityObserver = new IntersectionObserver((entries) => {
            if (entries.some((entry) => entry.isIntersecting)) {
                this._refreshMapSize([0, 120, 300]);
            }
        }, { threshold: 0.01 });
        this._visibilityObserver.observe(this);

        this._mutationObserver = new MutationObserver(() => {
            if (this.offsetParent !== null) {
                this._boundSettledRefreshMapSize();
            }
        });

        let parent = this.parentElement;
        for (let i = 0; i < 12 && parent; i++) {
            this._mutationObserver.observe(parent, { attributes: true, attributeFilter: ['class', 'style', 'hidden'] });
            parent = parent.parentElement;
        }

        window.addEventListener('resize', this._boundRefreshMapSize);
        document.addEventListener('livewire:navigated', this._boundSettledRefreshMapSize);
        document.addEventListener('fullscreenchange', this._boundFullscreenChange);
        document.addEventListener('keydown', this._boundEscapeKeyDown);

        this._refreshMapSize([0, 160, 420]);
    }

    disconnectedCallback() {
        super.disconnectedCallback();

        if (this._map) {
            this._map.remove();
            this._map = null;
        }

        this._resizeObserver?.disconnect();
        this._visibilityObserver?.disconnect();
        this._mutationObserver?.disconnect();
        this._clearSizeRefreshTimeouts();
        this._clearTileRecoveryTimeouts();
        this._restoreFullscreenDocumentState();
        window.removeEventListener('resize', this._boundRefreshMapSize);
        document.removeEventListener('livewire:navigated', this._boundSettledRefreshMapSize);
        document.removeEventListener('fullscreenchange', this._boundFullscreenChange);
        document.removeEventListener('keydown', this._boundEscapeKeyDown);
    }

    updated(changed) {
        if (changed.has('state') && !this._isProgrammaticUpdate) {
            if (this._map && this._lat != null && this._lng != null) {
                this._syncMarkerToProperties();
            }
        }
    }

    _initMap() {
        const el = this.renderRoot.querySelector('.map-picker-leaflet-pane');
        if (!el || this._map) {
            return;
        }

        const centerLat = this._lat ?? 41.9028;
        const centerLng = this._lng ?? 12.4964;

        this._map = L.map(el, {
            center: [centerLat, centerLng],
            zoom: this.zoom,
            zoomControl: false,
            attributionControl: false,
        });

        this._layers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this._map);
        this._layers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19 });
        this._layers.topo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17 });

        this._map.on('click', (event) => this._handleMapInteraction(event.latlng.lat, event.latlng.lng, 'click'));
        this._map.on('tileerror', () => this._scheduleTileRedraw());

        if (this._lat != null && this._lng != null) {
            this._syncMarkerToProperties();
        } else if (this.geolocateWhenEmpty) {
            void this._requestGeolocation();
        }

        this._refreshMapSize([0, 120, 280]);
    }

    _clearSizeRefreshTimeouts() {
        this._sizeRefreshTimeouts.forEach((timeoutId) => window.clearTimeout(timeoutId));
        this._sizeRefreshTimeouts = [];
    }

    _clearTileRecoveryTimeouts() {
        this._tileRecoveryTimeouts.forEach((timeoutId) => window.clearTimeout(timeoutId));
        this._tileRecoveryTimeouts = [];
    }

    _refreshMapSize = (delays = [0]) => {
        if (!this._map) {
            return;
        }

        this._clearSizeRefreshTimeouts();

        delays.forEach((delay) => {
            const timeoutId = window.setTimeout(() => {
                window.requestAnimationFrame(() => {
                    const pane = this.renderRoot.querySelector('.map-picker-leaflet-pane');
                    const rect = pane?.getBoundingClientRect();

                    if (!rect || rect.width <= 0 || rect.height <= 0) {
                        return;
                    }

                    const sizeKey = `${Math.round(rect.width)}x${Math.round(rect.height)}`;
                    if (delay > 0 && this._lastMeasuredSize === sizeKey) {
                        return;
                    }

                    this._lastMeasuredSize = sizeKey;
                    this._map?.invalidateSize({ animate: false, pan: false });
                });
            }, delay);

            this._sizeRefreshTimeouts.push(timeoutId);
        });
    };

    _redrawTileLayers() {
        const activeLayer = this._layers[this._currentLayer];
        if (activeLayer && this._map?.hasLayer(activeLayer) && typeof activeLayer.redraw === 'function') {
            activeLayer.redraw();
        }
    }

    _isSameCoordinatePair(latA, lngA, latB, lngB, tolerance = 0.000001) {
        return Math.abs(latA - latB) <= tolerance && Math.abs(lngA - lngB) <= tolerance;
    }

    _scheduleTileRedraw() {
        this._clearTileRecoveryTimeouts();

        [260, 620].forEach((delay, index, delays) => {
            const timeoutId = window.setTimeout(() => {
                if (!(this.offsetParent !== null || this.isFullscreen)) {
                    return;
                }

                this._refreshMapSize([0]);
                if (index === delays.length - 1) {
                    this._redrawTileLayers();
                }
            }, delay);

            this._tileRecoveryTimeouts.push(timeoutId);
        });
    }

    _handleMapInteraction(lat, lng, source = 'manual') {
        this._isProgrammaticUpdate = true;
        const latFixed = parseFloat(lat.toFixed(6));
        const lngFixed = parseFloat(lng.toFixed(6));

        if (this.state) {
            this.state.latitude = latFixed;
            this.state.longitude = lngFixed;
        }

        this._updateMarker(latFixed, lngFixed);

        this.dispatchEvent(new CustomEvent('coords-changed', {
            detail: { latitude: latFixed, longitude: lngFixed, source },
            bubbles: true,
            composed: true,
        }));

        window.setTimeout(() => {
            this._isProgrammaticUpdate = false;
        }, 100);
    }

    setCoordinates(lat, lng, source = 'programmatic') {
        const latitude = Number.parseFloat(lat);
        const longitude = Number.parseFloat(lng);

        if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
            return;
        }

        this._handleMapInteraction(latitude, longitude, source);

        if (this._map) {
            this._map.setView([latitude, longitude], Math.max(this._map.getZoom(), 16), {
                animate: true,
            });
            this._refreshMapSize([0, 120]);
        }
    }

    _updateMarker(lat, lng) {
        if (!this._map) {
            return;
        }

        if (!this._marker) {
            this._marker = L.marker([lat, lng], {
                draggable: true,
                icon: createMapPickerLeafletIcon(L),
            }).addTo(this._map);
            this._marker.on('dragend', (event) => {
                const position = event.target.getLatLng();
                this._handleMapInteraction(position.lat, position.lng, 'drag');
            });
        } else {
            this._marker.setLatLng([lat, lng]);
        }
    }

    _syncMarkerToProperties() {
        if (!this._map) {
            return;
        }

        const lat = this._lat;
        const lng = this._lng;
        if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
            return;
        }

        const markerLatLng = this._marker?.getLatLng();
        const mapCenter = this._map.getCenter();
        const markerAlreadySynced = markerLatLng
            ? this._isSameCoordinatePair(markerLatLng.lat, markerLatLng.lng, lat, lng)
            : false;
        const centerAlreadySynced = this._isSameCoordinatePair(mapCenter.lat, mapCenter.lng, lat, lng, 0.0005);
        const nextZoom = Math.max(this._map.getZoom(), this.zoom);
        const zoomChanged = this._map.getZoom() !== nextZoom;

        this._updateMarker(lat, lng);

        if (!centerAlreadySynced || zoomChanged) {
            this._map.setView([lat, lng], nextZoom, { animate: false });
            this._refreshMapSize([0, 120]);
        }
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
        this._refreshMapSize([0, 120]);
    }

    async _toggleFullscreen() {
        const container = this.renderRoot.querySelector('.map-container');
        const entering = !this.isFullscreen;

        if (entering) {
            this._previousBodyOverflow = document.body.style.overflow;
            this._previousHtmlOverflow = document.documentElement.style.overflow;
            document.documentElement.classList.add('geo-map-fullscreen-active');
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';

            if (container?.requestFullscreen && !document.fullscreenElement) {
                await container.requestFullscreen().catch(() => undefined);
            }
        } else if (document.fullscreenElement && document.exitFullscreen) {
            await document.exitFullscreen().catch(() => undefined);
        }

        this.isFullscreen = entering;

        if (!this.isFullscreen) {
            this._restoreFullscreenDocumentState();
        }

        this.dispatchEvent(new CustomEvent('fullscreen-changed', {
            detail: { isFullscreen: this.isFullscreen },
            bubbles: true,
            composed: true,
        }));

        this._refreshMapSize([0, 160, 380]);
        this._scheduleTileRedraw();
    }

    _syncFullscreenState() {
        const active = !!document.fullscreenElement;

        if (this.isFullscreen !== active) {
            this.isFullscreen = active;
        }

        if (!active) {
            this._restoreFullscreenDocumentState();
        }

        this._refreshMapSize([0, 160, 380]);
        this._scheduleTileRedraw();
    }

    _restoreFullscreenDocumentState() {
        document.documentElement.classList.remove('geo-map-fullscreen-active');
        document.body.style.overflow = this._previousBodyOverflow;
        document.documentElement.style.overflow = this._previousHtmlOverflow;
    }

    _zoomIn() {
        if (this._map) {
            this._map.zoomIn();
            this._refreshMapSize([0, 120]);
        }
    }

    _zoomOut() {
        if (this._map) {
            this._map.zoomOut();
            this._refreshMapSize([0, 120]);
        }
    }

    async _requestGeolocation() {
        if (!navigator.geolocation) {
            return;
        }

        this.isLocating = true;
        this.requestUpdate();

        return new Promise((resolve) => {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    this._handleMapInteraction(lat, lng, 'geolocation');
                    if (this._map) {
                        this._map.setView([lat, lng], 16, { animate: false });
                        this._refreshMapSize([0, 120]);
                    }
                    this.isLocating = false;
                    this.requestUpdate();
                    resolve(true);
                },
                () => {
                    this.isLocating = false;
                    this.requestUpdate();
                    resolve(false);
                },
                { enableHighAccuracy: true, timeout: 5000 }
            );
        });
    }
}

if (!customElements.get('coordinate-picker-lit')) {
    customElements.define('coordinate-picker-lit', CoordinatePickerField);
}
