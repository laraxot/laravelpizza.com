---
title: "Filament blueprint: Services to Queueable Actions"
type: filament-blueprint
status: active
module: Xot
created: 2026-10-20
updated: 2026-10-20
tags: [filament, blueprint, bmad, actions, queueable-actions]
qmd: "filament blueprint action service migration execute dispatch policy tenant form table"
related:
  - ./services-to-queueable-actions-architecture.md
  - ./services-to-queueable-actions-objective.md
---

# Contratto Filament

La UI non contiene la logica dei Services migrati (layer **eliminato**, census
sera 2026-10-20: zero dir `Modules/*/app/Services`). Resource, Page, Widget e Blade
del tema raccolgono input, autorizzano, invocano l'Action (o ricevono **props**
pre-calcolate dal Folio/orchestratore) e presentano lo stato. Nessun percorso UI
può reintrodurre `app/Services`, facciate `*Service` o `@inject` di classi Service
fantasma (es. modulo assente): solo Actions tipizzate o dati già risolti a monte.

## Regole

- usare `XotBaseResource`, `XotBaseWidget` e pagine Xot;
- schema Form/Table/Infolist dedicato quando il flusso cresce;
- niente `->label()`, `->placeholder()` o business logic hardcoded;
- policy e tenant scope prima dell'invocazione;
- **sync vs queue (regola esplicita):** `SomeAction::make()->execute(...)` quando
  la UI Filament/Livewire deve mostrare esito, errori di validazione o dati subito
  (select Geo, tenant config, review AI); `SomeAction::dispatch(...)` (o equivalente
  Spatie) solo quando l'operazione puo' completarsi in worker (notify, media, job
  lunghi) e la UI gestisce stato `queued` / polling / notifica: **mai** dispatch
  per sostituire un Service sincrono che la tabella o il form attendono in-request;
- non confondere «Action queueable» con «sempre async»: la stessa classe supporta
  entrambe le modalita'; la scelta e' del caller UI, non del suffisso legacy `Service`;
- notificare `queued`, `completed` e `failed` senza bloccare il worker UI;
- non passare componenti Filament, Request o Closure dentro una Action dispatchata.
- dopo ogni migrazione verificare che `app/Services/` e `app/Support/` siano assenti (anche nested);
- adapter/registry usati dal Widget vivono in `Adapters`/`Infrastructure`, mai in `Services`/`Support`;
- costanti config (URL, cache) in `Infrastructure\Config`, non Action faux;
- Blade/temi: nessun Services/Support via `app()`; dati da props CMS o Action.

## Mappa UI → Action

| UI | Input | Action | Modalità |
|---|---|---|---|
| Filament AI proposal | dati redatti + policy | classify/suggest/confirm Action | sync review, queue provider |
| Filament Geo selectors | codici regione/provincia | `LoadGeoHierarchyAction` / GetRegions/Cities | sync (mai `Geo*Service`) |
| Filament Notify | template, recipient, channel | Send notification/SMS Action | queue con idempotenza |
| Filament Media | media + operation | Subtitle/convert Action | queue |
| Filament Tenant | config value | Tenant config Action | sync, transazione controllata |

## Stato asincrono

Ogni Action dispatchata deve definire:

- identificatore/idempotency key;
- payload minimo serializzabile;
- comportamento retry e failed job;
- visibilità tenant/policy nel worker;
- evento o polling per aggiornare la UI;
- test del percorso sincrono e del wrapper Spatie `ActionJob`.

## Definition of Done Filament

- [ ] Resource/Page/Widget estende una base Xot;
- [ ] schema e traduzioni rispettano il modulo owner;
- [ ] Action invocata senza logica duplicata nella UI;
- [ ] policy/tenant verificati;
- [ ] sync/queue scelto esplicitamente;
- [ ] test Livewire/Filament e PHPStan passano;
- [ ] story e decision log aggiornati.
- [ ] `find Modules/<Modulo>/app -type d -name Services` non restituisce risultati.

## Deep audit

Vedi [support-deep-audit.md](./support-deep-audit.md) (Bag rename, Infrastructure validation, debito ShieldUtils).
