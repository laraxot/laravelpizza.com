import { LitElement, html } from 'lit';
import L from 'leaflet';
window.L = L;
import 'leaflet/dist/leaflet.css';
import './leaflet.markercluster.local.js';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
import 'leaflet.heat';
import { renderControls, switchLayer, toggleFullscreen, zoomIn, zoomOut, requestGeolocation } from './map-picker-controls.js';
import { renderSearch } from './map-picker-search.js';
import { buildMapLayers } from './map-picker-layers.js';
import { mapPickerStylesText } from './map-picker-styles.js';
import { createGeoMapLeafletIcon } from './map-marker-config.js';
import { geoIcon } from './geo-heroicons.js';

const DEFAULT_TICKETS_JSON_URL = '/data/tickets.json';
const DEFAULT_CENTER = [41.9028, 12.4964];
const DEFAULT_ZOOM = 6;

class GeoMapLit extends LitElement {
    static properties = {
        filterType:        { type: String },
        activeLayer:       { type: String },
        isFullscreen:      { type: Boolean, state: true },
        height:            { type: String },
        _searchOpen:       { type: Boolean, state: true },
        labels:            { type: Object },
        dataUrl:           { type: String, attribute: 'data-url' },
        searchQuery:       { type: String,  state: true },
        searchResults:     { type: Array,   state: true },
        showSearchResults: { type: Boolean, state: true },
        isSearching:       { type: Boolean, state: true },
        isLocating:        { type: Boolean, state: true },
    };

    createRenderRoot() { return this; }

    constructor() {
        super();
        this.filterType = null;
        this.activeLayer = 'markers';
        this.isFullscreen = false;
        this._searchOpen = false;
        this.searchQuery = '';
        this.searchResults = [];
        this.showSearchResults = false;
        this.isSearching = false;
        this.isLocating = false;
        this.labels = {
            fullscreen: 'Schermo intero',
            close_fullscreen: 'Esci da schermo intero',
            use_location: 'Usa la mia posizione',
            switch_layer: 'Cambia layer',
            zoom_in: 'Aumenta zoom',
            zoom_out: 'Diminuisci zoom',
            search: 'Cerca',
            search_placeholder: 'Cerca indirizzo...',
        };
        this.height = '450px';
        this.dataUrl = DEFAULT_TICKETS_JSON_URL;
        this._currentLayer = 'street';
        this._allFeatures = [];
        this._allMarkers = [];
        this._layers = {};
        this._boundDocumentClickHandler = (event) => this._handleDocumentClick(event);
        this._boundDocumentKeydownHandler = (event) => this._handleDocumentKeydown(event);
    }

    render() {
        return html`
            <style>
                ${mapPickerStylesText}
                geo-map-lit { display: block; width: 100%; min-height: 320px; }
                .geo-map-leaflet { width: 100%; height: 100%; min-height: 320px; }
                .geo-map-marker-wrapper svg { display: block; }
                .leaflet-div-icon { background: transparent !important; border: none !important; }
                .geo-address-search { position: absolute !important; top: 1rem !important; right: 1rem !important; z-index: 3001 !important; display: flex !important; flex-wrap: wrap !important; gap: 0.4rem !important; background: rgba(255,255,255,0.95) !important; padding: 0.4rem !important; border-radius: 0.75rem !important; box-shadow: 0 4px 14px rgba(0,0,0,.15) !important; max-width: 280px !important; width: min(280px, calc(100% - 5rem)) !important; align-items: center !important; backdrop-filter: blur(6px) !important; }
                .geo-address-search .map-picker-search-input { flex: 1 !important; border: 1px solid #d1d5db !important; border-radius: 0.5rem !important; padding: 0.4rem 0.6rem !important; font-size: 0.85rem !important; min-width: 0 !important; outline: none !important; color: #17324d !important; background: #fff !important; height: auto !important; box-shadow: none !important; }
                .geo-address-search .ctrl-btn { flex: 0 0 2.5rem !important; width: 2.5rem !important; height: 2.5rem !important; min-width: 2.5rem !important; }
                .geo-address-search-results { position: absolute !important; top: 100% !important; left: 0 !important; right: 0 !important; max-height: 12rem !important; margin: 0.25rem 0 0 !important; padding: 0.25rem 0 !important; overflow: auto !important; list-style: none !important; border: 1px solid #d1d5db !important; border-radius: 0.75rem !important; background: #fff !important; color: #17324d !important; box-shadow: 0 10px 24px rgba(23,50,77,.16) !important; z-index: 3002 !important; }
                .geo-address-search-results li { padding: 0.5rem 0.75rem !important; cursor: pointer !important; font-size: 0.8125rem !important; line-height: 1.25 !important; list-style: none !important; }
                .geo-address-search-results li:hover { background: #eef6ff !important; color: #0050a4 !important; }
                .geo-popup { padding: 2px 0; }
                .geo-popup-title { display: block; font-size: 14px; margin-bottom: 4px; color: #17324d; font-weight: 700; }
                .geo-popup-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; color: #fff; margin-bottom: 6px; font-weight: 600; }
                .geo-popup-description { font-size: 12.5px; line-height: 1.4; color: #4b5563; margin-top: 4px; }
                html.geo-map-fullscreen-active, html.geo-map-fullscreen-active body { overflow: hidden !important; }
            </style>
            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}"
                 @click=${(event) => this._handleSurfaceClick(event)}
                 style="position:relative;--map-height:${this.height || '450px'};">
                <div class="geo-map-leaflet" style="width:100%;height:100%;"></div>
                ${renderControls(this)}
                ${this._searchOpen ? renderSearch(this) : ''}
            </div>
        `;
    }

    _toggleSearch() {
        this._searchOpen = !this._searchOpen;
        this.requestUpdate();
    }

    connectedCallback() {
        super.connectedCallback();
        document.addEventListener('click', this._boundDocumentClickHandler, true);
        document.addEventListener('keydown', this._boundDocumentKeydownHandler, true);
        window.addEventListener('keydown', this._boundDocumentKeydownHandler, true);
        window.addEventListener('pointerdown', this._boundDocumentClickHandler, true);
    }

    _toggleFullscreen() {
        void toggleFullscreen(this);
    }

    _switchLayer() { switchLayer(this); }
    _zoomIn() { zoomIn(this); }
    _zoomOut() { zoomOut(this); }
    _requestGeolocation() { requestGeolocation(this); }

    firstUpdated() {
        super.firstUpdated();
        this._initMap();
    }

    _initMap() {
        const container = this.renderRoot.querySelector ? this.renderRoot.querySelector('.geo-map-leaflet') : null;
        if (!container) return;
        this._map = L.map(container, {
            center: DEFAULT_CENTER,
            zoom: DEFAULT_ZOOM,
            minZoom: 3,
            maxZoom: 19,
            zoomControl: false,
        });
        this._map.on('click', () => this._closeSearchPanel());
        this._layers = buildMapLayers(L);
        this._layers[this._currentLayer].addTo(this._map);

        if (typeof L.markerClusterGroup === 'function') {
            this._markersLayer = L.markerClusterGroup({
                maxClusterRadius: (z) => z < 12 ? 80 : 45,
                minimumClusterSize: 2,
                chunkedLoading: true,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                removeOutsideVisibleBounds: true,
                iconCreateFunction: (cluster) => this._createClusterIcon(cluster),
            });
            this._map.addLayer(this._markersLayer);
        } else {
            console.warn('[geo-map-lit] L.markerClusterGroup not found, falling back to LayerGroup');
            this._markersLayer = L.layerGroup().addTo(this._map);
        }

        this._map.on('popupopen', (e) => {
            const mapH = this._map.getContainer().clientHeight;
            const mapW = this._map.getContainer().clientWidth;
            e.popup.options.maxHeight = Math.floor(mapH * 0.4);
            e.popup.options.maxWidth  = Math.floor(mapW * 0.9);
            e.popup.update();
        });

        this._map.on('zoomend', () => this._markersLayer?.refreshClusters?.());

        this._mutationObserver = new MutationObserver(() => {
            if (this.offsetParent !== null && this._map) {
                [0, 80, 180, 350, 700, 1200].forEach(d => setTimeout(() => this._map?.invalidateSize(), d));
            }
        });
        let parent = this.parentElement;
        for (let i = 0; i < 12 && parent; i++) {
            this._mutationObserver.observe(parent, { attributes: true, attributeFilter: ['class', 'style', 'hidden'] });
            parent = parent.parentElement;
        }

        this._loadGeoJson();
    }

    _createClusterIcon(cluster) {
        const markers = cluster.getAllChildMarkers();
        const count = markers.length;
        const zoom = this._map ? this._map.getZoom() : 0;

        if (zoom >= 8) {
            const typesPresent = {};
            markers.forEach(m => {
                const t = m.options.typeValue;
                if (t && !typesPresent[t]) {
                    typesPresent[t] = m.options.typeColor || '#607d8b';
                }
            });
            const dots = Object.entries(typesPresent)
                .map(([type, color]) =>
                    `<svg aria-label="${type}" title="${type}" viewBox="0 0 14 14" width="14" height="14" style="display:inline-block;">` +
                    `<circle cx="7" cy="7" r="6" fill="${color}" stroke="#fff" stroke-width="1.5"/></svg>`
                ).join('');
            return L.divIcon({
                html: `<div class="circle" style="width:80px;height:80px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><strong>${count}</strong><div style="display:flex;gap:2px;flex-wrap:wrap;justify-content:center;max-width:58px;">${dots}</div></div>`,
                className: '',
                iconSize: L.point(80, 80),
            });
        }
        return L.divIcon({
            html: `<div class="circle" style="width:80px;height:80px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><strong>${count}</strong></div>`,
            className: '',
            iconSize: L.point(80, 80),
        });
    }

    _handleSearchSelection(result, lat, lng) {
        if (this._map) {
            this._map.setView([lat, lng], 15);
        }
        this._closeSearchPanel();
    }

    _handleDocumentClick(event) {
        if (!this._searchOpen) {
            return;
        }

        const path = typeof event.composedPath === 'function' ? event.composedPath() : [];
        const clickedInsideSearch = path.some((node) => node?.classList?.contains?.('geo-address-search'));
        const clickedToggle = path.some((node) => node?.classList?.contains?.('layer-controls-overlay'));

        if (!clickedInsideSearch && !clickedToggle) {
            this._closeSearchPanel();
        }
    }

    _handleSurfaceClick(event) {
        if (!this._searchOpen) {
            return;
        }

        const path = typeof event.composedPath === 'function' ? event.composedPath() : [];
        const clickedInsideSearch = path.some((node) => node?.classList?.contains?.('geo-address-search'));
        const clickedToggle = path.some((node) => node?.classList?.contains?.('layer-controls-overlay'));

        if (!clickedInsideSearch && !clickedToggle) {
            this._closeSearchPanel();
        }
    }

    _handleDocumentKeydown(event) {
        if (!this._searchOpen) {
            return;
        }

        if (event.key === 'Escape' || event.key === 'Esc') {
            this._closeSearchPanel();
        }
    }

    _closeSearchPanel() {
        if (!this._searchOpen) {
            return;
        }

        this._searchOpen = false;
        this.searchQuery = '';
        this.searchResults = [];
        this.showSearchResults = false;
        this.requestUpdate();
    }

    _loadGeoJson() {
        const url = this.dataset?.url || this.dataUrl || DEFAULT_TICKETS_JSON_URL;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (!data || !data.features) {
                    console.warn('[geo-map-lit] No features in GeoJSON');
                    return;
                }
                
                console.log('--- MEGA DEBUG 123 ---');
                console.log('[geo-map-lit] Leaflet version:', L.version);
                console.log(data.features.length, 'features');
                
                const L_local = window.L || L;
                const newMarkers = [];
                this._allFeatures = data.features;

                data.features.forEach((feature, idx) => {
                    if (!feature.geometry?.coordinates) return;
                    const [lng, lat] = feature.geometry.coordinates;
                    if (isNaN(lat) || isNaN(lng)) return;

                    const p = feature.properties || {};
                    const color = p.type_color || '#0066cc';

                    try {
                        if (idx === 0) console.log(`[geo-map-lit] First marker LatLng: ${lat}, ${lng}`);
                        const marker = L_local.marker([lat, lng], {
                            icon: createGeoMapLeafletIcon(L_local, color),
                            typeValue: p.type,
                            typeColor: color,
                        });

                        marker.bindPopup(`
                            <div class="geo-popup">
                                <strong class="geo-popup-title">${p.title || ''}</strong>
                                <span class="geo-popup-badge" style="background:${color}">${p.type_label || ''}</span>
                                <br><small class="text-muted">${p.address || ''}</small>
                            </div>
                        `, {
                            maxWidth: 300,
                            className: 'geo-custom-popup'
                        });

                        newMarkers.push(marker);
                    } catch (err) {
                        console.error('[geo-map-lit] Error creating marker:', err);
                    }
                });

                if (this._markersLayer) {
                    this._markersLayer.clearLayers();
                    console.log(`[geo-map-lit] Adding ${newMarkers.length} markers to ClusterGroup...`);
                    
                    if (typeof this._markersLayer.addLayers === 'function') {
                        this._markersLayer.addLayers(newMarkers);
                    } else {
                        newMarkers.forEach(m => this._markersLayer.addLayer(m));
                    }
                    
                    try {
                        const bounds = this._markersLayer.getBounds();
                        if (bounds && typeof bounds.isValid === 'function' && bounds.isValid()) {
                            console.log('[geo-map-lit] Fitting map to marker bounds');
                            this._map.fitBounds(bounds, { padding: [30, 30] });
                        } else {
                            console.warn('[geo-map-lit] fitBounds skipped: Bounds are not valid.');
                        }
                    } catch (e) {
                        console.warn('[geo-map-lit] fitBounds error:', e.message);
                    }
                }

                // Heatmap (graceful fallback)
                const heatPoints = this._allFeatures
                    .filter(f => Array.isArray(f.geometry?.coordinates) && f.geometry.coordinates.length === 2)
                    .map(f => [f.geometry.coordinates[1], f.geometry.coordinates[0], 0.5]);
                
                try {
                    if (typeof L_local.heatLayer === 'function') {
                        if (this._heatLayer) this._map.removeLayer(this._heatLayer);
                        this._heatLayer = L_local.heatLayer(heatPoints, { radius: 25, blur: 15, maxZoom: 17, max: 0.8 });
                    }
                } catch (err) {
                    console.warn('[geo-map-lit] HeatLayer init failed:', err.message);
                }

                this._allMarkers = newMarkers;
                this.requestUpdate();
                this.dispatchEvent(new CustomEvent('geo-map-loaded', {
                    detail: {
                        count: this._allFeatures.length,
                        types: [...new Set(this._allFeatures.map(f => f.properties?.type).filter(Boolean))],
                    },
                    bubbles: true,
                    composed: true,
                }));
            })
            .catch(err => {
                console.error('[geo-map-lit] Error loading GeoJSON:', err);
                if (err.stack) console.error(err.stack);
            });
    }

    filterByType(type) {
        if (!this._markersLayer) return;
        this._markersLayer.clearLayers();
        const filtered = type ? this._allMarkers.filter(m => m.options.typeValue === type) : this._allMarkers;
        this._markersLayer.addLayers(filtered);
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        document.removeEventListener('click', this._boundDocumentClickHandler, true);
        document.removeEventListener('keydown', this._boundDocumentKeydownHandler, true);
        window.removeEventListener('keydown', this._boundDocumentKeydownHandler, true);
        window.removeEventListener('pointerdown', this._boundDocumentClickHandler, true);
        this._mutationObserver?.disconnect();
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }
}

if (!customElements.get('geo-map-lit')) {
    customElements.define('geo-map-lit', GeoMapLit);
}
