---
title: "Geo — manuale d'uso per attori"
type: manual
---

# Scopo

Geo fornisce dati e componenti geografici al front office e modelli geografici
amministrabili in Filament. Non è il luogo in cui si assegnano ruoli ai
cittadini.

## Attori e capacità effettive

| Attore | Dominio | Capacità verificata |
| --- | --- | --- |
| Ospite | Cittadino/front office | Usa mappe e geocodifica tramite il dominio applicativo, se il layout e la configurazione li attivano. |
| Utente autenticato | Cittadino/front office | Come l'ospite per le capacità Geo esposte; non è dichiarato un permesso cittadino speciale. |
| Gruppo/ruolo con permessi | Backoffice | Gestisce i modelli con permessi `place.*`, `location.*` e analoghi permessi specifici del modello. |
| `geo::admin` | Backoffice | Bypass delle policy Geo. |
| `super-admin` | Backoffice | Bypass delle policy Geo. |
| Operatore/moderatore | — | N/A: nessun ruolo di questo nome è dichiarato dal modulo. |

## Flussi

### Front office cittadino

Il browser richiede al dominio applicativo i tile
`/api/geo/tiles/osm/{z}/{x}/{y}.png` e la ricerca o il reverse geocoding su
`/api/geo/nominatim/{search,reverse}`. Le route sono API senza sessione; la
ricerca è un'azione esplicita, non un'autocompletamento implicito. Il layout
deve dichiarare gli URL `data-geo-tile-url` e `data-geo-nominatim-url`; il
proxy Nominatim può essere disattivato dalla configurazione.

### Backoffice geografico

Per un modello Geo il controllo passa dalla policy: `super-admin` o
`geo::admin` bypassano; altrimenti servono i permessi dell'oggetto e
dell'abilità, per esempio `place.viewAny`, `place.view`, `place.create`,
`place.update`, `place.delete` e relativi restore/forceDelete.

## Prerequisiti e limiti

- Il proxy deve essere caricato dal `GeoServiceProvider`; le route non
  richiedono cookie o sessione.
- Tile: throttling dichiarato `1200/minuto`; Nominatim: `30/minuto` per
  route, validazione dei parametri e limite globale di una richiesta al
  secondo verso il fornitore.
- Query troppo corte, coordinate fuori intervallo ed endpoint non ammessi
  sono rifiutati senza chiamare Nominatim; il servizio disabilitato risponde
  `503`.
- La capacità del widget Filament `OSMMapWidget` non è attribuita ai cittadini:
  la fonte lo indica disabilitato per compatibilità Filament 4.
- N/A: Geo non definisce autenticazione cittadina, ruoli PA o gestione del
  consenso; il suo proxy è una capacità tecnica utilizzabile dal front office.

## Riferimenti verificabili

- `routes/api.php:21-38` — route, middleware/throttle e controller proxy.
- `app/Providers/GeoServiceProvider.php:26-34` — registrazione del provider
  di route Geo.
- `app/Models/Policies/GeoBasePolicy.php:10-27` — bypass di ruolo.
- `app/Models/Policies/PlacePolicy.php:13-67` e
  `app/Models/Policies/LocationPolicy.php:13-67` — permessi effettivi.
- `docs/adr/osm-proxy-tile-nominatim.md:31-43` — contratto front office,
  privacy e configurazione.
- `tests/Feature/OsmProxyTest.php:48-60,105-149` — proxy, cache, limiti e
  disattivazione verificati.
