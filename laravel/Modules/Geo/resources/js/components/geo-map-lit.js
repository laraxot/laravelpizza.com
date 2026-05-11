import { LitElement, html } from 'lit';
import L from 'leaflet';
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

const DEFAULT_TICKETS_JSON_URL = '/data/tickets.json';
const DEFAULT_CENTER = [41.9028, 12.4964];
const DEFAULT_ZOOM = 6;

class GeoMapLit extends LitElement {
    static properties = {
        isFullscreen:      { type: Boolean, state: true },
        height:            { type: String },
        _searchOpen:       { type: Boolean, state: true },
        labels:            { type: Object },
        dataUrl:           { type: String, attribute: 'data-url' },
        _mapStatus:        { type: String, state: true },
        _mapStatusMessage: { type: String, state: true },
    };

    createRenderRoot() { return this; }

    constructor() {
        super();
        this.isFullscreen = false;
        this._searchOpen = false;
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
        this._allMarkers = [];
        this._mapStatus = 'idle';
        this._mapStatusMessage = '';
    }

    render() {
        return html`
            <style>
                ${mapPickerStylesText}
                geo-map-lit { display: block; width: 100%; min-height: 320px; }
                .geo-map-leaflet { width: 100%; height: 100%; min-height: 320px; }
                .geo-map-marker-wrapper svg { display: block; }
                .leaflet-div-icon { background: transparent !important; border: none !important; }
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
                ${(this._mapStatus === 'empty' || this._mapStatus === 'error') ? html`
                    <div class="geo-map-status ${this._mapStatus}">
                        ${this._mapStatusMessage}
                    </div>
                ` : ''}
            </div>
        `;
    }

    _toggleSearch() { this._searchOpen = !this._searchOpen; this.requestUpdate(); }
    _toggleFullscreen() { void toggleFullscreen(this); }
    _switchLayer() { switchLayer(this); }
    _zoomIn() { zoomIn(this); }
    _zoomOut() { zoomOut(this); }

    firstUpdated() { super.firstUpdated(); this._initMap(); }

    async _initMap() {
        const container = this.querySelector('.geo-map-leaflet');
        if (!container) {
            console.error('[geo-map-lit] Map container not found');
            this._mapStatus = 'error';
            this._mapStatusMessage = 'Contenitore mappa non trovato.';
            return;
        }

        this._map = L.map(container, {
            center: DEFAULT_CENTER,
            zoom: DEFAULT_ZOOM,
            minZoom: 3,
            maxZoom: 19,
            zoomControl: false,
        });

        this._layers = buildMapLayers(L);
        this._layers['street'].addTo(this._map);

        // Check if markerClusterGroup is available
        console.log('[geo-map-lit] L.markerClusterGroup:', typeof L.markerClusterGroup);

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
            console.log('[geo-map-lit] markerClusterGroup initialized');
        } else {
            console.error('[geo-map-lit] MarkerClusterGroup not available');
            this._markersLayer = L.layerGroup();
            this._map.addLayer(this._markersLayer);
        }

        // Try geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    console.log(`[geo-map-lit] Geolocation: ${lat}, ${lng}`);
                    this._map.setView([lat, lng], Math.max(this._map.getZoom(), 13));
                },
                (error) => console.log('[geo-map-lit] Geolocation failed:', error.message),
                { timeout: 5000, enableHighAccuracy: false }
            );
        }

        this._setupMutationObserver();
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

    _createClusterIcon(cluster) {
        const markers = cluster.getAllChildMarkers();
        const count = markers.length;
        const zoom = this._map ? this._map.getZoom() : 0;

        if (count === 1) {
            return markers[0].options.icon;
        }

        const circleStyle = 'background:#fff;border:2.5px solid #0066cc;border-radius:50%;width:80px;height:80px;display:flex;flex-direction:column;align-items:center;justify-content:center;font-weight:700;font-size:15px;box-shadow:0 2px 8px rgba(0,0,0,.35);text-align:center;line-height:1.1;box-sizing:border-box;font-family:sans-serif;color:#17324d;overflow:hidden;';

        if (zoom >= 8) {
            const typesPresent = {};
            markers.forEach(m => {
                const t = m.options.typeValue;
                if (t && !typesPresent[t]) {
                    typesPresent[t] = m.options.typeColor || '#607d8b';
                }
            });
            const icons = Object.entries(typesPresent)
                .map(([, color]) => `<svg style="display:inline-block;flex:0 0 auto;" viewBox="0 0 14 14" width="14" height="14"><circle cx="7" cy="7" r="6" fill="${color}" stroke="#fff" stroke-width="1.5"/></svg>`)
                .join('');
            return L.divIcon({
                html: `<div style="${circleStyle}"><strong>${count}</strong><div style="display:flex;gap:3px;justify-content:center;flex-wrap:wrap;max-width:58px;margin-top:2px;">${icons}</div></div>`,
                className: '',
                iconSize: L.point(80, 80),
                iconAnchor: L.point(40, 40)
            });
        }

        return L.divIcon({
            html: `<div style="${circleStyle}"><strong>${count}</strong></div>`,
            className: '',
            iconSize: L.point(80, 80),
            iconAnchor: L.point(40, 40)
        });
    }

    async _loadGeoJson() {
        const url = this.dataset?.url || this.dataUrl || DEFAULT_TICKETS_JSON_URL;
        this._mapStatus = 'loading';
        this._mapStatusMessage = '';

        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP ${response.status} on ${url}`);
            const data = await response.json();
            const features = (data.features || []).filter(f => f?.geometry?.type === 'Point' && Array.isArray(f?.geometry?.coordinates));

            this._allMarkers = [];
            if (this._markersLayer) {
                this._markersLayer.clearLayers();
            }

            let validCount = 0;
            let invalidCount = 0;

            features.forEach((feature, index) => {
                const p = feature.properties || {};
                const coords = feature.geometry.coordinates;

                if (!coords || coords.length < 2) {
                    console.warn(`[geo-map-lit] Feature ${index} missing coordinates`);
                    invalidCount++;
                    return;
                }

                const lng = Number(coords[0]);
                const lat = Number(coords[1]);

                if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                    console.warn(`[geo-map-lit] Feature ${index} invalid coordinates: lat=${lat}, lng=${lng}`);
                    invalidCount++;
                    return;
                }

                if (lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                    console.warn(`[geo-map-lit] Feature ${index} out of range: lat=${lat}, lng=${lng}`);
                    invalidCount++;
                    return;
                }

                try {
                    const latlng = L.latLng(lat, lng);
                    if (!latlng || latlng.lat === undefined || latlng.lng === undefined) {
                        console.warn(`[geo-map-lit] Feature ${index} created invalid LatLng`);
                        invalidCount++;
                        return;
                    }

                    const color = p.type_color || '#0066cc';
                    const marker = L.marker(latlng, {
                        icon: createGeoMapLeafletIcon(L, color),
                        typeValue: p.type,
                        typeColor: color,
                    });

                    // Initial popup
                    marker.bindPopup(`
                        <div class="geo-popup">
                            <strong class="geo-popup-title">${p.title || ''}</strong>
                            <span class="geo-popup-badge" style="background:${color}">${p.type_label || ''}</span>
                            <br><small class="text-muted">${p.address || ''}</small>
                        </div>
                    `, { maxWidth: 260 });

                    // AJAX on click
                    if (p.id) {
                        marker.once('click', () => {
                            fetch(`/api/ticket-details/${p.id}`)
                                .then(res => res.ok ? res.json() : null)
                                .then(detail => {
                                    if (!detail) return;
                                    marker.getPopup().setContent(`
                                        <div class="geo-popup">
                                            <strong class="geo-popup-title">${detail.title || p.title || ''}</strong>
                                            <span class="geo-popup-badge" style="background:${color}">${p.type_label || ''}</span>
                                            <p class="geo-popup-description">${detail.description || ''}</p>
                                        </div>
                                    `);
                                })
                                .catch(() => {});
                        });
                    }

                    this._allMarkers.push(marker);
                    validCount++;
                } catch (e) {
                    console.error(`[geo-map-lit] Error creating marker for feature ${index}:`, e);
                    invalidCount++;
                }
            });

            console.log(`[geo-map-lit] Valid markers: ${validCount}, Invalid: ${invalidCount}`);

            if (this._markersLayer && this._allMarkers.length > 0) {
                // Add one by one to identify bad markers
                this._allMarkers.forEach((marker, idx) => {
                    try {
                        this._markersLayer.addLayer(marker);
                    } catch (e) {
                        console.error(`[geo-map-lit] Error adding marker ${idx} to cluster:`, e);
                    }
                });
                console.log(`[geo-map-lit] Added ${this._allMarkers.length} markers to cluster group`);
            }

            if (this._allMarkers.length === 0) {
                this._mapStatus = 'empty';
                this._mapStatusMessage = 'Nessuna segnalazione valida trovata.';
            } else {
                this._mapStatus = 'ready';
                try {
                    const bounds = L.featureGroup(this._allMarkers).getBounds();
                    if (bounds.isValid()) {
                        this._map.fitBounds(bounds, { padding: [40, 40], maxZoom: 11 });
                    }
                } catch (e) {
                    console.warn('[geo-map-lit] fitBounds failed:', e.message);
                }
            }
        } catch (err) {
            this._mapStatus = 'error';
            this._mapStatusMessage = 'Errore nel caricamento della mappa.';
            console.error('[geo-map-lit] Error loading GeoJSON:', err);
        }
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

if (!customElements.get('geo-map-lit')) {
    customElements.define('geo-map-lit', GeoMapLit);
}
