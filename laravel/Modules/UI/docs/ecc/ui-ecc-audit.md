---
title: "ECC audit operativo — UI"
type: ecc-audit
status: review
updated: 2026-11-16
module: UI
qmd: "ECC audit UI verification security testing laravel security-review clean-code laravel-verification verification-loop tdd-workflow"
---

# ECC audit operativo — UI

## Contratto PTVX

ECC non sostituisce `AGENTS.md`/BMAD: ogni finding diventa story in [epics.md](../bmad/epics.md), con lock,
fix alla causa, PHPStan + Pest, aggiornamento docs/QMD. Le abilità ECC sono scelte on-demand
(`ecc-ptvx-workflow`); qui è registrato **l'esito**, non la checklist vuota.

## Esito per skill (2026-11-16)

| Skill ECC | Stato | Evidenza |
|---|---|---|
| `clean-code` (DRY/KISS, Actions-over-Services) | parziale | `ComponentService` vuoto, `PersonForm` senza consumatori, 3 file `.disabled/.fila3` |
| `security-review` (policy, accesso pannello, dati) | aperto | P2-UI4: `UiBasePolicy` senza abilità (nessuna Resource oggi → nessuna esposizione) |
| `laravel-verification` (route, policy, migration additive) | ok | 3 migration additive (`2026_07_15_*`), nessun `migrate:fresh` |
| `verification-loop` (PHPStan max + Pest) | PHPStan ok, Pest skip | PHPStan 0 errori; Pest: skip documentato: DB di test `10.100.200.53:3306` irraggiungibile (TCP chiuso) e `Xot/tests/Support/TestDatabaseGuard.php:63` rifiuta DB non `*_test`; i test con DB restano appesi al connect MySQL (timeout 150 s osservato). Nessun test contro il MySQL locale (dati sacri). |
| `tdd-workflow` (regressione sui P0) | aperto | regressione da scrivere su `UiBasePolicy::before` (utente estraneo → null) |
| `documentation-sync` | fatto | pack aggiornato: [audit](../bmad/audits/ui-audit.md), [epics](../bmad/epics.md), [decision-log](../bmad/decision-log.md) |
| `context-engineering` | fatto | source-first; il perché in [purpose](../bmad/purpose.md) |

## Input misurato (2026-11-16)

| Voce | N |
|---|---:|
| PHP `app/` | 133 |
| Test PHP | 87 |
| Models | 4 |
| Policy | 1 |
| Resource | 0 |
| Widget | 12 |
| Actions | 6 in `app/Actions/*.php` (11 file PHP con `Action` nel percorso) |
| Services | 5 |
| Migration | 3 |
| Lang IT | 123 |
| `->label('..')` letterali | 9 |
| `@phpstan-ignore` | 48 |

## Finding da trasformare in story

- **P1-UI1** Dashboard `ui::admin` con dati inventati ("Unique views 192.1k", `TestWidget` ×4, `qid` 5/7/9) — `app/Filament/Pages/Dashboard.php:28-45`
- **P1-UI2** 3 test su modelli assenti (Asset/Component/Theme) con 48 `@phpstan-ignore`: copertura fantasma — `tests/Unit/Models/AssetModelTest.php:6-30`
- **P2-UI3** `PersonForm` con label inglesi letterali e nessun consumatore — `app/Filament/Components/Schema/PersonForm.php:36-76`
- **P2-UI4** `UiBasePolicy` non estende `XotBasePolicy` e non dichiara abilità: prima Resource = aperta — `app/Models/Policies/UiBasePolicy.php`

## Anti-pattern vietati

- baseline o `@phpstan-ignore` senza motivazione; test svuotati per silenziare errori;
- `migrate:fresh`, `RefreshDatabase`, `--force` su migrate; `laravel/public` al posto di `public_html`;
- nascondere la navigazione al posto di un controllo di accesso (`canAccess`/policy);
- docs con date nel nome file;
- comportamento, schermate o numeri inventati.

## Riferimenti

- [00-index](./00-index.md) · [BMAD audit](../bmad/audit.md) · [audit dettagliato](../bmad/audits/ui-audit.md)

## Layout Filament 5 (ECC)

Contratto document-shell: `@filamentStyles` + `@filamentScripts` + notifications
nudi nei layout UI (SSoT PTVX). Cms head/foot non applicabile qui.
Vedi [filament-layout-directives.story.md](../bmad/stories/filament-layout-directives.story.md).
