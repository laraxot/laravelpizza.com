---
title: "Contratto PageSlugMiddleware"
type: middleware-contract
contract: Modules\\Cms\\Http\\Middleware\\PageSlugMiddleware
owner: Cms
status: accepted
updated: 2026-11-23
---

# Contratto `PageSlugMiddleware`

## Input

Una richiesta Folio con i parametri di rotta (`container0`, `slug0`,
`container1`) e lo slug CMS eventualmente presente nel JSON della pagina.

## Output

La richiesta prosegue verso la pagina Folio dopo l'esecuzione dei middleware
dichiarati dal contenuto CMS, oppure riceve un 404 per le route legacy di profilo
non risolvibili. I redirect di dominio sono middleware del modulo owner, non
responsabilità del Cms.

## Invarianti

- I middleware CMS sono validati tramite `ValidatePageMiddlewareAction`.
- Un profilo, utente o users non risolvibile non diventa una pagina pubblica.
- I parametri Folio non vengono ricalcolati nella Blade.
- I middleware dichiarati dal JSON restano estendibili senza importare moduli
  applicativi nel Cms.
- I moduli applicativi registrano i propri middleware nell'allowlist tramite i
  loro service provider; il Cms non contiene riferimenti a Ticket o Fixcity.

## Effetti collaterali

- Esegue i middleware dichiarati dal JSON CMS.
- Può produrre una risposta HTTP 404 prima del rendering.
- Registra errori di configurazione CMS come 503 secondo il comportamento
  fail-closed esistente.

## Errori

- 404 per una route legacy di profilo senza modello autorizzato.
- 503 se lo slug o la catena middleware CMS non è determinabile.
- Errore di risoluzione se un middleware dichiarato non è consentito o risolvibile.

## Non fa

- Non renderizza Blade o componenti visuali.
- Non calcola titoli, meta description o layout.
- Non contiene markup, query di presentazione o branch speciali del tema.

## Verifica

- `Modules/Cms/tests/Feature/ResolvePageModelExposureTest.php`
- `Modules/Cms/tests/Unit/Http/Middleware/PageSlugMiddlewareFailClosedTest.php`
