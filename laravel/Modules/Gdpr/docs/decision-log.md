---
type: decision-log
title: "Decision Log — Gdpr"
links: {github_issue: #XXX, discussion: #XXX}
---
# Decision Log — Gdpr

## Decisions

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `27eb453`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `27eb453` (07/10 06:36), l'ultimo commit prima degli eventi del 07/10 (copia vecchia fusa e re-import).
- **Over**: Tenere le versioni portate dagli eventi, o il commit `949342f` di Marco dell'08/10 sui 2 test che tocca.
- **Because**: Ogni contenuto sovrascritto e' stato verificato come gia' esistente prima del 07/10 (139 su 139).
  - 139 toccati solo dagli eventi: contenuto da `27eb453`.
  - 2 toccati da `949342f` (`GdprBusinessLogicTest`, `RegisterWidgetTest`): contenuto da `27eb453`. Il commit era solo la rimozione meccanica di variabili "inutilizzate" fatta sulla copia vecchia, con istruzioni unite sulla stessa riga e un'asserzione sul consenso ai termini tolta.
- **Verifica**: `php -l` pulito; PHPStan su `Modules/Gdpr` senza errori. Pest prima/dopo a blocchi con lo stesso `vendor/`, confronto JUnit: 0 peggiorati, 68 migliorati (prima quasi tutti i test Gdpr fallivano).

## Open Questions

