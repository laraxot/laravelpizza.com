---
title: "Epic e story — Xot"
type: epics
status: review
updated: 2026-11-16
module: Xot
qmd: "epic story BMAD Xot audit P0 P1 policy"
---

# Epic e story — Xot

Scopo del modulo: kernel Laraxot: classi base, Actions riusabili, contratti, guardie di test ([purpose.md](./purpose.md)).

## Epic da audit 2026-11-16

Ogni story nasce da un finding di [audits/xot-audit.md](./audits/xot-audit.md); prima del fix:
lock (`bashscripts/lock/lock.sh`), Pest rosso, PHPStan max, poi `unlock.sh`. Nessun `migrate:fresh`, solo migrate additivo.

### Epic XOT-A — Confini del core (P1)

| Story (da creare) | Cosa | Criterio di accettazione |
|---|---|---|
| `xot-core-no-feature-imports` | Mappa dei 55 `use` verso User/UI/Tenant/Lang/Cms/Notify/Media e rimozione per cluster | il numero di `use Modules\<feature>` in `Xot/app` (oggi 55) decresce; `module.json` allineato |
| `xot-services-to-actions` | `RouteService` e `ModuleCommandHandler` → Action o delete | `find Xot/app/Services` vuoto; PHPStan 0 |

### Epic XOT-B — Igiene e superfici latenti (P2)

| Story (da creare) | Cosa | Criterio di accettazione |
|---|---|---|
| `xot-policy-before-no-once` | Rimuovere `once()` da `XotBasePolicy::before()` + test per ruolo | Pest `XotBasePolicy` (super-admin, `{modulo}::admin`, estraneo) |
| `xot-remove-unused-traits` | Eliminare 9 trait `trait.unused` | `rg "@phpstan-ignore trait.unused" Xot/app` = 1 (EnumInteger) |
| `xot-artisan-act-guard-or-delete` | Cancellare o proteggere `HandleArtisanActRequestAction` (`SuperAdminOnlyTrait` + `Rule::in`) | nessuna concatenazione di input in comando |
| `xot-actions-over-services-doc-link` | Correggere il link morto `Modules/Xot/docs/actions-over-services.md` citato da `AGENTS.md` | link valido |

