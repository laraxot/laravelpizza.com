import { LitElement, html } from 'lit';
import L from 'leaflet';
// Pre-plugin initialization: MUST be global for markercluster/heat
window.L = L;

import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster';
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

/**
 * map-lit.js
 * 1:1 Conversion of direktvermarkter.js (farmshops.eu)
 * Implements LOD clustering, AJAX popups, and auto-geolocation.
 */
class MapLit extends LitElement {
    static properties = {
        filterType:        { type: String },
        activeLayer:       { type: String },
        isFullscreen:      { type: Boolean, state: true },
        height:            { type: String },
        _searchOpen:       { type: Boolean, state: true },
        labels:            { type: Object },
        dataUrl:           { type: String, attribute: 'data-url' },
        // State for shared modules (renderSearch/renderControls)
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
        this._previousBodyOverflow = '';
        this._previousHtmlOverflow = '';
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
        this._isUserCentered = false;
    }

    render() {
        return html`
            <style>
                ${mapPickerStylesText}
                map-lit { display: block; width: 100%; min-height: 320px; }
                .geo-map-leaflet { width: 100%; height: 100%; min-height: 320px; }
                .geo-map-marker-wrapper svg { display: block; }
                .leaflet-div-icon { background: transparent !important; border: none !important; }
                
                /* farmshops.eu LOD cluster styles */
                .geo-cluster-circle { 
                    background: #fff; border: 2.5px solid #0066cc; border-radius: 50%;
                    width: 80px; height: 80px; display: flex; flex-direction: column; align-items: center;
                    justify-content: center; font-weight: 700; font-size: 15px; box-shadow: 0 2px 8px rgba(0,0,0,.35);
                    text-align: center; line-height: 1.1; box-sizing: border-box; color: #17324d; 
                    font-family: sans-serif; overflow: hidden;
                }
                .geo-cluster-type-icons { 
                    display: flex; gap: 3px; justify-content: center; flex-wrap: wrap; 
                    max-width: 58px; margin-top: 2px; 
                }

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

    _toggleFullscreen() { void toggleFullscreen(this); }
    _switchLayer() { switchLayer(this); }
    _zoomIn() { zoomIn(this); }
    _zoomOut() { zoomOut(this); }
    _requestGeolocation() { requestGeolocation(this, { showLoading: true }); }

    firstUpdated() {
        super.firstUpdated();
        this._initMap();
    }

    _initMap() {
        const container = this.renderRoot.querySelector('.geo-map-leaflet');
        if (!container) return;
        
        this._map = L.map(container, {
            center: DEFAULT_CENTER,
            zoom: DEFAULT_ZOOM,
            minZoom: 3,
            maxZoom: 19,
            zoomControl: false,
        });

        this._layers = buildMapLayers(L);
        this._layers[this._currentLayer].addTo(this._map);

        // Reference: direktvermarkter.js custom cluster group
        const clusterFactory = L.markerClusterGroup || (window.L && window.L.markerClusterGroup);
        if (typeof clusterFactory === 'function') {
            this._markersLayer = clusterFactory({
                // Reference: 80px radius < zoom 12, 45px radius >= zoom 12
                maxClusterRadius: (z) => z < 12 ? 80 : 45,
                minimumClusterSize: 2,
                chunkedLoading: true,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: true,
                zoomToBoundsOnClick: true,
                removeOutsideVisibleBounds: true,
                iconCreateFunction: (cluster) => this._createClusterIcon(cluster),
            });
            this._map.addLayer(this._markersLayer);
        } else {
            console.error('[map-lit] MarkerClusterGroup not found. Ensure "leaflet.markercluster" is loaded.');
            this._markersLayer = L.layerGroup().addTo(this._map);
        }

        this._map.on('popupopen', (e) => {
            const mapH = this._map.getContainer().clientHeight;
            const mapW = this._map.getContainer().clientWidth;
            e.popup.options.maxHeight = Math.floor(mapH * 0.4);
            e.popup.options.maxWidth  = Math.floor(mapW * 0.9);
            e.popup.update();
        });

        this._map.on('zoomend', () => {
            if (this._markersLayer && typeof this._markersLayer.refreshClusters === 'function') {
                this._markersLayer.refreshClusters();
            }
        });

        this._setupMutationObserver();
        
        // Auto-center on geolocation immediately
        requestGeolocation(this, { showLoading: false });

        this._loadGeoJson();
    }

    _setupMutationObserver() {
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
    }

    /**
     * LOD Cluster Icon (1:1 from direktvermarkter.js)
     */
    _createClusterIcon(cluster) {
        const markers = cluster.getAllChildMarkers();
        const count = markers.length;
        const zoom = this._map ? this._map.getZoom() : 0;

        // Reference: category icons breakdown if zoom >= 8
        if (zoom >= 8) {
            const typesPresent = {};
            markers.forEach(m => {
                const t = m.options.typeValue;
                if (t && !typesPresent[t]) {
                    typesPresent[t] = m.options.typeColor || '#607d8b';
                }
            });
            const icons = Object.entries(typesPresent)
                .map(([, color]) =>
                    `<svg style="display:inline-block;flex:0 0 auto;" viewBox="0 0 14 14" width="14" height="14">` +
                    `<circle cx="7" cy="7" r="6" fill="${color}" stroke="#fff" stroke-width="1.5"/></svg>`
                ).join('');
            
            return L.divIcon({
                html: `<div class="geo-cluster-circle"><strong>${count}</strong><div class="geo-cluster-type-icons">${icons}</div></div>`,
                className: 'geo-cluster-wrapper',
                iconSize: L.point(80, 80),
            });
        }

        return L.divIcon({
            html: `<div class="geo-cluster-circle"><strong>${count}</strong></div>`,
            className: 'geo-cluster-wrapper',
            iconSize: L.point(80, 80),
        });
    }

    _loadGeoJson() {
        const url = this.dataset?.url || this.dataUrl || DEFAULT_TICKETS_JSON_URL;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (!data || !Array.isArray(data.features)) return;

                // STRICT VALIDATION: prevents "TypeError: lat"
                const validFeatures = data.features.filter(f => 
                    f.geometry && 
                    Array.isArray(f.geometry.coordinates) && 
                    f.geometry.coordinates.length >= 2 &&
                    !isNaN(parseFloat(f.geometry.coordinates[0])) &&
                    !isNaN(parseFloat(f.geometry.coordinates[1]))
                );

                this._allFeatures = validFeatures;
                this._allMarkers = [];
                
                if (this._markersLayer) {
                    this._markersLayer.clearLayers();
                }

                // Reference pattern: use pointToLayer + onEachFeature
                this._geojsonLayer = L.geoJson({ type: 'FeatureCollection', features: validFeatures }, {
                    pointToLayer: (feature, latlng) => {
                        const p = feature.properties || {};
                        const type = p.p || p.type || 'other'; // direktvermarkter uses .p
                        const color = p.type_color || this._getFarmshopColor(type);
                        
                        const marker = L.marker(latlng, {
                            icon: createGeoMapLeafletIcon(L, color),
                            typeValue: type,
                            typeColor: color,
                            typeLabel: p.type_label || type,
                        });
                        this._allMarkers.push(marker);
                        return marker;
                    },
                    onEachFeature: (feature, layer) => {
                        const p = feature.properties || {};
                        const type = p.p || p.type || 'other';
                        const color = p.type_color || this._getFarmshopColor(type);
                        
                        layer.bindPopup(`
                            <div class="geo-popup">
                                <strong class="geo-popup-title">${p.title || p.name || ''}</strong>
                                <span class="geo-popup-badge" style="background:${color}">${p.type_label || type}</span>
                                <br><small class="text-muted">${p.address || ''}</small>
                            </div>
                        `, { maxWidth: 260 });

                        // Lazy details fetch
                        if (p.id) {
                            layer.once('click', () => {
                                fetch(`/api/ticket-details/${p.id}`)
                                    .then(res => res.ok ? res.json() : null)
                                    .then(detail => {
                                        if (!detail) return;
                                        const popupContent = `
                                            <div class="geo-popup">
                                                <strong class="geo-popup-title">${detail.title || p.title || ''}</strong>
                                                <span class="geo-popup-badge" style="background:${color}">${p.type_label || type}</span>
                                                <p class="geo-popup-description">${detail.description || ''}</p>
                                                ${detail.images && detail.images.length > 0 ? `<div class="geo-popup-gallery" style="display:grid;grid-template-columns:1fr;gap:4px;margin-top:8px;">${detail.images.map(img => `<img src="${img}" style="width:100%;height:100px;object-fit:cover;border-radius:4px;">`).join('')}</div>` : ''}
                                            </div>
                                        `;
                                        layer.getPopup().setContent(popupContent);
                                    })
                                    .catch(() => {});
                            });
                        }
                    },
                });

                if (this._markersLayer) {
                    this._markersLayer.addLayer(this._geojsonLayer);
                }

                // Auto-fit if user didn't permit geolocation
                setTimeout(() => {
                    if (!this._isUserCentered) {
                        try {
                            const bounds = this._geojsonLayer.getBounds();
                            if (bounds && bounds.isValid()) {
                                this._map.fitBounds(bounds, { padding: [40, 40], maxZoom: 11 });
                            }
                        } catch (e) {
                            console.warn('[map-lit] fitBounds skipped:', e.message);
                        }
                    }
                }, 1000);

                this.dispatchEvent(new CustomEvent('geo-map-loaded', {
                    detail: {
                        count: this._allFeatures.length,
                        types: [...new Set(this._allFeatures.map(f => f.properties?.p || f.properties?.type).filter(Boolean))],
                    },
                    bubbles: true,
                    composed: true,
                }));
            })
            .catch(err => console.error('[map-lit] Error loading GeoJSON:', err));
    }

    _getFarmshopColor(type) {
        // direktvermarkter.js parity colors
        const colors = {
            'farm': '#28a745',
            'marketplace': '#e63946',
            'beekeeper': '#ffc107',
            'vending_machine': '#fd7e14',
            'other': '#6c757d'
        };
        return colors[type] || colors['other'];
    }

    filterByType(type) {
        if (!this._markersLayer) return;
        this._markersLayer.clearLayers();
        const filtered = type ? this._allMarkers.filter(m => m.options.typeValue === type) : this._allMarkers;
        this._markersLayer.addLayers(filtered);
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this._mutationObserver?.disconnect();
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
    }
}

if (!customElements.get('map-lit')) {
    customElements.define('map-lit', MapLit);
}
export default MapLit;
