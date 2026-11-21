---
id: dcp-454
title: "DCP-454: terze parti caricate prima del consenso (avatar Gravatar e tile OpenStreetMap)"
type: story
status: done
module: Gdpr
created: 2026-11-12
updated: 2026-11-17
tags: [bmad, story, gdpr, cookie, consenso, gravatar, openstreetmap, terze-parti, csp, decisione]
qmd: "terze parti prima del consenso gravatar avatar md5 email tile openstreetmap cookie banner solo tecnici csp informativa UX-04 UX-09 DEC-69 CMT-022"
related:
  - ./dcp-445-guardia-del-cablaggio-del-banner-cookie.story.md
  - ./dcp-136-cookie-inventario-informazione-e-guardia-sui-cookie-impostati.story.md
  - ./dcp-136a-cookie-banner-stato-reale-audit-visivo.story.md
  - ../../../Fixcity/docs/stories/dcp-200-registro-unico-delle-decisioni-aperte.story.md
  - ../../../../Themes/Sixteen/docs/stories/front-office-production-readiness-audit.story.md
issues: ["https://github.com/laraxot/theme_sixteen_fila5/issues/106"]
discussions: ["https://github.com/laraxot/theme_sixteen_fila5/discussions/94", "https://github.com/laraxot/theme_sixteen_fila5/discussions/107"]
---

# DCP-454: terze parti caricate prima del consenso

## Decisione e implementazione (2026-11-17)

Il titolare (Marco) ha chiesto «la scelta migliore, studiando prima». Fonti studiate:

- **LG Muenchen, 3 O 17493/20 (20 gennaio 2022)**: mandare l'IP del visitatore a un terzo senza consenso e' illecito quando il
  terzo non serve (i font si possono ospitare in casa): l'interesse legittimo non regge. Stesso schema per Gravatar.
- **OSMF Tile Usage Policy**: proxy con cache ammesso (sconsigliato ma regolato): User-Agent con contatto, Referer inoltrato,
  Cache-Control/Expires rispettati e almeno 7 giorni, richieste condizionali, nessun pre-scaricamento, attribuzione visibile.
- **OSMF Nominatim Usage Policy**: massimo 1 richiesta al secondo per tutta l'app, cache obbligatoria, autocompletamento
  vietato, «set up a proxy and enable caching if at all possible», servizio spegnibile senza aggiornare il software.

Scelta: **nessuna richiesta a terzi dal browser prima della scelta**, senza peggiorare il servizio.

| Terzo | Prima | Ora | Dove |
|---|---|---|---|
| Gravatar | URL con md5 dell'email in testata e commenti | iniziali (o foto del profilo); interruttore `comments.gravatar.enabled`, spento per Fixcity, acceso di default per gli altri progetti | `Modules/Comment` (CommentConfigData, InteractsWithComments), `config/local/fixcity/comments.php` |
| Tile OSM | `{a,b,c}.tile.openstreetmap.org` dal browser | `/api/geo/tiles/osm/{z}/{x}/{y}.png`, cache su disco, conditional GET | `Modules/Geo` (FetchOsmTileAction, OsmTileController) |
| Nominatim | dal browser, anche mentre si digita (vietato dalla policy) | `/api/geo/nominatim/{search,reverse}`, 1 req/s globale, cache 30 giorni, solo Invio o pulsante | `Modules/Geo` (QueryNominatimAction, NominatimController, map/controls/search.js) |
| Attribuzione | solo «Leaflet» | «© OpenStreetMap contributors» (e Esri, HOT sugli strati scelti) | `Modules/Geo/resources/js/components/map/layers.js` |

Il modulo Geo resta agnostico: le mappe usano il proxy solo se il layout lo dichiara su `<html data-geo-tile-url data-geo-nominatim-url>`
(il tema Sixteen lo fa in `layouts/main`); senza, usano gli indirizzi pubblici. Le rotte stanno in `routes/api.php` di Geo
(gruppo `api`: niente sessione ne' cookie). `GeoServiceProvider` ora registra il proprio RouteServiceProvider: senza
`$module_ns` la base registrava quello di Xot e le rotte di Geo non erano mai state caricate (difetto di fondo da correggere a
parte: con `$module_ns` cambierebbero anche migrazioni, eventi e traduzioni caricati).

Strati della mappa scelti dall'utente (satellitare/topografica Esri, umanitaria OpenStreetMap France): restano diretti, perche'
partono solo per una scelta esplicita; informativa e cookie policy lo dicono.

### Verifica

- Playwright, 13 pagine (anonimo): **0 richieste a domini terzi** prima della scelta (prima: tile OSM su home, elenco, dettaglio).
- Mappa dell'elenco: 16 tile serviti dal proxy (200), attribuzione OSM visibile.
- `Modules/Geo/tests/Feature/OsmProxyTest.php` (11 test): User-Agent con contatto, Referer, cache minima 7 giorni, 304, copia
  scaduta se OSM e' giu', 404 fuori griglia, parametri filtrati, 422/503, 1 richiesta al secondo.
- `Themes/Sixteen/tests/Feature/NoThirdPartyBeforeConsentTest.php`: proxy dichiarato, nessun indirizzo di terzi nell'HTML.
- `Modules/Comment/tests/Feature/FrontOfficeCommentThreadTest.php`: iniziali e nessun gravatar.com con l'interruttore spento.
- Informativa (`config/local/fixcity/lang/*/policy.md`, 4 lingue) e cookie policy (`Modules/Gdpr/lang/cookie-consent/*/texts.php`)
  riscritte: barra, informativa e comportamento dicono la stessa cosa. Tolte anche le righe superate su Google Fonts (font gia'
  ospitati in casa, nessun preconnect) e staticmap.openstreetmap.de (solo in una vista senza rotte).

### Criteri di accettazione

- [x] Decisione presa dal titolare (2026-11-17).
- [x] Guardia: senza scelta nessuna richiesta a gravatar.com e tile.openstreetmap.org (test e misura nel browser).
- [x] Barra cookie e informativa dicono la stessa cosa.
- [x] Misura nel browser a rete tracciata: 0 richieste a domini terzi prima della scelta.

## Storia (analisi del 2026-11-12)

Status allora: **da decidere** (2026-11-12). Fase BMAD: Analysis fatta (audit F, UX-04 e UX-09, 2026-11-11); nessuna modifica di comportamento. Registro: DEC-69 in DCP-200.

## Cosa succede oggi (misurato nell'audit, non rimisurato oggi)

| Servizio | Dove | Cosa parte prima di qualunque scelta del cittadino |
|---|---|---|
| `www.gravatar.com` | blog, dettaglio del ticket, header da loggato | richiesta dell'avatar: nell'HTML c'è l'**hash md5 dell'email**; il servizio terzo riceve anche IP e user agent |
| `*.tile.openstreetmap.org` | mappe | richiesta dei tile: il servizio terzo riceve IP e user agent |

La barra cookie dice «solo cookie tecnici» senza citare questi terzi. Non sono cookie: sono richieste a un servizio esterno che avvengono comunque.

## Perché non l'ho cambiato

Cambia il **comportamento** (l'avatar o la mappa non compaiono finché il cittadino non sceglie) e la **base giuridica** dichiarata nell'informativa. È una scelta del titolare con il DPO,
non del tema. Il lavoro tecnico di entrambe le strade è piccolo; sbagliare la scelta no.

## Opzioni (DEC-69)

| Opzione | Cosa cambia | Costo |
|---|---|---|
| (a) **Non chiamare il terzo finché non c'è una scelta**: iniziali locali al posto di Gravatar, segnaposto o mappa locale al posto dei tile OSM, il servizio parte dopo il consenso | nessun dato al terzo senza scelta; l'utente vede meno finché non sceglie | la mappa è una funzione centrale del wizard (passo 2): serve un'alternativa locale o un consenso esplicito per la mappa |
| (b) **Proxy lato server** per l'avatar (Gravatar visto dal solo server) | l'IP del cittadino non arriva a Gravatar, ma l'hash dell'email sì | un servizio da mantenere; cache; l'hash resta un dato personale |
| (c) **Lasciare e dichiarare**: citare Gravatar e OpenStreetMap nell'informativa, nel registro dei cookie/terze parti (DCP-136) e nella CSP | nessun cambio di funzione | dipende dalla base giuridica scelta: se è il consenso, (c) non basta |

La sessione che ha documentato l'audit indica nel rapporto «decisione CMT-022: proxy lato server o iniziali locali, oppure citarlo nell'informativa e nella CSP». Proposta di lavoro, non decisione:
(a) per Gravatar (le iniziali locali sono un costo trascurabile), (c) o consenso esplicito per i tile della mappa finché non c'è un'alternativa locale.

## Cosa NON faccio

Non tocco `GdprServiceProvider`, il banner (DCP-445) né i template che richiamano i servizi; non cambio la CSP; non modifico l'informativa.

## Criteri di accettazione (quando si decide)

- [ ] DEC-69 decisa dal titolare e dal DPO nel registro DCP-200.
- [ ] Una guardia che prova che, senza scelta, nessuna richiesta parte verso `gravatar.com` e `tile.openstreetmap.org` (o che, se si sceglie (c), l'informativa e la CSP li citano).
- [ ] La barra cookie e l'informativa dicono la stessa cosa dei terzi.
- [ ] Misura nel browser a rete tracciata: 0 richieste a domini terzi prima della scelta (se si sceglie (a)).

## Verifica

Nessuna correzione in questa story. Il comportamento descritto è quello dell'audit del 2026-11-11 e va riprodotto prima di decidere.
