export class GeoMapLayerManager {
    constructor(renderer, adapter) {
        this.renderer = renderer;
        this.adapter = adapter;
        this.layers = new Map();
    }

    build(onFeatureSelected, filters) {
        const filteredPoints = this.adapter.getFilteredPointFeatures(filters);
        const zones = this.adapter.getZoneFeatures();

        this.layers.set('cluster', this.renderer.createClusterLayer(filteredPoints, onFeatureSelected));
        this.layers.set('points', this.renderer.createPointsLayer(filteredPoints, onFeatureSelected));
        this.layers.set('heatmap', this.renderer.createHeatLayer(this.adapter.getHeatPoints(filteredPoints)));
        this.layers.set('zones', this.renderer.createZonesLayer(zones, onFeatureSelected));
    }

    sync(activeLayers) {
        this.layers.forEach((layer, key) => {
            const shouldBeActive = activeLayers.includes(key);
            const hasLayer = this.renderer.map.hasLayer(layer);

            if (shouldBeActive && !hasLayer) {
                layer.addTo(this.renderer.map);
            }

            if (!shouldBeActive && hasLayer) {
                this.renderer.map.removeLayer(layer);
            }
        });
    }

    rebuild(onFeatureSelected, filters, activeLayers) {
        this.layers.forEach((layer) => {
            if (this.renderer.map.hasLayer(layer)) {
                this.renderer.map.removeLayer(layer);
            }
        });
        this.layers.clear();
        this.build(onFeatureSelected, filters);
        this.sync(activeLayers);
    }
}
