---
title: Planning: zero cartelle app/Services (Spatie Queueable Actions)
type: bmad-planning
status: done
module: Xot
track: bmad-method
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, planning, services, queueable-action, filament-blueprint, ratchet]
qmd: "planning zero cartelle app services spatie queueable actions delete-or-retarget noservicestest filament"
related:
  - ./brainstorming-services-to-actions-wave.md
  - ./services-to-queueable-actions-brainstorming.md
  - ./services-to-queueable-actions-architecture.md
  - ./services-to-queueable-actions-census.md
  - ./services-to-queueable-actions-filament-blueprint.md
  - ./services-to-queueable-actions-objective.md
  - ./filament-blueprint.md
  - ./decision-log.md
  - ../stories/services-to-actions-global-wave.story.md
  - ../../../../../bashscripts/ai/wiki/rules/no-services-rule.md
  - ../../../../../bashscripts/docs/prompts/25-services-to-actions.md
---

# Obiettivo

**Zero** cartelle `laravel/Modules/<modulo>/app/Services` (e analoghi sotto
`Themes/*/app|src/Services`, `laravel/app/Services`). Ogni use-case applicativo
vive in una **Spatie Queueable Action** con `execute()`.

Non e' una migrazione di massa in corso: sul disco vivo (2026-10-20 sera) il
perimetro e' gia' **verde**. Il planning serve a **tenere** lo zero e a
prescrivere la procedura se un merge riesuma path.

# Perche' (senso / religione)

| Problema Service | Risposta Action |
|------------------|-----------------|
| God-class multi-metodo | Un caso d'uso = una classe |
| Coda non uniforme | Stesso `execute()` sync o `->onQueue()` |
| Confini di dominio opachi | Nome verbale + parametri tipizzati |
| PHPStan / test fragili | Contract stretto, no bagaglio di dipendenze |
| Cartella invita debito | Assenza della directory = segnale CI |

Adapter, translator, registry, stream HTTP **non** sono use-case: vanno in
`Adapters/`, `Contracts/`, `Support/`, `Infrastructure/`: **mai** sotto
`app/Services/`.

Filament: Resource / Page / Widget chiamano Actions, mai Service
([filament-blueprint](./filament-blueprint.md),
[services-to-queueable-actions-filament-blueprint](./services-to-queueable-actions-filament-blueprint.md)).

# Verdetto misurato (sera 2026-10-20)

| Gate | Esito |
|------|-------|
| `find Modules -type d -path '*/app/Services'` | **0** |
| `find Themes -type d -path '*/app/Services'` | **0** |
| `use Modules\…\Services\` in prod PHP | **0** |
| `*Action.php` sotto `Modules/*/app/Actions` | **~770** |
| `NoServicesTest` (3 asserzioni) | **PASS** |
| PHPStan `analyse Modules` | **OK No errors** (remeasure sessione) |

Fonte dettagli: [census](./services-to-queueable-actions-census.md).
Brainstorm: [brainstorming-services-to-actions-wave.md](./brainstorming-services-to-actions-wave.md).

# Piano operativo (sticky)

## Stato attuale = maintain

1. Non creare nuove Actions «di conversione» se il Service non esiste sul disco.
2. Non lasciare cartelle `app/Services` vuote «per dopo».
3. Allowlist ratchet = `[]` (nessuna eccezione modulo).

## Se un merge riesuma Services (boy scout)

1. `rg` Action successore (`Sostituisce…` / nome verbale) + caller `use …\Services\`.
2. Retarget caller (Facade / composer / test) verso Action.
3. **DELETE** Service + `rmdir` cartella: non relocate sotto altro nome Service.
4. Confermare `NoServicesTest` + `find` dirs = 0.
5. PHPStan perimetro se il call graph e' cambiato (`--memory-limit=2G` se RAM bassa).

Procedura lunga: [prompt 25](../../../../../bashscripts/docs/prompts/25-services-to-actions.md) +
[architecture](./services-to-queueable-actions-architecture.md).

## Anti-pattern vietati

- Convertire senza cercare Action gemella → duplicati.
- Shim Service a lungo termine verso Action.
- Logica di dominio in Filament `afterStateUpdated`.
- Accodare Action con `exit()` / handle aperti.
- Confondere `RouteServiceProvider` / `TermsOfService` Livewire con layer Services.
- Dichiarare done senza rileggere il disco.

# Deliverable BMAD

| Artefatto | Ruolo |
|-----------|--------|
| Brainstorm wave | Perche' + 5 Whys + SCAMPER + SWOT |
| Architecture + objective | Contratto Action / adapter |
| Census | Fatti misurati (addendum sera prevale) |
| Filament blueprint | Canary UI → Actions |
| Story globale | Acceptance + delete-again |
| **Questo planning** | Piano maintain + procedura riesumazione |
| `NoServicesTest` | Ratchet CI permanente |

# Done when

- [x] Zero dirs `app/Services` (Modules + Themes + `laravel/app`)
- [x] Zero import produzione `…\Services\`
- [x] Ratchet Pest verde
- [x] Docs BMAD allineati (brainstorm + census + story + decision-log)
- [ ] Boy scout permanente su ogni merge (non chiudibile: standing order)

# Story

[services-to-actions-global-wave.story.md](../stories/services-to-actions-global-wave.story.md)
