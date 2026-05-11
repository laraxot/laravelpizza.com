export function resolveStateCoordinates(state) {
        if (!state || typeof state !== 'object') {
                return { lat: null, lng: null };
        }

        return {
                lat: state.lat ?? state.latitude ?? null,
                lng: state.lng ?? state.longitude ?? null,
        };
}

export function normalizeCoordinatePair(lat, lng) {
        const normalizedLat = Number.parseFloat(Number.parseFloat(lat).toFixed(6));
        const normalizedLng = Number.parseFloat(Number.parseFloat(lng).toFixed(6));

        if (!Number.isFinite(normalizedLat) || !Number.isFinite(normalizedLng)) {
                return null;
        }

        return { lat: normalizedLat, lng: normalizedLng };
}
