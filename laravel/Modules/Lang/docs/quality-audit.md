---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "Audit di qualita: modulo Lang"
type: report
module: Lang
updated: 2026-09-01
qmd: "audit qualita lang phpstan phpmd phpinsights pest coverage soppressioni collisioni case"
status: draft
---

# Audit di qualita: modulo Lang

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 213 |
| Righe di codice | 23475 |
| File di test `*Test.php` | 23 |
| Casi di test | 251 |
| Casi di test per file PHP | 1.18 |
| `@phpstan-ignore` nel codice | 0 |
| Rilievi PHPMD su `app/` | 60 |
| PHPInsights: Code | 94.1 % |
| PHPInsights: Complexity | 100.0 % |
| PHPInsights: Architecture | 92.9 % |
| PHPInsights: Style | 85.2 % |
| File `.md` sotto `docs/` | 1144 |
| `TODO`/`FIXME`/`HACK` | 1 |
| Test con casi che non girano (senza suffisso `Test.php`) | 0 |
| Collisioni di case nel codice | 2 |
| Collisioni di case nei docs | 25 |
| Marker di conflitto | 0 |
| File `.lock` committati | 0 |
| File `.code-workspace` | 1 |

PHPStan su tutto `Modules/` e a **0 errori, exit 0**, con `ignoreErrors` vuoto in
`phpstan.neon` e `reportUnmatchedIgnoredErrors: true`. Quello zero pero non copre le
soppressioni scritte nel codice come commenti `@phpstan-ignore`: quelle non passano
da `ignoreErrors` e non vengono contate da nessun gate.

## Cosa non va

### La suite riscrive file tracciati

Verificato il 31 agosto: una run di Pest su Lang riscrive `lang/en/*.php`: 7 file,
3679 righe, con `declare(strict_types=1)` rimosso. La guardia in
`app/Actions/SaveTransAction.php` copre una sola via di scrittura, e per giunta si
disattiva da sola quando `bootstrap/cache/config.php` esiste (vedi `coverage.md`).
Finche' non e' chiusa, dopo ogni run va fatto `git checkout -- lang/`.

### Un test rosso impedisce di misurare il coverage

`tests/Unit/LangHundredPercentCoverageTest.php:635` fallisce in isolamento; Pest stampa
la tabella di coverage solo su suite verde, quindi il numero non e' ottenibile.

### 2 collisioni di case nel codice

Due percorsi che differiscono solo per maiuscole convivono su Linux e si
fondono su macOS e Windows. Quando sono file di test, uno dei due non viene
nemmeno raccolto: due file con lo stesso basename generano la stessa classe.

Percorsi coinvolti:

- `.github/SECURITY.md`
- `.github/contributing.md`

### 25 collisioni di case nei docs

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
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Lang
./tools/phpmd.sh Modules/Lang/app          # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Lang
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Lang/tests -c Modules/Lang/phpunit.xml --coverage --min=0
grep -rc "@phpstan-ignore" --include=*.php Modules/Lang | grep -v ":0$"
```

Prima di fidarsi di qualunque numero: verificare che nessun altro agente stia
scrivendo sul tree, altrimenti la misura e falsa e diversa a ogni run.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
```

Audit complessivo e confronto fra tutte le unita: [`docs/quality-audit.md`](../../../../docs/quality-audit.md) nella root del progetto.

