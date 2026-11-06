---
title: "Audit di qualita: modulo User"
type: report
module: User
updated: 2026-09-01
qmd: "audit qualita user phpstan phpmd phpinsights pest coverage soppressioni collisioni case"
status: draft
tags: [docs, user]
---

# Audit di qualita: modulo User

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 1799 |
| Righe di codice | 122101 |
| File di test `*Test.php` | 137 |
| Casi di test | 1134 |
| Casi di test per file PHP | 0.63 |
| `@phpstan-ignore` nel codice | 1 |
| Rilievi PHPMD su `app/` | 471 |
| PHPInsights: Code | 91.8 % |
| PHPInsights: Complexity | 100.0 % |
| PHPInsights: Architecture | 78.6 % |
| PHPInsights: Style | 96.3 % |
| File `.md` sotto `docs/` | 3151 |
| `TODO`/`FIXME`/`HACK` | 122 |
| Test con casi che non girano (senza suffisso `Test.php`) | 0 |
| Collisioni di case nel codice | 2 |
| Collisioni di case nei docs | 47 |
| Marker di conflitto | 0 |
| File `.lock` committati | 25 |
| File `.code-workspace` | 1 |

PHPStan su tutto `Modules/` e a **0 errori, exit 0**, con `ignoreErrors` vuoto in
`phpstan.neon` e `reportUnmatchedIgnoredErrors: true`. Quello zero pero non copre le
soppressioni scritte nel codice come commenti `@phpstan-ignore`: quelle non passano
da `ignoreErrors` e non vengono contate da nessun gate.

## Cosa non va

### 25 file .lock committati

`git ls-files | grep '\.lock$'` ne trova 25, con dentro `locked_at: 2026-07-16`, cioe'
47 giorni fa. I lock di `bashscripts/lock/` sono dichiarazioni d'intento fra agenti,
transitorie per definizione: versionarli li rende permanenti e fa apparire occupati file
che nessuno sta toccando. Vanno tolti dall'indice e aggiunti a `.gitignore`.

### 122 TODO/FIXME/HACK, il massimo del progetto

Non sono un difetto in se', ma sono il triplo del secondo modulo. Meritano un triage:
quali sono decisioni rimandate e quali sono bug noti.

### Il coverage e' misurato su un terzo della suite

`docs/coverage.md` riporta 70,1 % di riga con **763 test saltati su 1134**. I salti
vengono dal database di test irraggiungibile (`10.100.200.53:3306`), non da `skip()`
scritti a mano. Il 70,1 % descrive il terzo di suite che gira, non il modulo.

### 471 rilievi PHPMD

Secondo solo a Xot. Il numero e' su `app/`, quindi e' una misura vera e non un abort.

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

### 47 collisioni di case nei docs

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
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/User
./tools/phpmd.sh Modules/User/app          # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/User
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/User/tests -c Modules/User/phpunit.xml --coverage --min=0
grep -rc "@phpstan-ignore" --include=*.php Modules/User | grep -v ":0$"
```

Prima di fidarsi di qualunque numero: verificare che nessun altro agente stia
scrivendo sul tree, altrimenti la misura e falsa e diversa a ogni run.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
```

Audit complessivo e confronto fra tutte le unita: [`docs/quality-audit.md`](../../../../docs/quality-audit.md) nella root del progetto.

