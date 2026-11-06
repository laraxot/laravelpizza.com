---
title: "Fleet: Services to Queueable Actions"
type: story
status: in-progress
priority: high
module: Xot
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, services, queueable-actions, swarm, filament]
qmd: "fleet services queueable actions migration story waves"
related:
  - ../services-to-queueable-actions-objective.md
  - ../services-to-queueable-actions-brainstorming.md
  - ../services-to-queueable-actions-architecture.md
  - ../services-to-queueable-actions-filament-blueprint.md
---

# Obiettivo

Eliminare la duplicazione tra Services e Actions e portare ogni use-case
applicativo a Queueable Action, senza trasformare adapter o framework services in
wrapper artificiali.

## Task pianificati: wave BMAD/Blueprint

- [x] W0: census filesystem, staging, caller statici e Actions candidate;
- [ ] W1A (parallela, scope Geo/data): verificare GeoDataService e GeoDataValidator,
  successori e test di comportamento;
- [ ] W1B (parallela, scope Geo/math): verificare GeoService e Actions di distanza,
  poligoni e SQL;
- [ ] W1C (parallela, scope Geo/provider): verificare BaseGeoService e
  GoogleMapsService, retry/cache/rate-limit e payload serializzabile;
- [ ] W2 (seriale): retarget caller, provider, config, facade e test; rimuovere i
  cinque Service solo dopo il gate W1;
- [ ] W3 (parallela, cleanup): eliminare detriti e directory `app/Services` vuote,
  aggiornare docs owner e verificare Themes senza ampliare lo scope;
- [ ] W4 (seriale): ratchet directory-level, PHPStan con `laravel/phpstan.neon`,
  test mirati, autoload e audit link.

### Ownership e vincoli di parallelismo

W1A/W1B/W1C sono indipendenti solo finché non modificano gli stessi caller o
Actions condivise. Ogni agente deve produrre una matrice `Service → Action →
caller → test`; il coordinatore integra e risolve i conflitti. Non si randomizzano
le dipendenze: l'ordine casuale è ammesso solo dentro questa wave disgiunta.

### Filament Blueprint gate

Resource, Page e Widget raccolgono input e delegano ad `execute()`. Non ricevono
Services, Request, Closure o componenti Filament in payload dispatchati; gli
adapter tecnici restano in `Adapters`/`Infrastructure`.

## Criterio di completamento

Ogni file ha una decisione verificata (`migrate`, `split`, `retire`, `retain as
adapter`) e nessun Service viene rimosso senza prova di zero caller statici e
dinamici. Nessuna nuova Action viene creata se esiste già l'equivalente. Il gate
finale richiede zero directory `Modules/*/app/Services`, zero file sotto quel
percorso e PHPStan eseguito con `laravel/phpstan.neon` senza crearne altri.
