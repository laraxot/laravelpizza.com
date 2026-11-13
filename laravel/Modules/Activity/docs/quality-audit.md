---
title: "Audit di qualita: modulo Activity"
type: report
module: Activity
updated: 2026-09-01
qmd: "audit qualita activity phpstan phpmd phpinsights pest coverage soppressioni collisioni case"
<<<<<<< .merge_file_bS3PKV
---

# Audit di qualita — modulo Activity
=======
status: draft
tags: [docs, activity]
---

# Audit di qualita: modulo Activity
>>>>>>> .merge_file_qxa9Fw

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 304 |
| Righe di codice | 22215 |
| File di test `*Test.php` | 88 |
| Casi di test | 464 |
| Casi di test per file PHP | 1.53 |
| `@phpstan-ignore` nel codice | 1 |
| Rilievi PHPMD su `app/` | 2 |
<<<<<<< .merge_file_bS3PKV
| PHPInsights — Code | 94.1 % |
| PHPInsights — Complexity | 100.0 % |
| PHPInsights — Architecture | 92.9 % |
| PHPInsights — Style | 86.4 % |
=======
| PHPInsights: Code | 94.1 % |
| PHPInsights: Complexity | 100.0 % |
| PHPInsights: Architecture | 92.9 % |
| PHPInsights: Style | 86.4 % |
>>>>>>> .merge_file_qxa9Fw
| File `.md` sotto `docs/` | 708 |
| `TODO`/`FIXME`/`HACK` | 0 |
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

### 1 parse error PHPMD, e solo 2 rilievi

I 2 rilievi non sono un segno di pulizia: con un parse error aperto l'analisi si ferma
prima. Il numero va riletto dopo aver corretto il file che non si lascia leggere.

### 25 collisioni di case nei docs

Quelle nel codice (fixture) sono state chiuse il 1 settembre; restano quelle
documentali, piu' due cartelle `.github/` gemelle.

### 1 soppressioni `@phpstan-ignore`

Ogni soppressione e un errore vero che qualcuno ha deciso di non affrontare.
Il `phpstan.neon` di questo progetto lo dice esplicitamente in testa al proprio
output: «Do not add `@phpstan-ignore` comments». Vanno lette una per una e
chiuse alla sorgente o cancellate se non corrispondono piu a niente.

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
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Activity
./tools/phpmd.sh Modules/Activity/app          # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Activity
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Activity/tests -c Modules/Activity/phpunit.xml --coverage --min=0
grep -rc "@phpstan-ignore" --include=*.php Modules/Activity | grep -v ":0$"
```

Prima di fidarsi di qualunque numero: verificare che nessun altro agente stia
scrivendo sul tree, altrimenti la misura e falsa e diversa a ogni run.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
```

Audit complessivo e confronto fra tutte le unita: [`docs/quality-audit.md`](../../../../docs/quality-audit.md) nella root del progetto.

