export class GeoMapGeoJsonAdapter {
    constructor(geoJson) {
        this.geoJson = geoJson ?? { type: 'FeatureCollection', features: [] };
    }

    getFeatures() {
        return Array.isArray(this.geoJson.features) ? this.geoJson.features : [];
    }

    getPointFeatures() {
        return this.getFeatures().filter((feature) => feature.geometry?.type === 'Point');
    }

    getZoneFeatures() {
        return this.getFeatures().filter((feature) => ['Polygon', 'MultiPolygon'].includes(feature.geometry?.type));
    }

    getFilteredPointFeatures(filters = {}) {
        const categories = Array.isArray(filters.categories) ? filters.categories : [];
        const text = String(filters.text ?? '').trim().toLowerCase();

        return this.getPointFeatures().filter((feature) => {
            const featureCategory = String(feature.properties?.category ?? '');
            const featureSearch = String(feature.properties?.search ?? '').toLowerCase();

            if (categories.length > 0 && !categories.includes(featureCategory)) {
                return false;
            }

            if (text !== '' && !featureSearch.includes(text)) {
                return false;
            }

            return true;
        });
    }

    getHeatPoints(features) {
        return features.map((feature) => {
            const [lng, lat] = feature.geometry.coordinates;

            return [lat, lng, 0.35];
        });
    }
}
