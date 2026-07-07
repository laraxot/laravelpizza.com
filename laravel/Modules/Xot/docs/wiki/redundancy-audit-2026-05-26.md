---
title: "audit ridondanza monorepo 2026-05-26"
module: Xot
type: audit
status: approved
tags: [redundancy, audit, ptvx]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - concepts/code-redundancy-philosophy.md
  - concepts/redundancy-catalog.md
  - redundancy-report.md
  - redundancy-audit-2026-05-21.md
---

# Audit ridondanza — 2026-05-26 (PTVX)

> Scan read-only su `laravel/Modules/*`, `laravel/Themes/*`. Filosofia: [code-redundancy-philosophy.md](concepts/code-redundancy-philosophy.md).

## Riepilogo esecutivo

| Severità | N. | Esempi |
|----------|---:|--------|
| **P0 — runtime / autoload** | 9 | `.php.up` Notify; doppio `LoginWidget`; Passport/Socialite doppio albero |
| **P1 — architettura** | 12 | Composer spurii; temi One/Zero; template Notify; trait UI duplicati |
| **P2 — docs / rumore** | 8+ | Decine di md Filament migrazione; index duplicati Notify |

## P0 — intervento immediato

| ID | Finding | Path | Azione |
|----|---------|------|--------|
| P0-1 | Backup Filament obsoleti | `Modules/Notify/app/**/*.php.up` (9 file) | **delete** dopo diff con `.php` canonico |
| P0-2 | Doppio LoginWidget | `User/.../Widgets/LoginWidget.php` vs `.../Auth/LoginWidget.php` | **merge** — runtime: `Auth\LoginWidget` (`UserServiceProvider`) |
| P0-3 | OAuth resource duplicate | `User/Resources/OauthPersonalAccessClientResource.php` + `Clusters/Passport/Resources/...` | **delete** copia fuori cluster |
| P0-4 | Socialite duplicate | `SsoProviderResource`, `SocialProviderResource`, `SocialiteUserResource` (×2 alberi) | **delete** root `Resources/` |
| P0-5 | composer.json spurio | `User/resources/views/composer.json` | **delete/move** |
| P0-6 | composer.json spurio | `Xot/app/Services/composer.json` | **delete** |

## P1 — architettura e confini

| ID | Finding | Owner doc |
|----|---------|-----------|
| P1-1 | `MailTemplate` vs `NotificationTemplate` | [Notify](../Notify/docs/wiki/concepts/code-redundancy-notify.md) |
| P1-2 | `TableLayoutTrait` ×2 namespace | [UI](../UI/docs/wiki/concepts/code-redundancy-ui.md) |
| P1-3 | Login blade One ≈ Zero | [One](../../../Themes/One/docs/wiki/concepts/code-redundancy-theme.md) |
| P1-4 | `Theme_One` vs `One` | Themes — perplessità #2 in filosofia |
| P1-5 | `UserResource` omonimo Ptv/User | Documentare namespace |
| P1-6 | `CriteriOptionResource` ×3 | Ptv — valutare base condivisa |
| P1-7 | ColumnBuilder ×2 in Xot | [redundancy-report.md](redundancy-report.md) §1 |
| P1-8 | XotBaseRelationManager ×2 path | [redundancy-report.md](redundancy-report.md) §5 |

## P2 — documentazione

- Notify: `filament-pages.md` / `filament_pages.md`, `index.md` / `INDEX.md`, cluster migrazione Filament.
- User: 40+ file passport-cluster*.
- Azione: [module-docs-deduplication.md](../../../../../docs/wiki/how-to/module-docs-deduplication.md), stub on-demand.

## Schede owner (moduli / temi)

| Owner | Scheda |
|-------|--------|
| Notify | [code-redundancy-notify.md](../../Notify/docs/wiki/concepts/code-redundancy-notify.md) |
| User | [code-redundancy-user.md](../../User/docs/wiki/concepts/code-redundancy-user.md) |
| UI | [code-redundancy-ui.md](../../UI/docs/wiki/concepts/code-redundancy-ui.md) |
| Theme One | [code-redundancy-theme.md](../../../Themes/One/docs/wiki/concepts/code-redundancy-theme.md) |
| Theme Zero | [code-redundancy-theme.md](../../../Themes/Zero/docs/wiki/concepts/code-redundancy-theme.md) |

## Ordine di esecuzione consigliato

1. Delete tutti `Notify/**/*.php.up`
2. User: consolidare Auth widgets + cluster Passport/Socialite
3. Delete composer.json spurii
4. Spike P1 Notify template / Ptv CriteriOption
5. Batch dedup docs (script `dedup_module_docs.py`)

## Storico audit

- [2026-05-21](redundancy-audit-2026-05-21.md) — scan precedente (Fixcity tracker)
