---
title: Elimina Services: converte tutto in QueueableActions
status: completed
module: Geo (5 Services → Actions esistenti, dir rimossa), Xot (.gitignore + .bak rimossi), AI/Job/Lang/Media/Notify/UI (vuoti confermati)
initiative: kp-5ecdb68985424ad593740489df567c2d
scope: "chiudere ogni directory `app/Services/`; verificare semanticamente i cinque Geo Service presenti nello staging; riusare le QueueableActions esistenti e crearne di nuove solo se manca un use-case successore. Perché: il confine deve esprimere use-case eseguibili con `execute()`, senza duplicare adapter, resolver o codice morto. `laravel/phpstan.neon` è l'unica configurazione autorizzata e non viene modificata."
type: note
updated: 2026-10-20
tags: [docs, xot, phpstan-fix-plan]
qmd: "elimina services xot"
---

## Perché (scopo): il senso dell'azione
- `Services/` = facades statiche con stato locale (`Config::set`, `Request::segment`, variabili globali).
- `QueueableActions/` = classi serializzabili, stateless, eseguibili sia sincrono (`execute()`) che asincrono (`dispatch()`), compatibili con `DatabaseQueue`, `Redis`, `SQS`.
- Regola inviolabile: ogni servizio deve diventare un'azione con `execute()` pubblico; se contiene stato interno (`Cache`, `DB`), deve essere passato esplicitamente come parametro o letto nel costruttore.

## Brainstorming: decisioni chiave
1. Verificare i cinque Geo Service presenti nello staging contro le Actions già presenti e i caller runtime.
2. Non creare `BaseGeoAction` o wrapper equivalenti: gli adapter HTTP devono stare in `Adapters`/`Infrastructure` se ancora necessari.
3. Verificare che dati geografici e matematica abbiano Actions specifiche già esistenti; aggiungerne una solo con test di comportamento.
4. Verificare provider/config/Facade e test prima del commit della cancellazione.
5. Rimuovere la directory Geo vuota e qualunque ultimo detrito `.bak`/`.gitkeep`.
6. Aggiungere/verificare il ratchet directory-level e chiudere con PHPStan usando `laravel/phpstan.neon`.
