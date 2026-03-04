# Mappa Statica Cliccabile - Implementazione

## Obiettivo
Implementare una mappa statica (immagine PNG) che, al click, apre Google Maps con l'indirizzo di destinazione. Questo approccio garantisce:
- Precisione visiva (utilizzando la base cartografica di Google Maps per l'immagine statica).
- Performance eccellenti (caricamento di un'immagine locale invece di iframe pesanti).
- Accessibilità elevata (link descrittivi e alt text corretti).
- Rispetto delle risorse gratuite (uso di link di navigazione gratuiti invece di API a pagamento).

## Indirizzo Target
**Via Vanzo 86, 31021 Mogliano Veneto TV**
- Coordinate: 45.5633, 12.2506
- Zoom consigliato: 15-16

## 🚨 Regola Critica: Risorse Free e Open Source
- **MAI** usare Google Maps API (Static API, JS API, Geocoding) a pagamento.
- **SEMPRE** preferire risorse gratuite per i dati dinamici (OpenStreetMap/Nominatim).
- Per la visualizzazione statica, è consentito l'uso di uno screenshot manuale della mappa di Google Maps (salvato localmente) per garantire la precisione richiesta dall'utente, collegato tramite un link di ricerca gratuito.

## Implementazione
**Soluzione: Immagine PNG salvata localmente + Link Google Maps Navigazione**

1. Salvare il PNG in `Modules/TechPlanner/resources/images/map-via-vanzo.png`.
2. Assicurarsi che l'immagine sia copiata in `public/modules/techplanner/images/`.
3. Utilizzare il componente `pub_theme::components.blocks.map.static-clickable`.
4. Al click, aprire Google Maps tramite link di ricerca: `https://www.google.com/maps/search/?api=1&query=Via+Vanzo+86,+Mogliano+Veneto+TV`.

## Accessibilità (WCAG 2.1)
- L'elemento `<a>` deve avere un `aria-label` descrittivo (es. "Apri indicazioni stradali per Via Vanzo 86 su Google Maps").
- L'immagine deve avere un `alt` text che descriva la posizione.
- Non rimuovere mai l'indicatore di focus (`outline`) senza sostituirlo con uno stile visibile equivalente.
