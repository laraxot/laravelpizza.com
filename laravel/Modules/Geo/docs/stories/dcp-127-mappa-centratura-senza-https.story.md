---
id: dcp-127
title: "DCP-127: mappa del picker centrata sull'utente anche senza HTTPS (GPS, poi zona, mai coordinate fisse)"
type: story
epic: dc-parity-v2
status: done-with-open-points
priority: P0
owner: module:Geo
created: 2026-10-13
updated: 2026-10-13
tags: [geo, coordinate-picker, geolocalizzazione, http, gdpr, wizard, guardia-clic]
related:
  - Modules/Geo/docs/stories/dcp-93-geo-namespace-blade-e-mappa-sola-lettura-follow-up.story.md
  - Modules/Fixcity/docs/stories/dcp-146-wizard-passo-dati-mappa-sempre-funzionante.story.md
  - Themes/Sixteen/docs/bmad/geo-dynamic-user-location.md
  - Themes/Sixteen/docs/bmad/decisions/decision-user-location.md
qmd: "dcp-127 geo coordinate picker centratura posizione utente gps http https fuso orario default_view guardia clic zoom sonda playwright"
---

# DCP-127: centratura della mappa senza HTTPS

## Richiesta (utente, 2026-10-13)
Nel wizard `/it/tickets/create?step=form.dati-di-segnalazione::data::wizard-step` le coordinate fisse (`CoordinatePicker::make('location')->center(43.7696, 11.2558)`) vanno contro lo scopo: se il record ha le coordinate si leggono, se sono null la mappa si centra sulla posizione dell'utente (browser). Chi segnala puo' essere ovunque nel mondo. Niente testo «Apri questa pagina in HTTPS per usare la posizione.»; «la mappa deve funzionare sempre», anche senza HTTPS.

## Fase BMAD
Dev (implementazione) e Verify (Playwright reale). Analysis gia' fatta dal coordinatore. Chiusura: second brain.

## Misura di partenza (coordinatore, `http://192.168.1.40:8000`, `isSecureContext=false`)
Mappa sul mondo (centro 19.97/0.00, zoom 3), `Latitudine: --`; un clic al centro piazzava il punto in Mali; testo HTTPS ancora in `dc-place-autocomplete.blade.php`.

## Conflitto di assegnazione e come si e' risolto (21:20 - 21:35 UTC)
La stessa richiesta e' arrivata a due insiemi di agenti: DCP-146 (claim W2-GEO) e DCP-127/128 lanciati dal coordinatore DCP-129, sugli stessi file del Geo. W2-GEO aveva gia' scritto `map/approximate-location.js` e `map/timezone-centers.js` (fuso orario), poi `map/default-view.js` e `geo.config.map.default_view`. Ho scritto per tre quarti d'ora un livello IP (`map/ip-location.js`, endpoint configurabile, nota «posizione approssimativa»), provato con Playwright (c: centro Berlino da endpoint finto, zoom 12, nessun marker; 23/23 controlli). **Alle 21:35 il coordinatore ha deciso (log di DCP-146): IP tramite terzi ABBANDONATO** (GDPR art. 6 e 44, DCP-137); DCP-127 fa solo guardia clic, `dc-place-autocomplete`, pulizia `console.log`, test. Ho quindi RIMOSSO tutto il ramo IP (file, config `approximate_location`, attributo `approximate-location-url`, getter PHP, chiave lingua `approximate_note`, test node) e tolto anche il mio `geo.config.map.center`, ridondante con `default_view`. Una verifica `rg` sul Geo non trova piu' `ip-location|approximate_note|getApproximateLocationUrl|geojs`; il bundle del tema non contiene `geojs`. L'IP resta una possibile estensione futura solo con informativa (DCP-130) e spenta di default.

## Catena finale (stesso componente: wizard, riepilogo read-only, back office)
1. Punto salvato nello stato/record: centro e marker li', zoom del campo.
2. `->center()` esplicito del campo (TicketForm non lo passa piu').
3. GPS se `geolocateWhenEmpty` e contesto sicuro: centro + marker + stato; permesso negato o errore: ricade sulla zona, nessun servizio esterno.
4. Fuso orario del browser (zoom 6, W2-GEO, tabella generata `timezone-centers.js`).
5. `geo.config.map.default_view` (W2-GEO; env `GEO_MAP_DEFAULT_*`), poi il mondo.
6. Guardia clic (mia): sotto zoom 10, senza punto scelto, un clic centra e avvicina di 4 livelli (tetto 10) e NON scrive lo stato; da zoom 10 il clic piazza il punto. Un punto scelto cancella l'invito/nota di posizione.
7. «Usa la tua posizione» (link di `dc-place-autocomplete` e pulsante mappa): stessa funzione `requestGeolocation()` del picker, ora una Promise: GPS se disponibile, altrimenti zona + invito neutro `location_unavailable` (W2-GEO) in `role=status`; negato = nessun messaggio di permesso. Il link non ha piu' codice proprio (prima duplicava la logica e nominava HTTPS).

## Cosa ho cambiato (mio)
| File | Modifica |
|---|---|
| `Modules/Geo/resources/js/components/map/events.js` | `PICK_MIN_ZOOM=10`, guardia clic, `auto: true` all'avvio automatico, `_locationError` azzerato quando si sceglie un punto |
| `.../map/controls/geolocation.js` | `requestGeolocation()` restituisce una Promise; senza `isSecureContext` o API non chiama il GPS e ricade sulla zona; opzione `auto` |
| `.../coordinate-picker-lit.js` | `_requestGeolocation()` restituisce la Promise; tolto `console.log` di debug |
| `Modules/Geo/resources/views/filament/forms/components/{map,geopoint}-picker.blade.php` | `geolocate-when-empty="false"` (su un attributo booleano Lit vale TRUE) sostituito da presenza/assenza dell'attributo, come nel blade del CoordinatePicker. Effetto: i picker di back office che non chiamano `->geolocateWhenEmpty()` smettono di localizzare da soli |
| `Modules/Fixcity/resources/views/filament/forms/components/dc-place-autocomplete.blade.php` | `locate()` delega a `picker._requestGeolocation()`; rimossi `insecure`, `isSecureContext`, helper `$line`, messaggi denied/timeout/unsupported/unavailable; resta lo stato `locating` |
| `Modules/Fixcity/tests/Unit/DcFieldViewsTest.php` | il test sul link asserisce la delega, niente `isSecureContext`/`getCurrentPosition`/chiavi errore, niente «HTTPS» nel testo |
| `Modules/Geo/tests/Unit/Filament/Forms/Components/CoordinatePickerLocationChainTest.php` | 5 test di contratto (nessuna coordinata fissa, nessun servizio IP, nessun `console.log`, nessun testo HTTPS, boolean `geolocate-when-empty`, ordine contesto/GPS, guardia clic) |
| `bashscripts/tools/visual/geo-picker-centering-probe.mjs` | sonda Playwright riusabile, 7 scenari, 39 controlli |
La chiave `fixcity::ticket_form.fields.location.geolocation_insecure` NON esisteva nei file lingua (il blade leggeva con ripiego): nessun file lingua da correggere. `TicketForm.php` non toccato.

## Prove (2026-10-13, tutte misurate)
Sonda: `node bashscripts/tools/visual/geo-picker-centering-probe.mjs --state <storageState.json>` (LAN `http://192.168.1.40:8000` non sicura; `http://127.0.0.1:8000` sicura; tile e Nominatim finti, nessun ticket creato nel DB). Output: **39/39 controlli ok, exit 0**.
| Scenario | Esito misurato |
|---|---|
| a) picker con punto nello stato (44.4949, 11.3426) | centro [44.4949, 11.3425], zoom 13, marker; 0 richieste a servizi IP; 0 chiamate GPS del picker |
| b) 127.0.0.1, GPS concesso (45.4642, 9.19) | centro [45.4642, 9.19], zoom 14, marker, stato lat 45.4642 / lng 9.19, 0 richieste IP |
| c) LAN, fuso Pacific/Auckland | zoom 6, centro [-36.862, 174.7705] (zona del fuso, non Roma), nessun marker, stato vuoto, 0 testi con HTTPS (`innerText` e nodi di testo, anche shadow DOM), 0 richieste IP |
| d) LAN, fuso UTC (sconosciuto) | vista `default-view` configurata [42.5, 12.5] zoom 6; clic: z6 > z10 (solo zoom, nessun punto) > z13 con marker e stato valorizzato |
| d2) LAN, fuso Europe/Rome | zoom 6 centro [41.9023, 12.4805]; clic: z10 senza punto, poi punto |
| e) 127.0.0.1, GPS negato | `getCurrentPosition` -> errore 1; 0 richieste IP; nessun punto; nessun messaggio di permesso/HTTPS |
| f) wizard fino al Riepilogo (LAN) | punto scelto con 3 clic; Riepilogo: mappa read-only sul punto (zoom 16, marker), un clic non scrive lo stato, marker non trascinabile; 0 errori in console |
| g) link «Usa la tua posizione» | LAN: torna alla zona dopo lo spostamento, invito `role=status`, 0 punti; sicura+GPS: marker e stato [41.3874, 2.1686], indirizzo nel campo; GPS negato: nessun messaggio |
Altre prove:
- Back office (`/fixcity/admin/tickets/create` e `/10/edit`, bundle Geo rifatto con `vite build` del modulo, output `public_html/assets/geo`; prima serviva un bundle vecchio: mondo zoom 3): create = vista `default`/`timezone` zoom 6, 0 errori, 0 richieste IP; edit del ticket 10 = centro sul record [-63.255, 150.286], zoom 13, marker, `lat -63.254845`.
- Pest: `CoordinatePickerLocationChainTest` 5/5; con i file PRE-modifica rimessi al loro posto 4/5 rossi (prova che fallisce senza la correzione); `DcFieldViewsTest` 49/49, e con il blade vecchio il test del link e' ROSSO. Insieme a `Modules/Geo/tests/Unit/Filament/Forms/Components`: 96 passati, 1 rosso preesistente (`CoordinatePicker is not dehydrated by default`, elencato in DCP-93).
- PHPStan (`./vendor/bin/phpstan analyse <file>`, config unica): 0 errori su `HasCoordinatePicker.php`, `config/config.php`, i due file di test.
- Sentinelle dopo `vite build` + `view:clear`: `/it` 200, `/it/tickets` 200, `/it/tests/homepage` 200, `/it/tickets/confirmation` 200, `/it/tests/permessi-area-personale` 200, `/it/tickets/create` 302.
- `node --test Modules/Geo/tests/js/` (di W2-GEO): 3/3.

## Difetti e punti aperti (per il coordinatore)
1. **`default_view` ha un valore di default (Italia 42.5/12.5 zoom 6) in `config/config.php` e `FALLBACK_VIEW` in `default-view.js`**: la decisione delle 21:35 diceva «solo se impostata esplicitamente», altrimenti il mondo con la guardia clic. Oggi il mondo non compare piu' mai (misurato: UTC -> Italia). E' di W2-GEO, non l'ho toccato.
2. **`timezone-centers.js` contiene ~550 coordinate di riferimento, tra cui Roma** (chiave `Europe/Rome`): e' dato guidato dal fuso del browser, non un default, ma un `grep` letterale per Roma lo trova; i miei test controllano i file del picker, non quella tabella.
3. L'invito neutro «Clicca sulla mappa per indicare la posizione» compare anche a zoom 6, dove il primo clic avvicina soltanto: non e' un errore, ma il testo promette piu' di quello che fa. Non l'ho cambiato (testo di W2-GEO).
4. **Config cache**: `bootstrap/cache/config.php` (12:42) nascondeva le chiavi nuove; ho lanciato `php artisan config:cache`. Il file `config/config.php` di un modulo si carica come `geo.config.*`, NON `geo.*`: il codice esistente `config('geo.driver')`, `config('geo.cache.enabled')`, `config('geo.markers...')` legge chiavi che non esistono (non corretto qui).
5. Back office: il bundle Geo era di ore prima (20:00) e non rifletteva il codice; e' stato ricostruito con `../../node_modules/.bin/vite build` nel modulo (con il lock di build). Chi ricostruisce il Geo dopo di me ottiene lo stesso risultato; nessuna `npm run copy`.
6. Non ho verificato: GPS reale su dispositivo, HTTPS vero (127.0.0.1 e' sicuro per specifica; la posizione e' simulata da Playwright), tile e Nominatim reali (finti nella sonda), il comportamento su telefono (touch/pan), `de`/`es` della nota di posizione sul DOM (le chiavi `location_unavailable`/`no_position` sono di W2-GEO; ho misurato solo `it`).

## Coordinamento
Claim e proposte nel log di DCP-146 (`Modules/Fixcity/docs/stories/dcp-146-wizard-passo-dati-mappa-sempre-funzionante.story.md`); decisione di DCP-129 recepita. Documenti collegati: `Themes/Sixteen/docs/bmad/geo-dynamic-user-location.md` e `.../decisions/decision-user-location.md` (corretti dove la misura li smentiva), `Modules/Geo/docs/map-vista-di-default-e-posizione-non-disponibile.md` (W2-GEO).
