/**
 * Invalidate map size after control actions (fullscreen, zoom, layer switch).
 * Delegates to host._refreshMapSize when present, else schedules invalidateSize.
 *
 * @param {Object} ctx - Lit map host
 * @param {number[]} delays - ms delays for invalidateSize fallback
 */
export function scheduleMapInvalidate(ctx, delays = [0]) {
    if (typeof ctx._refreshMapSize === 'function') {
        ctx._refreshMapSize(delays);
        return;
    }

    delays.forEach((delay) => {
        setTimeout(() => ctx._map?.invalidateSize(), delay);
    });
}
