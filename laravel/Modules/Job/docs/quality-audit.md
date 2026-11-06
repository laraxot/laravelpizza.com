---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "Audit di qualita: modulo Job"
type: report
module: Job
updated: 2026-09-01
qmd: "audit qualita job phpstan phpmd phpinsights pest coverage soppressioni collisioni case"
status: draft
---

# Audit di qualita: modulo Job

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 475 |
| Righe di codice | 29972 |
| File di test `*Test.php` | 43 |
| Casi di test | 347 |
| Casi di test per file PHP | 0.73 |
| `@phpstan-ignore` nel codice | 0 |
| Rilievi PHPMD su `app/` | 116 |
| PHPInsights: Code | 88.2 % |
| PHPInsights: Complexity | 100.0 % |
| PHPInsights: Architecture | 71.4 % |
| PHPInsights: Style | 90.1 % |
| File `.md` sotto `docs/` | 484 |
| `TODO`/`FIXME`/`HACK` | 1 |
| Test con casi che non girano (senza suffisso `Test.php`) | 0 |
| Collisioni di case nel codice | 2 |
| Collisioni di case nei docs | 13 |
| Marker di conflitto | 0 |
| File `.lock` committati | 0 |
| File `.code-workspace` | 1 |

PHPStan su tutto `Modules/` e a **0 errori, exit 0**, con `ignoreErrors` vuoto in
`phpstan.neon` e `reportUnmatchedIgnoredErrors: true`. Quello zero pero non copre le
soppressioni scritte nel codice come commenti `@phpstan-ignore`: quelle non passano
da `ignoreErrors` e non vengono contate da nessun gate.

## Cosa non va

### 2 collisioni di case nel codice

Due percorsi che differiscono solo per maiuscole convivono su Linux e si
fondono su macOS e Windows. Quando sono file di test, uno dei due non viene
nemmeno raccolto: due file con lo stesso basename generano la stessa classe.

Percorsi coinvolti:

- `.github/SECURITY.md`
- `.github/contributing.md`

### 13 collisioni di case nei docs

Coppie tipo `INDEX.md` e `index.md`. Sono documenti che divergono in silenzio:
nessun linter le segnala e chi legge non sa quale delle due e la buona.

## Coverage

La misura sta in [`coverage.md`](./coverage.md), che va aggiornato a ogni run e non
sostituito.

## Cosa questa misura non vede

- **Il database di test non risponde.** `10.100.200.53:3306` e irraggiungibile: i
  test che scrivono vengono saltati, non falliti. Un conteggio di test verdi qui
  dentro non dice quanti test hanno davvero girato.
- **PHPStan e a zero, ma le soppressioni inline non sono contate da nessun gate.**
  `reportUnmatchedIgnoredErrors` controlla `ignoreErrors` nel neon, non i commenti
  `@phpstan-ignore` sparsi nel codice.
- **PHPMD misurato su `app/`, non sulla root del modulo.** Puntandolo alla root,
  una singola classe anonima nei test fa abortire tutta l'analisi e stampare zero
  rilievi. Uno zero PHPMD sulla root non e una prova di pulizia.
- **I file sotto `tests/` senza suffisso `Test.php` non sono tutti test.** Una
  prima passata ne aveva contati 62 come "test che non girano": verificati uno a uno,
  47 sono stub, fake, helper e classi base che correttamente non hanno il suffisso.
  Il conteggio qui sopra riporta solo i file che contengono davvero casi di test.
- **PHPInsights `Complexity 100 %` su tutte e 22 le unita.** Un valore identico
  ovunque non sta discriminando niente: va trattato come non informativo finche
  non se ne capisce la configurazione.

## Come rifare la misura

```bash
cd laravel
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Job
./tools/phpmd.sh Modules/Job/app          # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Job
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Job/tests -c Modules/Job/phpunit.xml --coverage --min=0
grep -rc "@phpstan-ignore" --include=*.php Modules/Job | grep -v ":0$"
```

Prima di fidarsi di qualunque numero: verificare che nessun altro agente stia
scrivendo sul tree, altrimenti la misura e falsa e diversa a ogni run.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
```

Audit complessivo e confronto fra tutte le unita: [`docs/quality-audit.md`](../../../../docs/quality-audit.md) nella root del progetto.

