---
title: "ECC audit operativo — Xot"
type: ecc-audit
status: review
updated: 2026-11-16
module: Xot
qmd: "ECC audit Xot verification security testing laravel security-review clean-code laravel-verification verification-loop tdd-workflow"
---

# ECC audit operativo — Xot

## Contratto PTVX

ECC non sostituisce `AGENTS.md`/BMAD: ogni finding diventa story in [epics.md](../bmad/epics.md), con lock,
fix alla causa, PHPStan + Pest, aggiornamento docs/QMD. Le abilità ECC sono scelte on-demand
(`ecc-ptvx-workflow`); qui è registrato **l'esito**, non la checklist vuota.

## Esito per skill (2026-11-16)

| Skill ECC | Stato | Evidenza |
|---|---|---|
| `clean-code` (DRY/KISS, Actions-over-Services) | parziale | 2 Services, 9 trait `trait.unused` con ignore, ~40 `dddx` commentati |
| `security-review` (policy, accesso pannello, dati) | parziale | P2-X3 `HandleArtisanActRequestAction`; `--force` solo su SQLite di test e symlink opt-in |
| `laravel-verification` (route, policy, migration additive) | ok | `publicPath()` → `public_html`; `TestDatabaseGuard` attivo (verificato da Pest); migration additive |
| `verification-loop` (PHPStan max + Pest) | PHPStan ok, Pest skip | PHPStan 0 errori (rerun; prima passata 6+ errori in `FeatureFlagsTest` mentre un altro agente lo editava); Pest: skip documentato: DB di test `10.100.200.53:3306` irraggiungibile (TCP chiuso) e `Xot/tests/Support/TestDatabaseGuard.php:63` rifiuta DB non `*_test`; i test con DB restano appesi al connect MySQL (timeout 150 s osservato). Nessun test contro il MySQL locale (dati sacri). |
| `tdd-workflow` (regressione sui P0) | aperto | test comportamentale su `XotBasePolicy::before` (3 casi) prima di rimuovere `once()` |
| `documentation-sync` | fatto | pack aggiornato: [audit](../bmad/audits/xot-audit.md), [epics](../bmad/epics.md), [decision-log](../decision-log.md) |
| `context-engineering` | fatto | source-first; il perché in [purpose](../bmad/purpose.md) |

## Input misurato (2026-11-16)

| Voce | N |
|---|---:|
| PHP `app/` | 602 |
| Test PHP | 329 |
| Models | 51 |
| Policy | 15 |
| Resource | 7 |
| Widget | 16 |
| Actions | 238 in `app/Actions` (257 contando ogni cartella `Actions`) |
| Services | 2 |
| Migration | 10 |
| Lang IT | 149 |
| `->label('..')` letterali | 18 |
| `@phpstan-ignore` | 20 |

## Finding da trasformare in story

- **P1-X1** Il core importa 33 classi da 7 moduli feature (55 `use`), `module.json` `requires: []` — `Xot/app (es. `Filament/Traits/HasXotTable.php`, `Datas/MetatagData.php`)`
- **P1-X2** `Services/RouteService.php` (354 righe, ~28 `dddx` commentati, 1 chiamante esterno) + `ModuleCommandHandler` — `Xot/app/Services`
- **P2-X1** `XotBasePolicy::before()` con `once()` senza beneficio (cache per istanza, hash `spl_object_id`) — `Xot/app/Models/Policies/XotBasePolicy.php:21`
- **P2-X3** `HandleArtisanActRequestAction` senza chiamanti, concatena `Request::input('module')` in un comando — `Xot/app/Actions/Artisan/HandleArtisanActRequestAction.php:48-71`

## Anti-pattern vietati

- baseline o `@phpstan-ignore` senza motivazione; test svuotati per silenziare errori;
- `migrate:fresh`, `RefreshDatabase`, `--force` su migrate; `laravel/public` al posto di `public_html`;
- nascondere la navigazione al posto di un controllo di accesso (`canAccess`/policy);
- docs con date nel nome file;
- comportamento, schermate o numeri inventati.

## Riferimenti

- [00-index](./00-index.md) · [BMAD audit](../bmad/audit.md) · [audit dettagliato](../bmad/audits/xot-audit.md)

## Tassonomia portfolio (ECC)

PTVX senza Cms per dominio/confine: imparare pattern FO (layout Filament, FolioVolt)
senza importare il modulo. Memoria: [module-portfolio-taxonomy-ptvx.md](../../../../../docs/wiki/memories/module-portfolio-taxonomy-ptvx.md).

## Folio owner (ECC)

Nei FO: solo `Cms/FolioVoltServiceProvider`. Non registrare App `FolioServiceProvider`.
PTVX: stub App inerte; niente surrogato. Memoria: [folio-owner-foliovolt-only.md](../../../../../docs/wiki/memories/folio-owner-foliovolt-only.md).
