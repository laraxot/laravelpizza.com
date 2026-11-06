/**
 * Etichette dei controlli mappa e messaggi di geolocalizzazione, per lingua della pagina (<html lang>).
 * Stesso schema di `getPopupLabels()` in popup-ticket.js; lingue come il selettore del sito: it, en, de, es.
 * Una view puo' sovrascriverle passando l'attributo `labels` a <map-lit>.
 */
const MAP_LABELS = {
    it: {
        fullscreen: 'Schermo intero',
        close_fullscreen: 'Esci da schermo intero',
        use_location: 'Usa la mia posizione',
        switch_layer: 'Cambia layer',
        zoom_in: 'Aumenta zoom',
        zoom_out: 'Diminuisci zoom',
        search: 'Cerca',
        search_placeholder: 'Cerca indirizzo...',
        close_search: 'Chiudi ricerca',
        legend_title: 'Stati segnalazione',
        geo_unsupported: 'Geolocalizzazione non disponibile su questo browser.',
        location_unavailable: 'Non riesco a leggere la tua posizione da questo dispositivo. Cerca un indirizzo o tocca la mappa.',
        geo_failed: 'Non è stato possibile rilevare la posizione. Riprova.',
        geo_denied: 'Consenti l’accesso alla posizione nel browser e riprova.',
        geo_blocked: 'Posizione bloccata per questo sito: clicca il lucchetto accanto all’indirizzo, imposta Posizione su Consenti e ricarica la pagina.',
    },
    en: {
        fullscreen: 'Fullscreen',
        close_fullscreen: 'Exit fullscreen',
        use_location: 'Use my location',
        switch_layer: 'Change layer',
        zoom_in: 'Zoom in',
        zoom_out: 'Zoom out',
        search: 'Search',
        search_placeholder: 'Search address...',
        close_search: 'Close search',
        legend_title: 'Report statuses',
        geo_unsupported: 'Geolocation is not available in this browser.',
        location_unavailable: 'I can\'t read your location from this device. Search for an address or tap the map.',
        geo_failed: 'Could not detect your location. Please try again.',
        geo_denied: 'Allow location access in your browser and try again.',
        geo_blocked: 'Location is blocked for this site: click the lock next to the address, set Location to Allow and reload the page.',
    },
    de: {
        fullscreen: 'Vollbild',
        close_fullscreen: 'Vollbild beenden',
        use_location: 'Meinen Standort verwenden',
        switch_layer: 'Ebene wechseln',
        zoom_in: 'Vergrößern',
        zoom_out: 'Verkleinern',
        search: 'Suchen',
        search_placeholder: 'Adresse suchen...',
        close_search: 'Suche schließen',
        legend_title: 'Status der Meldungen',
        geo_unsupported: 'Die Standortbestimmung ist in diesem Browser nicht verfügbar.',
        location_unavailable: 'Ich kann Ihren Standort von diesem Gerät nicht lesen. Suchen Sie eine Adresse oder tippen Sie auf die Karte.',
        geo_failed: 'Der Standort konnte nicht ermittelt werden. Bitte versuchen Sie es erneut.',
        geo_denied: 'Erlauben Sie den Zugriff auf den Standort im Browser und versuchen Sie es erneut.',
        geo_blocked: 'Der Standort ist für diese Website blockiert: Klicken Sie auf das Schloss neben der Adresse, setzen Sie Standort auf Zulassen und laden Sie die Seite neu.',
    },
    es: {
        fullscreen: 'Pantalla completa',
        close_fullscreen: 'Salir de pantalla completa',
        use_location: 'Usar mi ubicación',
        switch_layer: 'Cambiar capa',
        zoom_in: 'Acercar',
        zoom_out: 'Alejar',
        search: 'Buscar',
        search_placeholder: 'Buscar dirección...',
        close_search: 'Cerrar búsqueda',
        legend_title: 'Estados de las incidencias',
        geo_unsupported: 'La geolocalización no está disponible en este navegador.',
        location_unavailable: 'No puedo leer tu ubicación desde este dispositivo. Busca una dirección o toca el mapa.',
        geo_failed: 'No se pudo detectar tu ubicación. Inténtalo de nuevo.',
        geo_denied: 'Permite el acceso a la ubicación en el navegador e inténtalo de nuevo.',
        geo_blocked: 'La ubicación está bloqueada para este sitio: haz clic en el candado junto a la dirección, establece Ubicación en Permitir y recarga la página.',
    },
};

export function getMapLabels() {
    const lang = (document.documentElement.lang || 'it').slice(0, 2).toLowerCase();

    return { ...(MAP_LABELS[lang] ?? MAP_LABELS.it) };
}
