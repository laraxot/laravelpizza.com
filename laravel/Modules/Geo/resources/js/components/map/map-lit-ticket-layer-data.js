// Geo — frontend asset (claude-audit doc ratio).
/**
 * Geo map-lit ticket layer — data load, filter, marker render.
 * Mixed into map-lit custom element prototype.
 */
import L from 'leaflet';
import { resolveFeatureTicketType } from './feature-type.js';
import { resolveFeatureTicketStatus } from './feature-status.js';
import { bindFeaturePopup } from './feature-popup-bind.js';
import { createGeoMapLeafletIcon } from './config.js';

/** Default public GeoJSON endpoint for ticket markers. */
const DEFAULT_TICKETS_JSON_URL = '/data/tickets.json';

export const mapLitTicketLayerDataMethods = {
    /** Fetch GeoJSON tickets and render markers on the map layer. */
    _loadGeoJson() {
        const url = this.dataUrl || DEFAULT_TICKETS_JSON_URL;
        fetch(url)
            .then((res) => res.json())
            .then((data) => {
                if (!data || !Array.isArray(data.features)) {
                    return;
                }

                const validFeatures = data.features.filter(
                    (f) =>
                        f.geometry &&
                        Array.isArray(f.geometry.coordinates) &&
                        f.geometry.coordinates.length >= 2 &&
                        !Number.isNaN(parseFloat(f.geometry.coordinates[0])) &&
                        !Number.isNaN(parseFloat(f.geometry.coordinates[1])),
                );

                const detailFeatures = this._filterFeaturesForDetailMode(validFeatures);
                this._allFeatures = detailFeatures;
                if (!this.detailMode) {
                    this._syncMapLegend(detailFeatures);
                }

                const featuresToShow = this._resolveFilteredFeatures();
                this._renderMarkersFromFeatures(featuresToShow);

                this._mapReady = true;

                if (!this._initialFitDone) {
                    this._initialFitDone = true;
                    setTimeout(
                        () => this.refreshWhenVisible(() => this._applyInitialMapCenter(featuresToShow)),
                        350,
                    );
                } else {
                    this.refreshWhenVisible();
                }

                this.dispatchEvent(
                    new CustomEvent('geo-map-loaded', {
                        detail: {
                            count: this._allFeatures.length,
                            types: [
                                ...new Set(
                                    this._allFeatures
                                        .map((f) => resolveFeatureTicketType(f.properties || {}).value)
                                        .filter(Boolean),
                                ),
                            ],
                        },
                        bubbles: true,
                        composed: true,
                    }),
                );
            })
            .catch((err) => console.error('[map-lit] Error loading GeoJSON from', url, err));
    },

    /** Filter visible markers by a single ticket type value. */
    filterByType(type) {
        if (Array.isArray(type)) {
            this.filterByTypes(type);
            return;
        }
        this.filterByTypes(type ? [type] : null);
    },

    /** Resolve features matching active type and status filters. */
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
    },

    /** Remove all markers from the Leaflet cluster/layer group. */
    _clearMarkersLayer() {
        if (!this._markersLayer) {
            return;
        }

        if (typeof this._markersLayer.clearLayers === 'function') {
            this._markersLayer.clearLayers();
        }

        this._geojsonLayer = null;
    },

    /** Build Leaflet markers from GeoJSON point features and add to layer. */
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
            const marker = this._buildMarkerFromFeature(feature);
            if (marker) {
                newMarkers.push(marker);
            }
        });

        this._allMarkers = newMarkers;
        if (typeof this._markersLayer.addLayers === 'function') {
            this._markersLayer.addLayers(newMarkers);
        } else {
            newMarkers.forEach((m) => this._markersLayer.addLayer(m));
        }
    },

    /** Create a single Leaflet marker from one GeoJSON feature. */
    _buildMarkerFromFeature(feature) {
        const coords = feature.geometry?.coordinates;
        if (!Array.isArray(coords) || coords.length < 2) {
            return null;
        }

        const lng = Number.parseFloat(String(coords[0]));
        const lat = Number.parseFloat(String(coords[1]));
        if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
            return null;
        }

        const latlng = L.latLng(lat, lng);
        const p = feature.properties || {};
        const ticketType = resolveFeatureTicketType(p);
        const ticketStatus = resolveFeatureTicketStatus(p);
        const markerAccessibleLabel = [
            String(p.title || p.name || ticketType.label || '').trim(),
            String(ticketStatus.label || '').trim(),
        ]
            .filter(Boolean)
            .join(' — ');

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
            bindFeaturePopup(this, feature, marker);
        }

        return marker;
    },
};
