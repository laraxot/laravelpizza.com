# Map Picker Address Search And Mobile Parity

## Scope

Questa pagina sintetizza l'addendum canonico aggiunto a `laravel/Modules/Geo/docs/prompts/map-picker.txt` il 2026-04-22.

## Regole

- I picker Geo devono restare compatibili con Filament v5, Livewire, Alpine e Lit, con Livewire come source of truth lato server.
- La UI deve essere mobile-first e verificata almeno a 375px, 768px e 1440px.
- Tutti i testi visibili devono passare da traduzioni, non da stringhe hardcoded in Blade/PHP; per Lit i label vanno passati dal wrapper Blade come proprieta o oggetto `labels`.
- La pagina `tests/segnalazione-crea` deve prendere come reference `segnalazione-02-dati.html`, ma implementare la parity con Tailwind/Alpine/Lit/Livewire/Laraxot, senza introdurre Bootstrap Italia come dipendenza UI.

## Requisiti Mappa

- Controlli sempre visibili: fullscreen, posizione corrente, cambio layer, zoom in, zoom out.
- Layer minimi: OpenStreetMap Standard, OpenStreetMap Humanitarian, Esri Satellite / World Imagery, Esri Topographic / World Topographic.
- Interazioni: marker draggable, click-to-set, pan nativo, wheel/pinch zoom dove supportato.
- Fullscreen: ingresso/uscita con controllo visibile, `invalidateSize()` dopo cambio stato e accessibilita mobile/tablet.
- Posizione corrente: pulsante esplicito; se coordinate null nel flusso segnalazione, autolocate solo come fallback controllato e documentato.

## Ricerca Indirizzo

- La ricerca indirizzo e user-triggered, coerente con il campo "Cerca un luogo" della reference Design Comuni.
- Il Lit component non deve chiamare provider esterni direttamente.
- La ricerca passa da Livewire/PHP con rate limiting/cache, User-Agent conforme e privacy centralizzata.
- Il risultato aggiorna coordinate, marker, centro mappa, indirizzo leggibile e payload strutturato del form.

## Payload

Lo stato unico resta un oggetto, per esempio `location`.

Forma minima:

```json
{ "latitude": 41.9, "longitude": 12.5 }
```

Forma arricchita consigliata:

```json
{
  "latitude": 41.9,
  "longitude": 12.5,
  "address": "Via Roma 1, Comune",
  "address_details": {},
  "street": "Via Roma",
  "street_number": "1",
  "city": "Comune",
  "postcode": "00100",
  "state": "Lazio",
  "province": "Roma",
  "country": "Italia",
  "country_code": "it",
  "suburb": ""
}
```

Le colonne DB primarie restano `latitude` e `longitude`; gli altri campi sono dati di supporto del form salvo scelta esplicita di persistenza.

## Livewire Performance

- Non inviare eventi Livewire durante pan o drag continuo.
- Aggiornare Livewire solo su click-to-set, dragend, geolocation confermata, selezione risultato ricerca o input coordinate stabile.
- Reverse geocoding solo dopo coordinate stabili, con debounce o evento finale.

## Verifica Visuale

La verifica deve includere screenshot mobile, tablet e desktop della route:

`/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`

Controllare header guest/autenticato, breadcrumb, stepper 2/3, sidebar, sezioni Luogo/Disservizio/Autore e controlli mappa.
