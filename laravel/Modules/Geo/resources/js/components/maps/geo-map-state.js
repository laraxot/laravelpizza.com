export class GeoMapState {
    constructor(config = {}) {
        const initialState = config.initialState ?? {};
        this._listeners = new Set();
        this.geoJson = config.geoJson ?? { type: 'FeatureCollection', features: [] };
        this.center = initialState.center ?? { lat: 45.4642, lng: 9.1900 };
        this.zoom = Number.isFinite(initialState.zoom) ? initialState.zoom : 7;
        this.selectedId = initialState.selectedId ?? null;
        this.activeLayers = new Set(initialState.activeLayers ?? ['cluster']);
        this.filters = {
            categories: initialState.filters?.categories ?? [],
            text: initialState.filters?.text ?? '',
        };
    }

    subscribe(listener) {
        this._listeners.add(listener);

        return () => this._listeners.delete(listener);
    }

    notify(reason) {
        this._listeners.forEach((listener) => listener(this.snapshot(), reason));
    }

    snapshot() {
        return {
            geoJson: this.geoJson,
            center: this.center,
            zoom: this.zoom,
            selectedId: this.selectedId,
            activeLayers: [...this.activeLayers],
            filters: { ...this.filters },
        };
    }

    setSelectedId(selectedId) {
        this.selectedId = selectedId;
        this.notify('selected');
    }

    setFilterText(text) {
        this.filters.text = String(text ?? '').trim().toLowerCase();
        this.notify('filters');
    }

    setFilterCategories(categories) {
        this.filters.categories = [...categories];
        this.notify('filters');
    }

    setActiveLayer(key, enabled) {
        if (enabled) {
            this.activeLayers.add(key);
        } else {
            this.activeLayers.delete(key);
        }

        this.notify('layers');
    }

    setViewport(center, zoom) {
        this.center = center;
        this.zoom = zoom;
        this.notify('viewport');
    }
}
