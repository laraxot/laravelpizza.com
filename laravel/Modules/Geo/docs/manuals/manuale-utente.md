---
title: "Manuale utente — Geo (pannello admin)"
type: user-manual
status: active
module: Geo
screenshot: assets/geo-admin-dashboard.webp
updated: 2026-11-25
qmd: "manuale utente geo"
---

> Screenshot catturati il 2026-11-25 dall'istanza di prova isolata (database vuoto,
> utente sintetico super-admin). Non contengono dati reali: le liste sono vuote
> («Nessun risultato»). Il manuale precedente mostrava solo la home pubblica generica,
> che non documentava il modulo ed è stata rimossa.

# Modulo Geo — pannello di amministrazione

## Scopo

Pannello Filament del modulo Geo, sotto `/geo/admin`: indirizzi, località, mappe
geografiche e impostazioni del modulo.

## Accesso

- Login: `/geo/admin/login` — campi **Email** (obbligatorio) e **Password** (obbligatorio),
  opzione **Ricordami**, link **Hai smarrito la password?**, pulsante **Accedi**.

![Login](assets/geo-admin-login.webp)

- Recupero password: `/geo/admin/password-reset/request` e `/geo/admin/password-reset/reset`
  (route presenti, non provate in questa passata).
- Logout: `POST /geo/admin/logout`.
- Dopo il login si atterra sulla dashboard `/geo/admin`.

Route verificate con `php artisan route:list --path=geo/admin` (2026-11-25).

## Attori

| Attore | Evidenza |
|---|---|
| Utente autenticato del pannello | Vede il menu completo e le pagine catturate (test con utente super-admin sintetico). |
| Super-admin | Il docblock di `app/Filament/Pages/SettingPage.php` dice «solo super-admin» per le impostazioni. Non provato con un utente non super-admin. |

Non ci sono attori pubblici documentati: le pagine di questo manuale stanno tutte dietro login.

## Menu

Dalla cattura della dashboard (`geo-admin-dashboard.webp`):

- **Geo**: Dotswan Map, Location Map, Location Map Table, O S M Map, Webbingbrasil Map,
  Impostazioni, Località (badge 0).
- **Gestione Territorio**: Lat Lng.
- **address.navigation**: address.navigation (badge 0). Il nome del gruppo non è tradotto,
  vedi «Difetti noti».
- In basso: **Pannello principale** (torna al pannello generale).

## Dashboard

![Dashboard](assets/geo-admin-dashboard.webp)

Mostra un unico riquadro con titolo **«farmshops.eu Replica»**, descrizione
«Porting Lit del comportamento e del linguaggio visivo originale di farmshops.eu» e le
statistiche: Feature 6, Punti 5, Zone 1, Categorie: beekeeper, farm, marketplace,
vending_machine. La mappa non è visibile nello screenshot: c'è solo il riquadro di testo.

Fonti: `app/Filament/Pages/Dashboard.php` (widget `geo_map`),
`app/Filament/Widgets/GeoMapWidget.php`, `resources/views/filament/widgets/geo-map-widget.blade.php`,
testi in `lang/it/geo_map_widget.php`.

## Indirizzi (Address)

### Lista

![Lista indirizzi](assets/geo-admin-addresses.webp)

- Titolo: «Address.navigation» (non tradotto).
- Colonne: Nome Indirizzo, Route, Locality, Administrative area level 3, Administrative area
  level 2, Postal code, Type, Indirizzo Principale.
- Ricerca «Cerca», pulsante «Nuovo» in alto a destra e un secondo «Nuovo» nella barra della tabella.
- Stato vuoto: «Nessun risultato — Crea un address per iniziare».

### Creazione

![Nuovo indirizzo](assets/geo-admin-address-create.webp)

Campi visibili, in ordine: **Nome**; **Regione** (obbligatorio, a tendina); **Provincia**,
**Comune**, **CAP** (a tendina); **Via o piazza** (obbligatorio); **Numero civico**;
**Indirizzo principale** (interruttore). Pulsanti: **Salva**, **Salva & nuovo**, **Annulla**.

Non documentate con screenshot: vista `/geo/admin/addresses/{record}` e modifica
`/geo/admin/addresses/{record}/edit` (route presenti).

Fonte: `app/Filament/Resources/AddressResource.php` e `AddressResource/Pages/`.

## Località (Location)

### Lista

![Lista località](assets/geo-admin-locations.webp)

- Titolo da Lang (`geo::location`); voce di menu «Località».
- Colonne: id, Name, Created at. Ricerca, pulsanti «+ Nuovo» e «Nuovo».
- Stato vuoto: «Nessun risultato — Crea un Location per iniziare».

### Creazione

![Nuova località](assets/geo-admin-location-create.webp)

Campi visibili: **Name** (obbligatorio), **Latitude** (obbligatorio), **Longitude**
(obbligatorio), **Street**, **City**, **State**, **Zip**, **Formatted address**.
La pagina continua sotto la piega dello screenshot: i campi successivi non sono documentati.
Le etichette dei campi sono in inglese.

Fonte: `app/Filament/Resources/LocationResource.php` e `LocationResource/Pages/`.

## Mappe

![Location Map](assets/geo-admin-location-map.webp)

- **Location Map**: nello screenshot c'è solo il titolo, nessuna mappa. Il codice spiega il motivo: `app/Filament/Pages/LocationMap.php` restituisce un array
  vuoto da `getHeaderWidgets()` (il widget è commentato, «disabilitato per compatibilità
  Filament v4»). La pagina è vuota per il codice, non per la rete.
![O S M Map](assets/geo-admin-osm-map.webp)

- **O S M Map**: stesso caso. `app/Filament/Pages/OSMMap.php` ha
  i widget commentati e nessun widget attivo. La pagina è vuota.
- **Dotswan Map**, **Location Map Table**, **Webbingbrasil Map**: voci di menu e route presenti,
  **non catturate**: nessuna descrizione visiva.

Limite: nessuna tessera cartografica è mai apparsa in questa passata, quindi non è
possibile dire se le tessere (OpenStreetMap, Esri) si caricano in rete.

## Lat Lng

![Lat Lng](assets/geo-admin-lat-lng.webp)

Pagina con testo grezzo: `lat: 0`, `lng: 0`, `err_code: 1`, `err_message: Only secure origins
are allowed` (con un link breve). L'istanza di prova è servita via http, e il messaggio dice
che la geolocalizzazione richiede un'origine sicura. Non provato su https.
Fonti: `app/Filament/Pages/LatLng.php`, `app/Filament/Widgets/LatLngWidget.php`.

## Impostazioni

![Impostazioni Geo](assets/geo-admin-setting.webp)

- Titolo della pagina: «setting» (non tradotto, vedi difetti).
- Sezione **Generale**: interruttore **Debugbar attiva** («Attiva/disattiva la modalità debug
  per aiutare a diagnosticare errori») e campo **Google Maps API key** (descrizione
  «Chiave API di Google Maps (GOOGLE_MAPS_API_KEY)»). Il testo grigio `AIzaSyAuB_...` dentro
  il campo è solo un segnaposto (`Xot/lang/it/env.php`), non un valore. Pulsante **Salva**.
  Il widget è `EnvWidget` e legge `debugbar_enabled` e `google_maps_api_key` dal `.env`: nel
  `.env` dell'ambiente di prova la chiave è vuota, quindi il campo appare vuoto.
- Sotto la sezione: interruttore **Enabled** con un secondo pulsante **Save** (in inglese).
- Il salvataggio scrive la configurazione tenant del modulo (`config/{tenant}/geo.php`,
  da docblock di `SettingPage`).

## Difetti noti

| # | Pagina | Evidenza | Stato |
|---|---|---|---|
| 1 | Dashboard | Titolo e descrizione del widget sono testi di un altro progetto («farmshops.eu Replica»): `lang/it/geo_map_widget.php:8,11`. | Non corretto: è copy editoriale, da decidere. |
| 2 | Location Map, O S M Map | Pagine con solo il titolo: `LocationMap.php` e `OSMMap.php` non hanno widget attivi. Le voci di menu portano a pagine vuote. | Non corretto: serve scegliere se riattivare i widget o nascondere le voci. |
| 3 | Impostazioni | Se `GOOGLE_MAPS_API_KEY` è valorizzata nel `.env`, `EnvWidget` la mostra in un campo di testo in chiaro a chi apre la pagina (solo super-admin). In questo ambiente la chiave è vuota: nessun valore visibile nello screenshot. | Segnalato, non corretto: il widget è del modulo Xot (lo stesso widget mostra `mail_password` in Notify/Impostazioni e in Xot/Ambiente). |
| 4 | Impostazioni | Titolo della pagina «setting» non tradotto; due pulsanti di salvataggio («Salva» e «Save») e interruttore «Enabled» in inglese. Origine probabile: `BaseSettingPage` (modulo Xot). | Segnalato, non corretto. |
| 5 | Indirizzi, Località | Gruppo/etichette Address ancora grezze in alcuni punti (`address.navigation`). Titolo lista Località: rimosso hardcode «All Locations» (2026-11-25). | Parziale. |
| 6 | Dashboard | Il riquadro statistiche della blade (`geo-map-widget.blade.php`) appare senza il suo stile: testi non in grassetto, nessun box grigio. Causa non verificata (probabilmente classi Tailwind non incluse nel build del pannello). | Segnalato. |
| 7 | Lat Lng | Output grezzo con `lat`, `lng`, `err_code`: non è una pagina pronta per l'utente. | Segnalato. |
| 8 | Repo | Il file `laravel/Modules/Geo/lang/it/.php` ha nome vuoto. | Segnalato, non rimosso. |
| 9 | Liste | «Nuovo» compare due volte (intestazione e barra della tabella). | Minore, non corretto. |

## Limiti

- Database di prova vuoto: nessun indirizzo o località reale o sintetico. Tutte le liste sono vuote.
- Non verificato: Dotswan Map, Location Map Table, Webbingbrasil Map, vista e modifica di
  indirizzi e località, recupero password, comportamento per utenti non super-admin.
- Non verificato: il comportamento delle mappe con rete e tessere attive (vedi sopra).
- Il modulo non espone pagine pubbliche documentate in questo manuale.

## Fonti

- `laravel/Modules/Geo/app/Filament/Pages/` (Dashboard, LocationMap, OSMMap, LatLng, SettingPage)
- `laravel/Modules/Geo/app/Filament/Widgets/GeoMapWidget.php`, `LatLngWidget.php`
- `laravel/Modules/Geo/app/Filament/Resources/AddressResource.php`, `LocationResource.php`
- `laravel/Modules/Geo/resources/views/filament/widgets/geo-map-widget.blade.php`
- `laravel/Modules/Geo/lang/it/geo_map_widget.php`
- Route: `php artisan route:list --path=geo/admin`
- Screenshot: `assets/geo-admin-*.webp` (catturati con `bashscripts/tools/docs/manual-screenshots.mjs`; manifest `screenshots.json`)
