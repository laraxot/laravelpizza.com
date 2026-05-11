import { LitElement, html } from 'lit';
import { guard } from 'lit/directives/guard.js';
import 'leaflet/dist/leaflet.css';
import { mapPickerStylesText } from './map-picker-styles.js';
import { renderControls, switchLayer, toggleFullscreen, zoomIn, zoomOut, requestGeolocation } from './map-picker-controls.js';
import { renderSearch } from './map-picker-search.js';
import { initMap, handleMapInteraction, updateMarker, syncMarkerToProperties } from './map-picker-events.js';
import { refreshMapSize, bindRefreshHandler, cleanupObservers } from './map-picker-resize.js';
import { resolveStateCoordinates } from './geo-location-utils.js';

/**
 * CoordinatePickerField - Lit component for geographic coordinate selection
 * Uses Leaflet for map rendering. Light DOM for max compatibility.
 * Extracted modules: map-picker-{layers,controls,events,resize,styles,marker-config}.js
 */
export class CoordinatePickerField extends LitElement {
    static properties = {
        state: { type: Object },
        zoom: { type: Number },
        height: { type: String },
        isLocating: { type: Boolean, state: true },
        isFullscreen: { type: Boolean, state: true },
        geolocateWhenEmpty: { type: Boolean, attribute: 'geolocate-when-empty' },
        labels: { type: Object },
        provider: { type: String },
        showSearch: { type: Boolean, attribute: 'show-search' },
        searchQuery: { type: String, state: true },
        searchResults: { type: Array, state: true },
        showSearchResults: { type: Boolean, state: true },
        isSearching: { type: Boolean, state: true },
        _isProgrammaticUpdate: { type: Boolean, state: true },
    };

    get _lat() { return resolveStateCoordinates(this.state).lat; }
    get _lng() { return resolveStateCoordinates(this.state).lng; }

    createRenderRoot() { return this; }

    constructor() {
        super();
        this.state = null;
        this.zoom = 13;
        this.height = '400px';
        this.isLocating = false;
        this.isFullscreen = false;
        this.geolocateWhenEmpty = false;
        this.geolocated = false;
        this.labels = {};
        this.provider = 'osm';
        this.showSearch = true;
        this.searchQuery = '';
        this.searchResults = [];
        this.showSearchResults = false;
        this.isSearching = false;
        this._isProgrammaticUpdate = false;
        this._layers = {};
        this._marker = null;
        this._map = null;
        this._lastMeasuredSize = null;
        this._debounceTimeout = null;
        this._boundRefreshMapSize = null;
        this._resizeObserver = null;
        this._mutationObserver = null;
        this._currentLayer = 'street';
    }

    render() {
        const l = this.labels || {};
        return html`
            <style>
                coordinate-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${mapPickerStylesText}
                .map-container { min-height: 200px; }
                .map-container.is-fullscreen { position: fixed !important; inset: 0 !important; width: 100vw !important; height: 100vh !important; border: none !important; border-radius: 0 !important; z-index: 9999 !important; }
                .map-container.is-fullscreen .map-picker-leaflet-pane { height: 100vh !important; }
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
            </style>
            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}" style="--map-height: ${this.height}">
                ${guard([], () => html`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
                ${this.showSearch ? renderSearch(this) : ''}
                ${renderControls(this)}
                <div class="loading-overlay ${this.isLocating ? 'active' : ''}">
                    <div class="spinner"></div>
                </div>
            </div>
        `;
    }

    firstUpdated() {
        initMap(this);
        this._boundRefreshMapSize = () => refreshMapSize(this);
        bindRefreshHandler(this);
        this._handleEscapeKey = (e) => {
            if (e.key === 'Escape' && this.isFullscreen) this._toggleFullscreen();
        };
        document.addEventListener('keydown', this._handleEscapeKey);
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this._map) { this._map.remove(); this._map = null; }
        cleanupObservers(this);
        if (this._handleEscapeKey) {
            document.removeEventListener('keydown', this._handleEscapeKey);
        }
    }

    updated(changed) {
        if (changed.has('state') && !this._isProgrammaticUpdate) {
            if (this._map && this._lat != null && this._lng != null) {
                syncMarkerToProperties(this);
            }
        }
    }

    _switchLayer() { switchLayer(this); }
    _toggleFullscreen() { toggleFullscreen(this); }
    _zoomIn() { zoomIn(this); }
    _zoomOut() { zoomOut(this); }
    _requestGeolocation() { requestGeolocation(this); }
    _handleMapInteraction(lat, lng, source) { handleMapInteraction(this, lat, lng, source); }
    _updateMarker(lat, lng) { updateMarker(this, lat, lng); }
    _syncMarkerToProperties() { syncMarkerToProperties(this); }
    _refreshMapSize() { refreshMapSize(this); }
    _initMap() { initMap(this); }

    _handleSearchSelection(result, lat, lng) {
        this.state = {
            ...(this.state || {}),
            lat,
            lng,
            latitude: lat,
            longitude: lng,
            address: result.display_name || this.state?.address || '',
        };

        this._handleMapInteraction(lat, lng, 'search');
        this._map?.setView([lat, lng], Math.max(this._map.getZoom(), 16));
    }

    setCoordinates(lat, lng, source = 'programmatic') {
        this._handleMapInteraction(lat, lng, source);
        this._map?.setView([lat, lng], Math.max(this._map.getZoom(), this.zoom));
    }
}

if (!customElements.get('coordinate-picker-lit')) {
    customElements.define('coordinate-picker-lit', CoordinatePickerField);
}
