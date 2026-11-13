---
id: dcp-445
title: "DCP-445: guardia del cablaggio del banner cookie dopo il provider riportato indietro da un mirror"
type: story
status: done
module: Gdpr
created: 2026-11-12
updated: 2026-11-12
tags: [bmad, story, gdpr, cookie, banner, provider, mirror, guardia]
qmd: "cookie banner GdprServiceProvider mirror 78c4ef9 prependNamespace InjectCookieBanner CookieConsentWiringTest chiavi grezze cookie-policy"
related:
  - ./dcp-136a-cookie-banner-stato-reale-audit-visivo.story.md
  - ./dcp-136-cookie-inventario-informazione-e-guardia-sui-cookie-impostati.story.md
  - ./cookiebar-bootstrap-italia-integration.story.md
  - ../cookie-banner.md
  - ../../../../Themes/Sixteen/docs/stories/front-office-production-readiness-audit.story.md
issues: []
discussions: ["https://github.com/laraxot/theme_sixteen_fila5/discussions/94"]
---

# DCP-445: guardia del cablaggio del banner cookie

Status: **done** (chiusa il 2026-11-11 nell'audit L-09; documentata qui il 2026-11-12). Confronto con le altre decisioni dell'audit: discussion
[#94](https://github.com/laraxot/theme_sixteen_fila5/discussions/94), riga R-1. Dettaglio tecnico e trappola: `docs/cookie-banner.md`, trappola 7.

## Richiesta

Utente, 2026-11-11: controllare integralmente il front office, da loggato e da non loggato, per andare in produzione; correggere ciò che non si vede
come dovrebbe.

## Misurato (prima)

Il commit «.» `78c4ef9` del repo del modulo (un mirror dell'altra macchina) ha riportato `GdprServiceProvider` a una versione vecchia: senza
`app->booted` con `addLines`, senza `prependNamespace` della vista e senza `InjectCookieBanner` nel gruppo `web`. Risultato:

- `/cookie-policy` con 20 chiavi grezze (`cookie-consent::texts.policy_title` e simili);
- **nessun banner su nessuna pagina**;
- le terze parti (tile OSM, Gravatar) caricate prima di qualunque scelta del cittadino;
- i test del banner restavano verdi, perché non avviavano il provider.

## Soluzione

| Dove | Cosa |
|---|---|
| `Modules/Gdpr/app/Providers/GdprServiceProvider.php` | ripristinato **in avanti** da `78c4ef9^`, insieme a `lang/cookie-consent/{it,en,de,es}/texts.php` (mai `checkout` né `reset`) |
| `Modules/Gdpr/tests/Unit/Providers/CookieConsentWiringTest.php` | guardia nuova, 3 test, che prova il **cablaggio** e non il codice del provider |
| `Modules/Gdpr/docs/cookie-banner.md` | trappola 7 e riga di guardia |

I tre test della guardia:

1. ogni riga di `texts.php` si risolve via `trans()` nelle quattro lingue servite (it, en, de, es), non nella chiave grezza; il test richiede più di 100
   righe controllate, così non passa a vuoto;
2. la vista del banner del modulo ha la precedenza su quella del pacchetto (`cookie-consent::index` si risolve sotto `Modules/Gdpr/resources/views/cookie-consent/`);
3. `InjectCookieBanner` è registrato nel gruppo middleware `web`.

## Criteri di accettazione

- [x] `/cookie-policy` mostra i testi, non le chiavi, in it, en, de, es.
- [x] Il banner è iniettato nelle pagine del gruppo `web`.
- [x] Una guardia diventa rossa se il provider torna alla versione vecchia (documentato in `cookie-banner.md`).
- [x] La guardia dichiara `uses(TestCase::class)`: Pest legge solo `laravel/tests/Pest.php`, quindi senza `uses()` il test girerebbe su un container vuoto.

## Verifica

Si lancia dalla radice del monorepo:

```
bashscripts/tools/pest-scratch-db.sh Modules/Gdpr/tests/Unit/Providers/CookieConsentWiringTest.php
```

Esito del 2026-11-12: 3 test passati, 9 asserzioni, 1,6 s (DB di prova, nessuna scrittura sul DB di sviluppo). La prova al contrario (guardia rossa con il
provider vecchio) è quella registrata in `docs/cookie-banner.md` il 2026-11-11: oggi non l'ho rifatta.

## Non coperto

- Le terze parti prima del consenso (avatar Gravatar e tile OpenStreetMap) non sono cambiate: cambiano comportamento e base giuridica e serve una
  decisione. Vedi DCP-454 (nel modulo Gdpr, da decidere).
- La guardia prova il cablaggio, non l'aspetto del banner: per la resa visiva vale ancora DCP-136a.

## Lezione

Un mirror può riportare indietro un file senza che nessun test lo noti, quando i test esistenti non avviano quel file. Un test sul **cablaggio** (cosa
risolve il container, cosa c'è nel gruppo di middleware) è l'unico che si accorge di un provider sostituito. Stessa famiglia di DCP-447 (Sixteen).
