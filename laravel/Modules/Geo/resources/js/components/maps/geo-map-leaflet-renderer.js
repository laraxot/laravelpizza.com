import L from 'leaflet';
import 'leaflet.markercluster';
import 'leaflet.heat';

export class GeoMapLeafletRenderer {
    constructor(container, popupRenderer) {
        this.container = container;
        this.popupRenderer = popupRenderer;
        this.map = null;
        this.baseLayers = {};
        this.currentBaseLayer = 'street';
    }

    init(center, zoom) {
        if (this.map) {
            return this.map;
        }

        this.map = L.map(this.container, {
            center: [center.lat, center.lng],
            zoom,
            minZoom: 2,
            maxZoom: 18,
        });

        this.baseLayers.street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors',
        });

        this.baseLayers.satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri',
        });

        this.baseLayers.street.addTo(this.map);

        return this.map;
    }

    toggleBaseLayer() {
        const nextLayer = this.currentBaseLayer === 'street' ? 'satellite' : 'street';

        this.map.removeLayer(this.baseLayers[this.currentBaseLayer]);
        this.baseLayers[nextLayer].addTo(this.map);
        this.currentBaseLayer = nextLayer;
    }

    createPointMarker(feature) {
        const [lng, lat] = feature.geometry.coordinates;
        const category = String(feature.properties?.category ?? 'unknown');
        const initial = category.slice(0, 1).toUpperCase() || '?';
        const marker = L.marker([lat, lng], {
            icon: L.divIcon({
                className: 'geo-map-point-icon',
                html: `<span class="geo-map-point-icon__badge" data-category="${category}">${initial}</span>`,
                iconSize: [30, 30],
                iconAnchor: [15, 15],
            }),
        });

        marker.feature = feature;
        marker.bindPopup(this.popupRenderer.render(feature));

        return marker;
    }

    createClusterLayer(features, onFeatureSelected) {
        const clusterLayer = L.markerClusterGroup({
            maxClusterRadius: (zoom) => (zoom < 12 ? 80 : 45),
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: true,
            zoomToBoundsOnClick: true,
            iconCreateFunction: (cluster) => {
                const childMarkers = cluster.getAllChildMarkers();
                const categories = [...new Set(childMarkers.map((marker) => String(marker.feature?.properties?.category ?? 'unknown')))];
                const showCategories = this.map.getZoom() >= 8;

                return L.divIcon({
                    className: 'geo-map-cluster-icon',
                    html: `
                        <div class="geo-map-cluster-icon__inner">
                            <strong>${childMarkers.length}</strong>
                            ${showCategories ? `<small>${categories.join(', ')}</small>` : ''}
                        </div>
                    `,
                    iconSize: [70, 70],
                });
            },
        });

        features.forEach((feature) => {
            const marker = this.createPointMarker(feature);
            marker.on('click', () => onFeatureSelected(feature));
            clusterLayer.addLayer(marker);
        });

        return clusterLayer;
    }

    createPointsLayer(features, onFeatureSelected) {
        const layer = L.layerGroup();

        features.forEach((feature) => {
            const marker = this.createPointMarker(feature);
            marker.on('click', () => onFeatureSelected(feature));
            layer.addLayer(marker);
        });

        return layer;
    }

    createHeatLayer(points) {
        return L.heatLayer(points, {
            radius: 25,
            blur: 20,
            minOpacity: 0.25,
        });
    }

    createZonesLayer(features, onFeatureSelected) {
        return L.geoJSON(features, {
            style: {
                color: '#2563eb',
                weight: 2,
                opacity: 0.7,
                fillOpacity: 0.15,
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(this.popupRenderer.render(feature));
                layer.on('click', () => onFeatureSelected(feature));
            },
        });
    }

    invalidateSize() {
        if (!this.map) {
            return;
        }

        requestAnimationFrame(() => {
            this.map.invalidateSize();
        });
    }
}
