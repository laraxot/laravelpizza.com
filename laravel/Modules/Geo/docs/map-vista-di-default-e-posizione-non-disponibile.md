---
id: geo-map-default-view
title: "Mappa del picker: vista di default dell'ente e posizione non disponibile"
type: how-to
module: Geo
created: 2026-10-13
updated: 2026-10-13
story: Modules/Fixcity/docs/stories/2026-10-13-dcp-146-wizard-passo-dati-mappa-sempre-funzionante.story.md
related:
  - Themes/Sixteen/docs/decision-log/D19-coordinate-dynamic.md
qmd: "geo map default_view territorio ente vista di default centratura picker posizione non disponibile aria-live"
---

# Mappa del picker: vista di default e posizione non disponibile

## Cosa fa
Il componente `coordinate-picker-lit` (e i picker Filament che lo usano) apre sempre su una vista sensata, mai sul mondo intero, anche su origine HTTP dove il browser non espone il GPS.

Ordine di centratura all'apertura (funzione pura `map/default-view.js`, `resolveInitialView`):
1. punto salvato nello stato o nel record (zoom del campo);
2. centro esplicito del campo (`->center()` o `geo.config.map.center`);
3. zona dal fuso orario del browser (`map/approximate-location.js`, zoom 6, senza rete);
4. vista di default dell'ente: `geo.config.map.default_view` (attributo Lit `default-view`);
5. panoramica d'Italia cablata in `FALLBACK_VIEW` (solo per chi monta il Lit senza passare la vista).

La posizione precisa del browser e' un miglioramento progressivo: se `isSecureContext` e il permesso lo consentono arriva dopo e ricentra. Nessuna geolocalizzazione per IP tramite servizi terzi (DCP-137).

## Configurazione
Chiave reale: `geo.config.map.default_view` (il file `config/config.php` del modulo si carica come `geo.config`, non `geo`).

| Env | Default | Note |
|---|---|---|
| `GEO_MAP_DEFAULT_LAT` | 42.5 | gradi, da -90 a 90 |
| `GEO_MAP_DEFAULT_LNG` | 12.5 | gradi, da -180 a 180 |
| `GEO_MAP_DEFAULT_ZOOM` | 6 | intero da 1 a 19 |

E' il territorio che l'ente ha configurato, non la posizione dell'utente (D19: il luogo e' dove si trova chi segnala, nessun Comune inventato nel codice). Un valore non valido ricade sulla panoramica d'Italia: `HasCoordinatePicker::getMapDefaultView()` non rompe la pagina. Il nome evita `getDefaultView()`, che in Filament e' la vista Blade del componente. Con `bootstrap/cache/config.php` presente serve `php artisan config:cache` (o `config:clear`) per vedere i nuovi valori; senza, vale il default.

## Pulsante "Usa la mia posizione"
Se il GPS non e' disponibile o fallisce (origine non sicura, permesso negato, timeout, nessun sensore) il pulsante non e' mai muto:
- ricentra sul punto salvato, o sulla vista di partenza (`ctx._initialView`);
- scrive l'invito neutro `location_unavailable` in un paragrafo `role="status" aria-live="polite"` sempre presente nel DOM (vuoto non si vede);
- non nomina HTTPS ne' permessi.

Testo (it): "Non riesco a leggere la tua posizione da questo dispositivo. Cerca un indirizzo o tocca la mappa." Esiste in `lang/{it,en,de,es}/coordinate-picker.php` (arriva dal Blade nell'attributo `labels`) e in `map/labels.js` (chi non passa `labels`, segue `<html lang>`). L'invito sparisce quando l'utente indica il punto.

## Ricerca indirizzo
Dopo una ricerca riuscita `selectSearchResult` emette `address-selected` oltre a `coords-changed`: senza, il wrapper Alpine riceveva solo le coordinate e il riepilogo restava "Indirizzo: --".

## Prove
- `node --test Modules/Geo/tests/js/default-view.test.mjs` (3 test, ordine dei livelli e vista non valida).
- `Modules/Geo/tests/Unit/Filament/Forms/Components/CoordinatePickerDefaultViewTest.php` (10 test: default di config, tipi, valori non validi, attributo nei 3 blade).
- Browser su `http://192.168.1.40:8000` (`isSecureContext=false`), script nello scratchpad della sessione DCP-146 (`w2/probe2.mjs`, `w2/langs.mjs`, `w2/search2.mjs`).
