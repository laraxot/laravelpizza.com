import { LitElement, html } from 'lit';
import L from 'leaflet';
window.L = L;
globalThis.L = L;

// Import markercluster - Vite may wrap in CommonJS, ensure registration
import 'leaflet.markercluster/dist/leaflet.markercluster.js';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
// Direct UMD registration for Vite
const mcg = (function() {
    // Handle both UMD registration and Vite CommonJS wrapper
    const candidates = [
        (window.L && window.L.MarkerClusterGroup),
        (window.L && window.L.markerClusterGroup && window.L.markerClusterGroup.prototype && window.L.MarkerClusterGroup),
        L.MarkerClusterGroup,
    ];
    for (const c of candidates) {
        if (typeof c === 'function') return c;
    }
    return null;
})();
if (mcg && !L.markerClusterGroup) {
    L.markerClusterGroup = (opts) => new mcg(opts);
}

import { renderControls, toggleFullscreen, switchLayer, zoomIn, zoomOut, requestGeolocation } from './map/controls.js';
import { renderSearch, searchUiHandlers } from './map/controls/search.js';
import { buildMapLayers } from './map/layers.js';
import { mapStylesText } from './map/styles.js';
import { createGeoMapLeafletIcon, markerCardStylesText } from './map/config.js';
import { buildClusterTypeTileHtml } from './map/icon-glyph.js';
import { resolveFeatureTicketType } from './map/feature-type.js';
import { resolveFeatureTicketStatus } from './map/feature-status.js';
import {
    collectLegendStatusesFromFeatures,
    mountMapLegend,
    refreshMapLegend,
} from './map/legend.js';
import {
    buildTicketPopupHtml,
    buildTicketPopupLoadingHtml,
    popupTicketStylesText,
} from './map/popup-ticket.js';

const DEFAULT_TICKETS_JSON_URL = '/data/tickets.json';
const DEFAULT_CENTER = [41.9028, 12.4964];
const DEFAULT_ZOOM = 6;
const DEFAULT_MAP_HEIGHT = 'clamp(360px, 58vh, 560px)';

function resolveMapHeight(rawHeight) {
    const value = String(rawHeight || '').trim();
    if (value === '' || value === '100%' || value === 'auto') {
        return DEFAULT_MAP_HEIGHT;
    }

    return value;
}

/** @param {string|null|undefined} raw */
function parseOptionalCoord(raw) {
    if (raw === null || raw === undefined || String(raw).trim() === '') {
        return null;
    }

    const n = Number.parseFloat(String(raw));
    return Number.isFinite(n) ? n : null;
}

/**
 * map-lit.js
 * 1:1 Conversion of direktvermarkter.js (farmshops.eu)
 * Implements LOD clustering, AJAX popups, and auto-geolocation.
 */
class MapLit extends LitElement {
    static properties = {
        filterType: { type: String },
        activeLayer: { type: String },
        isFullscreen: { type: Boolean, state: true },
        height: { type: String },
        _searchOpen: { type: Boolean, state: true },
        labels: { type: Object },
        dataUrl: { type: String, attribute: 'data-url' },
        lat: { type: Number, attribute: 'lat' },
        lng: { type: Number, attribute: 'lng' },
        detailMode: { type: Boolean, attribute: 'detail-mode' },
        ticketId: { type: Number, attribute: 'ticket-id' },
        // State for shared modules (renderSearch/renderControls)
        searchQuery: { type: String, state: true },
        searchResults: { type: Array, state: true },
        showSearchResults: { type: Boolean, state: true },
        isSearching: { type: Boolean, state: true },
        isLocating: { type: Boolean, state: true },
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
        this._geolocRequested = false;
        this.labels = {
            fullscreen: 'Schermo intero',
            close_fullscreen: 'Esci da schermo intero',
            use_location: 'Usa la mia posizione',
            switch_layer: 'Cambia layer',
            zoom_in: 'Aumenta zoom',
            zoom_out: 'Diminuisci zoom',
            search: 'Cerca',
            search_placeholder: 'Cerca indirizzo...',
            legend_title: 'Stati segnalazione',
        };
        this.height = DEFAULT_MAP_HEIGHT;
        this.dataUrl = DEFAULT_TICKETS_JSON_URL;
        this.lat = null;
        this.lng = null;
        this.detailMode = false;
        this.ticketId = null;
        this._currentLayer = 'street';
        this._allFeatures = [];
        this._allMarkers = [];
        this._layers = {};
        this._isUserCentered = false;
        this._initialFitDone = false;
        this._activeTypeFilter = null;
        this._activeStatusFilter = null;
        this._geojsonLayer = null;
        this._invalidateSizeTimer = null;
        this._filterRenderTimer = null;
        this._mapReady = false;
        this._mutationDebounceTimer = null;
        this._legendControl = null;
    }

    render() {
        return html`
            <style>
                ${mapStylesText}
                map-lit { display: block; width: 100%; min-height: 320px; }
                .geo-map-leaflet { width: 100%; height: 100%; min-height: 320px; }
                ${markerCardStylesText}
                .leaflet-div-icon { background: transparent !important; border: none !important; }
                ${popupTicketStylesText}

                html.geo-map-fullscreen-active, html.geo-map-fullscreen-active body { overflow: hidden !important; }
            </style>
            <div class="map-container ${this.isFullscreen ? 'is-fullscreen' : ''}"
                 style="position:relative;--map-height:${resolveMapHeight(this.height)};">
                <div class="geo-map-leaflet" style="width:100%;height:100%;"></div>
                ${this.detailMode ? '' : renderControls(this)}
                ${!this.detailMode && this._searchOpen ? renderSearch(this, searchUiHandlers) : ''}
            </div>
        `;
    }

    _toggleFullscreen() { void toggleFullscreen(this); }
    _switchLayer() { switchLayer(this); }
    _zoomIn() { zoomIn(this); }
    _zoomOut() { zoomOut(this); }
    _requestGeolocation() { requestGeolocation(this, { showLoading: true }); }

    connectedCallback() {
        super.connectedCallback();
        this.dataUrl = this.getAttribute('data-url') || this.dataUrl || DEFAULT_TICKETS_JSON_URL;
        this.lat = parseOptionalCoord(this.getAttribute('lat'));
        this.lng = parseOptionalCoord(this.getAttribute('lng'));
        this.detailMode = this.hasAttribute('detail-mode');
        this.ticketId = parseOptionalCoord(this.getAttribute('ticket-id'));
    }

    _hasExplicitCenter() {
        return Number.isFinite(this.lat) && Number.isFinite(this.lng);
    }

    async firstUpdated() {
        super.firstUpdated();
        await this.updateComplete;

        this._onFiltersChanged = (event) => {
            const detail = event.detail ?? {};
            if (Array.isArray(detail.types)) {
                this._activeTypeFilter = detail.types.length > 0 ? detail.types : null;
            }
            if (Array.isArray(detail.statuses)) {
                this._activeStatusFilter = detail.statuses.length > 0 ? detail.statuses : null;
            }
            this._applyFeatureFilters();
        };
        this.addEventListener('filters-changed', this._onFiltersChanged);

        try {
            await this._initMap();
        } catch (error) {
            console.error('[map-lit] Map init failed:', error);
        }
    }

    async _initMap() {
        const container = this.renderRoot.querySelector('.geo-map-leaflet');
        if (!container) {
            console.warn('[map-lit] .geo-map-leaflet container missing');
            return;
        }

        if (!document.getElementById('popup-styles')) {
            const styleEl = document.createElement('style');
            styleEl.id = 'popup-styles';
            styleEl.textContent = popupTicketStylesText;
            document.head.appendChild(styleEl);
        }

        await this._ensureLeafletPlugins();

        this._map = L.map(container, {
            center: DEFAULT_CENTER,
            zoom: DEFAULT_ZOOM,
            minZoom: this.detailMode ? 14 : 3,
            maxZoom: this.detailMode ? 18 : 19,
            zoomControl: false,
            zoomAnimation: false,
            dragging: !this.detailMode,
            scrollWheelZoom: !this.detailMode,
            doubleClickZoom: !this.detailMode,
            touchZoom: !this.detailMode,
        });

        this._layers = buildMapLayers(L);
        this._layers[this._currentLayer].addTo(this._map);

        // A5: scala metrica (km/m) in basso a sinistra, niente miglia
        L.control.scale({ imperial: false }).addTo(this._map);

        // Reference: direktvermarkter.js custom cluster group
        const clusterFactory = L.markerClusterGroup || (window.L && window.L.markerClusterGroup);
        console.log('[map-lit] clusterFactory available:', typeof clusterFactory === 'function', L.MarkerClusterGroup);
        
        if (typeof clusterFactory === 'function') {
            this._markersLayer = clusterFactory({
                maxClusterRadius: (z) => (z < 12 ? 80 : 45),
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                chunkedLoading: true,
                // false: i marker restano nel layer al pan/zoom e riappaiono tornando in vista (STORY-124)
                removeOutsideVisibleBounds: false,
                animate: false,
                animateAddingMarkers: false,
                iconCreateFunction: (cluster) => this._createClusterIcon(cluster),
            });
            this._map.addLayer(this._markersLayer);
        } else {
            this._markersLayer = L.layerGroup().addTo(this._map);
        }

        this._map.on('popupopen', (e) => {
            const container = this._map.getContainer();
            const mapW = container.clientWidth;
            const mapH = container.clientHeight;
            // farmshops.eu: maxHeight 0.65 × mappa (A4), maxWidth 0.95 × mappa
            e.popup.options.maxWidth = Math.floor(mapW * 0.95);
            e.popup.options.maxHeight = Math.floor(mapH * 0.65);
            e.popup.update();
            this._wirePopupActions(e.popup);
        });

        // farmshops.eu: LOD cluster (conteggio vs icone tipo) si aggiorna al cambio zoom
        this._map.on('zoomend', () => {
            if (typeof this._markersLayer?.refreshClusters === 'function') {
                this._markersLayer.refreshClusters();
            }
        });

        this._setupMutationObserver();
        this._setupVisibilityObserver();
        this._syncMapLegend([]);

        this._loadGeoJson();
    }

    async _ensureLeafletPlugins() {
        window.L = L;
        globalThis.L = L;

        // Wait for markercluster registration (Vite CommonJS wrapper)
        await this._waitForMarkerCluster();

        await import('leaflet.heat')
            .catch((error) => console.warn('[map-lit] Heat plugin unavailable:', error.message));
    }

    async _waitForMarkerCluster() {
        const maxWait = 50; // 50 * 50ms = 2.5s max
        for (let i = 0; i < maxWait; i++) {
            if (L.markerClusterGroup || (L.MarkerClusterGroup && !L.markerClusterGroup)) {
                // Ensure markerClusterGroup factory is available (UMD polyfill)
                if (!L.markerClusterGroup && L.MarkerClusterGroup) {
                    L.markerClusterGroup = (opts) => new L.MarkerClusterGroup(opts);
                }
                if (L.markerClusterGroup) {
                    console.log('[map-lit] markerCluster ready after', i * 50, 'ms');
                    return;
                }
            }
            await new Promise(r => setTimeout(r, 50));
        }
        console.warn('[map-lit] markerCluster not available after', maxWait * 50, 'ms');
    }

    _setupMutationObserver() {
        this._mutationObserver = new MutationObserver(() => {
            if (this.offsetParent === null || !this._map) {
                return;
            }
            if (this._mutationDebounceTimer) {
                clearTimeout(this._mutationDebounceTimer);
            }
            this._mutationDebounceTimer = setTimeout(() => {
                this._mutationDebounceTimer = null;
                this.refreshWhenVisible();
            }, 200);
        });
        let parent = this.parentElement;
        for (let i = 0; i < 12 && parent; i++) {
            this._mutationObserver.observe(parent, { attributes: true, attributeFilter: ['class', 'style', 'hidden'] });
            parent = parent.parentElement;
        }

        document.addEventListener('shown.bs.tab', (e) => {
            if (!this._map) return;
            const target = String(e.target?.getAttribute?.('data-bs-target') || e.target?.getAttribute?.('href') || '');
            const isMapTab = target.includes('map') || target.includes('mappa') || target.includes('tab-mappa');
            if (isMapTab || this.offsetParent !== null) {
                setTimeout(() => {
                    this._map.invalidateSize({ pan: false, animate: false });
                    if (this._allFeatures?.length && this._initialFitDone) {
                        const features = this._resolveFilteredFeatures();
                        if (features.length) this._fitBoundsToMarkers(features);
                    }
                }, 80);
            }
        });
    }

    /**
     * Quando la mappa entra nel viewport: solo invalidateSize (no fitBounds — conflitto con GPS).
     */
    _setupVisibilityObserver() {
        if (typeof IntersectionObserver === 'undefined') {
            return;
        }

        this._visibilityObserver?.disconnect();
        this._visibilityObserver = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    if (!entry.isIntersecting || entry.intersectionRatio <= 0) {
                        continue;
                    }

                    this.refreshWhenVisible();
                }
            },
            { root: null, threshold: [0, 0.12, 0.35] },
        );
        this._visibilityObserver.observe(this);
    }

    /**
     * LOD Cluster Icon (1:1 from direktvermarkter.js)
     */
    _createClusterIcon(cluster) {
        const markers = cluster.getAllChildMarkers();
        const count = markers.length;
        const zoom = this._map ? this._map.getZoom() : 0;
        const clusterAnchor = L.point(40, 40);
        const clusterSize = L.point(80, 80);

        if (zoom >= 8) {
            const typeByValue = new Map();
            markers.forEach((m) => {
                const value = m.options.typeValue;
                if (!value || typeByValue.has(value)) {
                    return;
                }
                typeByValue.set(value, {
                    iconUrl: m.options.typeIconUrl,
                    label: m.options.typeLabel,
                });
            });
            const icons = [...typeByValue.values()]
                .slice(0, 4)
                .map((t) => buildClusterTypeTileHtml(t.iconUrl, t.label, 16))
                .join('');

            return L.divIcon({
                html: `<div class="geo-cluster-circle"><strong>${count}</strong><div class="geo-cluster-type-icons">${icons}</div></div>`,
                className: 'geo-cluster-wrapper',
                iconSize: clusterSize,
                iconAnchor: clusterAnchor,
            });
        }

        return L.divIcon({
            html: `<div class="geo-cluster-circle"><strong>${count}</strong></div>`,
            className: 'geo-cluster-wrapper',
            iconSize: clusterSize,
            iconAnchor: clusterAnchor,
        });
    }

    _filterFeaturesForDetailMode(features) {
        if (!this.detailMode || !Number.isFinite(this.ticketId)) {
            return features;
        }

        const id = String(this.ticketId);
        return features.filter((f) => String((f.properties || {}).id ?? '') === id);
    }

    _loadGeoJson() {
        // Use Lit property dataUrl (mapped from data-url attribute)
        const url = this.dataUrl || DEFAULT_TICKETS_JSON_URL;
        console.log('[map-lit] Loading GeoJSON from:', url);
        fetch(url)
            .then(res => res.json())
            .then(data => {
                console.log('[map-lit] GeoJSON loaded:', data?.features?.length || 0, 'features');
                if (!data || !Array.isArray(data.features)) {
                    console.error('[map-lit] Invalid GeoJSON:', data);
                    return;
                }

                // STRICT VALIDATION: prevents "TypeError: lat"
                const validFeatures = data.features.filter(f =>
                    f.geometry &&
                    Array.isArray(f.geometry.coordinates) &&
                    f.geometry.coordinates.length >= 2 &&
                    !isNaN(parseFloat(f.geometry.coordinates[0])) &&
                    !isNaN(parseFloat(f.geometry.coordinates[1]))
                );

                const detailFeatures = this._filterFeaturesForDetailMode(validFeatures);
                this._allFeatures = detailFeatures;
                console.log('[map-lit] Valid features:', detailFeatures.length);

                if (!this.detailMode) {
                    this._syncMapLegend(detailFeatures);
                }

                const featuresToShow = this._resolveFilteredFeatures();
                this._renderMarkersFromFeatures(featuresToShow);

                this._mapReady = true;

                if (!this._initialFitDone) {
                    this._initialFitDone = true;
                    setTimeout(() => this.refreshWhenVisible(() => {
                        // Pattern implicito: assenza lat/lng -> GPS (come <input type="date"> senza value)
                        if (!this._hasExplicitCenter() && navigator.geolocation) {
                            this._tryCenterOnGpsThenMarkers(featuresToShow);
                        } else if (this._hasExplicitCenter()) {
                            const zoom = this.detailMode ? 16 : 14;
                            this._map.setView([this.lat, this.lng], zoom, { animate: false });
                        } else {
                            this._fitBoundsToMarkers(featuresToShow);
                        }
                    }), 350);
                } else {
                    this.refreshWhenVisible();
                }

                this.dispatchEvent(new CustomEvent('geo-map-loaded', {
                    detail: {
                        count: this._allFeatures.length,
                        types: [...new Set(this._allFeatures.map(f => resolveFeatureTicketType(f.properties || {}).value).filter(Boolean))],
                    },
                    bubbles: true,
                    composed: true,
                }));
            })
            .catch(err => console.error('[map-lit] Error loading GeoJSON from', url, err));
    }

    filterByType(type) {
        if (Array.isArray(type)) {
            this.filterByTypes(type);
            return;
        }
        this.filterByTypes(type ? [type] : null);
    }

    _resolveFilteredFeatures(types = this._activeTypeFilter, statuses = this._activeStatusFilter) {
        const typeList = Array.isArray(types)
            ? types.filter((t) => typeof t === 'string' && t.length > 0)
            : [];
        const statusList = Array.isArray(statuses)
            ? statuses.filter((s) => typeof s === 'string' && s.length > 0)
            : [];

        const typeSet = typeList.length > 0 ? new Set(typeList) : null;
        const statusSet = statusList.length > 0 ? new Set(statusList) : null;

        if (typeSet === null && statusSet === null) {
            return this._allFeatures;
        }

        return this._allFeatures.filter((feature) => {
            const props = feature.properties || {};
            if (typeSet !== null) {
                const ticketType = resolveFeatureTicketType(props);
                if (!typeSet.has(ticketType.value)) {
                    return false;
                }
            }
            if (statusSet !== null) {
                const ticketStatus = resolveFeatureTicketStatus(props);
                if (!statusSet.has(ticketStatus.value)) {
                    return false;
                }
            }

            return true;
        });
    }

    _clearMarkersLayer() {
        if (!this._markersLayer) {
            return;
        }

        if (typeof this._markersLayer.clearLayers === 'function') {
            this._markersLayer.clearLayers();
        }

        this._geojsonLayer = null;
    }

    _renderMarkersFromFeatures(features) {
        if (!this._markersLayer || !Array.isArray(features)) {
            return;
        }

        this._allMarkers = [];
        this._clearMarkersLayer();

        if (features.length === 0) {
            return;
        }

        const newMarkers = [];
        features.forEach((feature) => {
            const coords = feature.geometry?.coordinates;
            if (!Array.isArray(coords) || coords.length < 2) {
                return;
            }

            const lng = Number.parseFloat(String(coords[0]));
            const lat = Number.parseFloat(String(coords[1]));
            if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                return;
            }

            const latlng = L.latLng(lat, lng);
            const p = feature.properties || {};
            const ticketType = resolveFeatureTicketType(p);
            const ticketStatus = resolveFeatureTicketStatus(p);
            const markerAccessibleLabel = [
                String(p.title || p.name || ticketType.label || "").trim(),
                String(ticketStatus.label || "").trim(),
            ].filter(Boolean).join(" — ");

            const marker = L.marker(latlng, {
                icon: createGeoMapLeafletIcon(L, ticketStatus.color, ticketType.iconUrl, ticketType.label),
                title: markerAccessibleLabel,
                alt: markerAccessibleLabel,
                keyboard: true,
                typeValue: ticketType.value,
                typeLabel: ticketType.label,
                typeIconUrl: ticketType.iconUrl,
                statusValue: ticketStatus.value,
                statusColor: ticketStatus.color,
                statusLabel: ticketStatus.label,
            });

            marker.feature = feature;
            if (!this.detailMode) {
                this._bindFeaturePopup(feature, marker);
            }
            newMarkers.push(marker);
        });

        this._allMarkers = newMarkers;
        if (typeof this._markersLayer.addLayers === 'function') {
            this._markersLayer.addLayers(newMarkers);
        } else {
            newMarkers.forEach((m) => this._markersLayer.addLayer(m));
        }

        console.log('[map-lit] Rendered', this._allMarkers.length, 'markers to cluster layer');
    }

    _openTicketModal(properties, ticketType, detail = null) {
        const modalEl = document.getElementById('modal-disservizio');
        if (!modalEl) {
            console.warn('[map-lit] Modal #modal-disservizio not found in DOM');
            return;
        }

        const title = detail?.title || properties.title || properties.name || '';
        const typeLabel = ticketType.label || '';
        const address = String(properties.address || '').trim();
        const city = String(properties.city || '').trim();
        const fullAddress = address && city && !address.toLowerCase().includes(city.toLowerCase())
            ? `${address} - ${city}`
            : (address || city || '—');
        const description = detail?.description || properties.description || properties.content || '';

        const setText = (selector, text) => {
            const el = modalEl.querySelector(selector);
            if (el) el.textContent = text || '—';
        };

        const modalTitleEl = modalEl.querySelector('#modal2Title');
        if (modalTitleEl) {
            modalTitleEl.textContent = title || '—';
        }
        setText('[data-element="modal-ticket-title"]', title);
        setText('[data-element="modal-ticket-type"]', typeLabel);
        setText('[data-element="modal-ticket-address"]', fullAddress);
        setText('[data-element="modal-ticket-detail"]', description);

        // Immagine
        const images = Array.isArray(detail?.images)
            ? detail.images
            : Array.isArray(properties.images)
                ? properties.images
                : [];
        const imgEl = modalEl.querySelector('.modal-body img');
        if (imgEl) {
            imgEl.src = images[0] || '/themes/Sixteen/design-comuni/assets/images/img-disservizio-thumbnail.png';
        }

        // Apertura modal via Bootstrap API
        try {
            const ModalCtor = window.bootstrap?.Modal;
            if (ModalCtor) {
                const bsModal = new ModalCtor(modalEl);
                bsModal.show();
            } else {
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                modalEl.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
                if (!document.querySelector('.modal-backdrop.fade.show')) {
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
            }
        } catch (e) {
            console.error('[map-lit] Failed to open #modal-disservizio:', e);
        }
    }

    _wirePopupActions(popup) {
        const container = popup?.getElement?.();
        if (!container) {
            return;
        }

        const closeBtn = container.querySelector('[data-popup-close]');
        if (closeBtn && !closeBtn.dataset.geoWired) {
            closeBtn.dataset.geoWired = '1';
            closeBtn.addEventListener('click', (ev) => {
                ev.preventDefault();
                this._map?.closePopup();
            });
        }

        const detailBtn = container.querySelector('[data-popup-open-detail]');
        if (detailBtn && !detailBtn.dataset.geoWired) {
            detailBtn.dataset.geoWired = '1';
            detailBtn.addEventListener('click', (ev) => {
                ev.preventDefault();
                const props = popup._geoFeatureProps;
                const type = popup._geoTicketType;
                const status = popup._geoTicketStatus;
                const detail = popup._geoTicketDetail;
                if (props && type) {
                    this._openTicketModal(props, type, detail);
                }
                this._map?.closePopup();
            });
        }
    }

    _ensureFeaturePopup(layer) {
        let popup = layer.getPopup?.();
        if (!popup) {
            popup = L.popup({
                className: 'popup-wrapper',
                maxWidth: 420,
                minWidth: 300,
                autoPanPaddingTopLeft: L.point(72, 16),
            });
            layer.bindPopup(popup);
        }

        return popup;
    }

    _openFeaturePopupLoading(layer, ticketType, ticketStatus) {
        const popup = this._ensureFeaturePopup(layer);
        popup.setContent(buildTicketPopupLoadingHtml(ticketType, ticketStatus));
        popup._geoFeatureProps = null;
        popup._geoTicketType = ticketType;
        popup._geoTicketStatus = ticketStatus;
        popup._geoTicketDetail = null;
        layer.openPopup();
    }

    _openFeaturePopup(layer, properties, ticketType, ticketStatus, detail = null, coords = {}) {
        const html = buildTicketPopupHtml(properties, ticketType, ticketStatus, detail, coords);
        const popup = this._ensureFeaturePopup(layer);

        popup.setContent(html);
        popup._geoFeatureProps = properties;
        popup._geoTicketType = ticketType;
        popup._geoTicketStatus = ticketStatus;
        popup._geoTicketDetail = detail;

        layer.openPopup();
        this._wirePopupActions(popup);
    }

    _bindFeaturePopup(feature, layer) {
        const p = feature.properties || {};
        const ticketType = resolveFeatureTicketType(p);
        const ticketStatus = resolveFeatureTicketStatus(p);
        const coordsRaw = feature.geometry?.coordinates;
        const lng = Number(coordsRaw?.[0]);
        const lat = Number(coordsRaw?.[1]);
        const coords = { lat, lng };

        // A1: autoPanPaddingTopLeft evita che il popup finisca sotto header/zoom
        // A3: pre-bind con skeleton (no popup vuoto al primo click)
        layer.bindPopup(buildTicketPopupLoadingHtml(ticketType, ticketStatus), {
            className: 'popup-wrapper',
            maxWidth: 380,
            minWidth: 300,
            autoPanPaddingTopLeft: L.point(72, 16),
        });

        layer.on('click', (event) => {
            if (event?.originalEvent) {
                L.DomEvent.stopPropagation(event);
            }

            const popup = this._ensureFeaturePopup(layer);

            const showPopup = (detail) => {
                if (detail) {
                    layer._geoDetailCache = detail;
                }
                const html = buildTicketPopupHtml(p, ticketType, ticketStatus, detail, coords);
                popup.setContent(html);
                popup._geoFeatureProps = p;
                popup._geoTicketType = ticketType;
                popup._geoTicketStatus = ticketStatus;
                popup._geoTicketDetail = detail;
                popup.update();
                this._wirePopupActions(popup);
            };

            if (layer._geoDetailCache) {
                showPopup(layer._geoDetailCache);
                return;
            }

            if (p.id) {
                // Reset skeleton prima del fetch (re-click dopo close senza cache)
                popup.setContent(buildTicketPopupLoadingHtml(ticketType, ticketStatus));
                popup._geoFeatureProps = null;
                popup.update();
                fetch(`/api/ticket-details/${p.id}`)
                    .then((res) => (res.ok ? res.json() : null))
                    .then((detail) => showPopup(detail))
                    .catch(() => showPopup(null));
            } else {
                showPopup(null);
            }
        });
    }



    _fitBoundsToMarkers(features, extendWith = null) {
        if (!this._map || !this._markersLayer || !features?.length) {
            return;
        }

        try {
            this._map.invalidateSize({ pan: false, animate: false });

            // Fix mapPane width:0/height:0 bug — Leaflet does not resize mapPane
            // when container is laid out after initialization (e.g. in tabs)
            const mapPane = this._map.getPanes?.()?.mapPane;
            const cont = this._map.getContainer?.();
            if (mapPane && cont && mapPane.offsetWidth === 0 && cont.offsetWidth > 0) {
                mapPane.style.width = cont.offsetWidth + 'px';
                mapPane.style.height = cont.offsetHeight + 'px';
                this._map.invalidateSize({ pan: false, animate: false });
                console.log('[map-lit] mapPane size forced:', cont.offsetWidth, 'x', cont.offsetHeight);
            }

            // Fix _pixelOrigin null — force recalculation
            if (!this._map._pixelOrigin) {
                this._map._resetView(this._map.getCenter(), this._map.getZoom(), true);
            }

            const bounds = this._markersLayer.getBounds?.();
            const fgBounds = !bounds?.isValid?.() ? this._markersLayer._featureGroup?.getBounds?.() : null;
            let validBounds = bounds?.isValid?.() ? bounds : (fgBounds?.isValid?.() ? fgBounds : null);

            if (extendWith && Number.isFinite(extendWith.lat) && Number.isFinite(extendWith.lng)) {
                const userPoint = L.latLng(extendWith.lat, extendWith.lng);
                validBounds = validBounds ? validBounds.extend(userPoint) : L.latLngBounds(userPoint, userPoint);
            }

            if (!validBounds?.isValid?.()) {
                console.warn('[map-lit] fitBounds: bounds not valid');
                return;
            }

            const maxZoom = features.length <= 3 ? 14 : features.length <= 15 ? 13 : features.length <= 40 ? 12 : 11;
            this._map.fitBounds(validBounds, { padding: [40, 40], maxZoom, animate: false });
            console.log('[map-lit] fitBounds OK zoom:', this._map.getZoom(), 'n:', features.length);
        } catch (e) {
            console.warn('[map-lit] fitBounds skipped:', e.message);
        }
    }

    /**
     * Tenta centraggio su GPS; fallback ai bounds dei marker se negato o timeout.
     */
    _tryCenterOnGpsThenMarkers(features) {
        if (!navigator.geolocation) {
            this._fitBoundsToMarkers(features);
            return;
        }

        let settled = false;
        const finish = (fn) => {
            if (settled) {
                return;
            }
            settled = true;
            fn();
        };

        const timeoutId = setTimeout(() => {
            finish(() => this._fitBoundsToMarkers(features));
        }, 5000);

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                clearTimeout(timeoutId);
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                this._isUserCentered = true;
                this._geolocRequested = true;

                const userLatLng = L.latLng(lat, lng);

                finish(() => {
                    // Centra sulla posizione GPS (requisito /it); marker restano nel layer (removeOutsideVisibleBounds: false)
                    this._map.setView(userLatLng, 14, { animate: false });
                    // Se utente e segnalazioni sono vicine, adatta zoom per mostrare entrambi
                    const markerBounds = this._markersLayer?.getBounds?.();
                    if (markerBounds?.isValid?.() && markerBounds.contains(userLatLng)) {
                        this._fitBoundsToMarkers(features, userLatLng);
                    }
                });
            },
            () => {
                clearTimeout(timeoutId);
                finish(() => this._fitBoundsToMarkers(features));
            },
            { enableHighAccuracy: false, timeout: 5000, maximumAge: 60000 },
        );
    }

    /**
     * Dopo tab Mappa visibile o resize container — senza clearLayers.
     */
    refreshWhenVisible(afterResizeCallback = null) {
        if (!this._map || this.offsetParent === null) {
            return;
        }

        if (this._invalidateSizeTimer) {
            clearTimeout(this._invalidateSizeTimer);
        }

        this._invalidateSizeTimer = setTimeout(() => {
            this._invalidateSizeTimer = null;
            if (!this._map || this.offsetParent === null) {
                return;
            }

            this._map.invalidateSize({ pan: false });

            if (typeof afterResizeCallback === 'function') {
                afterResizeCallback();
            }

            // NO refreshClusters qui — invalidateSize + refreshClusters insieme fa sparire i marker (wiki SSoT)
        }, 80);
    }

    invalidateSize() {
        this.refreshWhenVisible();
    }

    _syncMapLegend(features) {
        // LEGEND REMOVED: Stati segnalazione già visualizzati nei filtri laterali (sidebar)
        // Questo metodo è disabilitato per evitare ridondanza con i filtri di sinistra nella versione desktop.
        // legend-mode="off" o "sidebar" nasconde la legenda; "status-collapsed" mostra una legenda collassata.
        const legendMode = this.getAttribute('legend-mode') || 'off';
        if (legendMode === 'off' || legendMode === 'sidebar') {
            if (this._legendControl) {
                this._map.removeControl(this._legendControl);
                this._legendControl = null;
            }
            return;
        }
        // Per altri valori (es. status-collapsed) potrebbe essere implementata una legenda collassata
    }

    filterByTypes(types) {
        this._activeTypeFilter = Array.isArray(types) && types.length > 0 ? types : null;
        this._applyFeatureFilters();
    }

    filterByStatuses(statuses) {
        this._activeStatusFilter = Array.isArray(statuses) && statuses.length > 0 ? statuses : null;
        this._applyFeatureFilters();
    }

    _applyFeatureFilters() {
        if (!this._markersLayer || this._allFeatures.length === 0) {
            return;
        }

        if (this._filterRenderTimer) {
            clearTimeout(this._filterRenderTimer);
        }

        this._filterRenderTimer = setTimeout(() => {
            this._filterRenderTimer = null;
            const features = this._resolveFilteredFeatures();
            this._syncMapLegend(features);
            this._renderMarkersFromFeatures(features);
        }, 80);
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this._onFiltersChanged) {
            this.removeEventListener('filters-changed', this._onFiltersChanged);
        }
        this._mutationObserver?.disconnect();
        this._visibilityObserver?.disconnect();
        this._legendControl = null;
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
