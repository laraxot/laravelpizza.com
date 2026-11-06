---
title: "BMAD objective: Services to Queueable Actions"
type: bmad-brainstorm-objective
status: active
module: Xot
track: bmad-method
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, services, queueable-actions, second-brain, filament]
qmd: "services queueable actions classificazione use case adapters providers filament blueprint"
related:
  - ./services-to-queueable-actions-brainstorming.md
  - ./services-to-queueable-actions-architecture.md
  - ./filament-blueprint.md
  - ./decision-log.md
---

# Obiettivo

Eliminare completamente `laravel/Modules/<modulo>/app/Services/`: ogni use-case
applicativo deve vivere in una `Spatie\QueueableAction\QueueableAction` dentro
`app/Actions`, mantenendo invariati i contratti dei caller, il comportamento di
dominio, la persistenza, le policy e le integrazioni. Anche adapter, resolver,
translator e client tecnici devono essere ricollocati in `Adapters`, `Contracts`,
`Support` o `Infrastructure`; la cartella `Services/` non è un'eccezione.

## Domanda guida

Quali classi sotto `app/Services` rappresentano davvero use-case applicativi e
quali sono invece adapter, registry, translator, strategia o infrastruttura che
devono restare nel loro confine?

## Vincoli

- nessuna migrazione meccanica per nome;
- un use-case = una Action con `execute(...)`;
- eliminare wrapper morti o duplicati invece di ricrearli;
- nessuna cartella `app/Services` deve restare, nemmeno per adapter/framework;
- Filament usa esclusivamente wrapper `XotBase*` e delega la logica alle Actions;
- ogni wave ha ownership disgiunta, story BMAD, verifica PHPStan/Pest e nota second brain;
- nessuna modifica a `phpstan.neon`, baseline o contratti pubblici senza evidenza.

## Output attesi

1. inventario classificato di ogni classe Service;
2. decisioni architetturali condivise;
3. blueprint Filament per i flussi amministrativi coinvolti;
4. stories per modulo con caller, test e gate;
5. migrazione incrementale e verificabile.

## Inventario verificato (ripasso disco vivo)

Lo snapshot del 2026-10-20 mostra ancora le cartelle `Services/` per Geo, Notify
e Xot: il precedente claim di zero servizi era stale. Geo contiene cinque classi
(`BaseGeoService`, `GeoDataService`, `GeoDataValidator`, `GeoService`,
`GoogleMapsService`) già coperte da Actions omonime/affini; Notify contiene un
`.gitkeep`; Xot contiene `RouteService.php.bak`. Il piano corrente deve chiudere
anche le directory vuote e i detriti non-PHP. Dettaglio storico:
[services-to-actions-global-wave.story.md](../stories/services-to-actions-global-wave.story.md).

Wave residua: migrare/retargetare Geo, rimuovere i detriti e aggiungere il ratchet
anti-merge. Non dichiarare completata la wave finché `find Modules -type d -path
'*/app/Services'` è vuoto.
