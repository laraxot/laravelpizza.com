import { TIMEZONE_CENTERS } from './timezone-centers.js';

/** Zoom "regionale": mostra il Paese o la regione del fuso, senza fingere di sapere dove si trova l'utente. */
export const APPROXIMATE_ZOOM = 6;

/**
 * Centro approssimativo dell'utente dal fuso orario del browser, senza permessi, senza rete e senza HTTPS.
 * E' il ripiego quando la posizione precisa non e' disponibile (origine HTTP, permesso negato, timeout):
 * la mappa si apre nella sua zona e l'utente indica il punto esatto con un clic o con la ricerca.
 *
 * @returns {{lat: number, lng: number} | null} null se il fuso e' sconosciuto (es. UTC)
 */
export function approximateCenterFromTimezone() {
    let timeZone = '';
    try {
        timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
    } catch {
        return null;
    }
    const center = TIMEZONE_CENTERS[timeZone];

    return center ? { lat: center[0], lng: center[1] } : null;
}
