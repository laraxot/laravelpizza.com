import {
    buildTicketPopupHtml,
    buildTicketPopupLoadingHtml,
} from './popup-ticket.js';
import { resolveFeatureTicketType } from './feature-type.js';
import { resolveFeatureTicketStatus } from './feature-status.js';

/**
 * Bind Leaflet popup + ticket detail fetch for a GeoJSON feature layer.
 *
 * @param {{ _ensureFeaturePopup: Function, _wirePopupActions: Function }} mapLit
 * @param {object} feature
 * @param {import('leaflet').Layer} layer
 */
export function bindFeaturePopup(mapLit, feature, layer) {
    const L = window.L;
    const p = feature.properties || {};
    const ticketType = resolveFeatureTicketType(p);
    const ticketStatus = resolveFeatureTicketStatus(p);
    const coordsRaw = feature.geometry?.coordinates;
    const lng = Number(coordsRaw?.[0]);
    const lat = Number(coordsRaw?.[1]);
    const coords = { lat, lng };

    layer.bindPopup(buildTicketPopupLoadingHtml(ticketType, ticketStatus), {
        className: 'popup-wrapper',
        maxWidth: 380,
        minWidth: 300,
        autoPanPaddingTopLeft: L.point(window.innerWidth < 640 ? 56 : 72, 16),
        autoPanPaddingBottomRight: L.point(16, 28),
    });

    layer.on('click', (event) => {
        if (event?.originalEvent) {
            L.DomEvent.stopPropagation(event);
        }

        const popup = mapLit._ensureFeaturePopup(layer);

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
            mapLit._wirePopupActions(popup);
        };

        if (layer._geoDetailCache) {
            showPopup(layer._geoDetailCache);
            return;
        }

        if (!p.id) {
            showPopup(null);
            return;
        }

        popup.setContent(buildTicketPopupLoadingHtml(ticketType, ticketStatus));
        popup._geoFeatureProps = null;
        popup.update();
        fetch(`/api/ticket-details/${p.id}`)
            .then((res) => (res.ok ? res.json() : null))
            .then((detail) => showPopup(detail))
            .catch(() => showPopup(null));
    });
}
