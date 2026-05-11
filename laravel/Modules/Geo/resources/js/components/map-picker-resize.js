export function measureMapPane(host) {
        if (host.offsetParent === null) {
                return null;
        }

        const pane = host.querySelector('.map-picker-leaflet-pane');
        if (!pane) {
                return null;
        }

        const rect = pane.getBoundingClientRect();
        if (!rect || rect.width === 0 || rect.height === 0) {
                return null;
        }

        return { width: rect.width, height: rect.height };
}

export function hasMeaningfulSizeChange(previous, current, epsilon = 0.5) {
        if (!previous) {
                return true;
        }

        return Math.abs(previous.width - current.width) >= epsilon
                || Math.abs(previous.height - current.height) >= epsilon;
}

export function scheduleLeafletInvalidate(host, map, redrawFn) {
        [0, 50, 150, 300, 500, 800, 1200].forEach((delay) => {
                setTimeout(() => {
                        if (host.offsetParent === null || !map) {
                                return;
                        }

                        map.invalidateSize({ animate: false, pan: false });
                        redrawFn();
                }, delay);
        });
}

export function refreshMapSize(host) {
        if (!host._map) return;
        scheduleLeafletInvalidate(host, host._map, () => {});
}

export function bindRefreshHandler(host) {
        const { resizeObserver, mutationObserver } = attachSizeObservers(host, () => refreshMapSize(host));
        host._resizeObserver = resizeObserver;
        host._mutationObserver = mutationObserver;
}

export function cleanupObservers(host) {
        if (host._resizeObserver) { host._resizeObserver.disconnect(); host._resizeObserver = null; }
        if (host._mutationObserver) { host._mutationObserver.disconnect(); host._mutationObserver = null; }
}

export function attachSizeObservers(host, refreshFn) {
        const resizeObserver = new ResizeObserver(refreshFn);
        resizeObserver.observe(host);

        const mutationObserver = new MutationObserver(() => {
                if (host.offsetParent !== null) {
                        refreshFn();
                }
        });

        let parent = host.parentElement;
        for (let i = 0; i < 20 && parent; i++) {
                mutationObserver.observe(parent, {
                        attributes: true,
                        attributeFilter: ['class', 'style', 'hidden'],
                });
                parent = parent.parentElement;
        }

        return { resizeObserver, mutationObserver };
}
