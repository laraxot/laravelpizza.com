---
title: "ECC audit operativo — Xot"
type: ecc-audit
status: review
<<<<<<< .merge_file_CK6TzQ
updated: 2026-11-24
module: Xot
qmd: "ECC audit Xot verification security testing laravel security-review clean-code laravel-verification verification-loop tdd-workflow"
=======
updated: 2026-11-16
module: Xot
<<<<<<< HEAD
qmd: "ECC audit Xot verification security testing laravel security-review clean-code laravel-verification verification-loop tdd-workflow"
=======
<<<<<<< .merge_file_05zmnp
qmd: "ECC audit Xot security-review clean-code laravel-verification verification-loop tdd-workflow"
=======
qmd: "ECC audit Xot verification security testing laravel security-review clean-code laravel-verification verification-loop tdd-workflow"
>>>>>>> .merge_file_ZAWZVf
>>>>>>> laraxot/dev
>>>>>>> .merge_file_HI4oCt
---

# ECC audit operativo — Xot

<<<<<<< .merge_file_CK6TzQ
## Aggiornamento audit — 2026-11-24

### Gate statico corrente

Il comando canonico è stato eseguito da `laravel/`:

```text
./vendor/bin/phpstan analyse Modules
```

Il gate non è certificabile come verde. PHPStan ha rilevato sei errori di
parsing in `Modules/User` (due nella migration e quattro file di traduzione) e un
errore interno di lettura della result cache condivisa. Questi file sono fuori
dal perimetro modificabile di questo audit; nessun test o file di codice è stato
toccato. Prima del prossimo gate occorre stabilizzare il worktree concorrente,
risolvere i marker alla sorgente e usare una cache PHPStan privata.

### Convenzioni verificate

- `AGENTS.md` ora esplicita il contratto `@see`: il link deve usare la forma
  `Modules/<Modulo>/docs/<file-kebab>.md` e il documento deve esistere nello
  stesso cambiamento.
- Le story attive Xot di PHPStan, conflitti e documentazione non sono una sola
  fonte di stato: alcune conservano risultati storici `verified-zero` mentre il
  gate corrente è rosso. Le evidenze datate restano storico, non certificazione.
- La story `phpstan-modules-zero-swarm-standing.story.md` è stata riallineata
  al gate corrente; la storia del precedente zero è conservata nel diario.
- La story di risoluzione conflitti dichiarava contemporaneamente frontmatter
  `active` e corpo `done`; il frontmatter è stato corretto a `done`.

### Audit `@see` sui PHP recentemente osservabili

Il controllo ha esaminato i riferimenti `@see` del perimetro Xot e ha
verificato che i target dichiarati dal codice Xot esistano quando sono espressi
come link locali canonici. Non è stato eseguito un backfill indiscriminato sui
file invariati. Le difformità residue (forma relativa, FQCN o documenti non
canonici) richiedono una modifica al PHP proprietario e quindi sono state solo
registrate, perché questo incarico autorizza esclusivamente documentazione root
e `Modules/Xot/docs`.

### Conflitti Git residui nel codice attivo

La scansione ha trovato marker fuori Xot, principalmente in `Modules/UI` e
`Modules/User`, inclusi file applicativi, route e configurazione. Sono stati
lasciati intatti per rispettare il perimetro. La loro presenza spiega perché un
run globale possa fallire prima di valutare la qualità semantica del codice.

## Contratto PTVX

=======
## Contratto PTVX

<<<<<<< HEAD
=======
<<<<<<< .merge_file_05zmnp
ECC non sostituisce AGENTS.md/BMAD. Ogni finding: story BMAD, lock, fix causa,
PHPStan + Pest, aggiornamento docs/QMD.

## Checklist

- [ ] `clean-code`: DRY/KISS, Actions su Services, niente wrapper inutili
- [ ] `security-review`: policy, mass assignment, export, log, privacy, tenant
- [ ] `laravel-verification`: route, config, migration additive, container
- [ ] `verification-loop`: PHPStan level max + Pest mirato
- [ ] `tdd-workflow`: regressione sui finding P0
- [ ] `documentation-sync`: story + indici + qmd
- [ ] `context-engineering`: QMD/graphify prima; registrare il perché dopo
=======
>>>>>>> .merge_file_ZAWZVf
>>>>>>> laraxot/dev
>>>>>>> .merge_file_HI4oCt
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
<<<<<<< .merge_file_CK6TzQ
=======
<<<<<<< HEAD
=======
<<<<<<< .merge_file_05zmnp
| app PHP | 602 |
| test | 329 |
| resources | 7 |
| actions | 238 |
| services | 2 |
| policies (files approx) | 26 |

## Gate osservati

- PHPStan `Modules` (2026-11-16): 0 errori
- Pest: pending (ambiente testing)

## Anti-pattern vietati

- baseline/`@phpstan-ignore` senza motivazione
- test svuotati per silenziare errori
- migrate:fresh / RefreshDatabase / --force
- docs con date nel nome file
- comportamento o screenshot inventati

## Riferimenti

- [00-index](./00-index.md)
- [BMAD audit](../bmad/audit.md)
=======
>>>>>>> .merge_file_ZAWZVf
>>>>>>> laraxot/dev
>>>>>>> .merge_file_HI4oCt
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
