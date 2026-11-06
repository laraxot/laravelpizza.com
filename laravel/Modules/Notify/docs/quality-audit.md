---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "Audit di qualita: modulo Notify"
type: report
module: Notify
updated: 2026-09-01
qmd: "audit qualita notify phpstan phpmd phpinsights pest coverage soppressioni collisioni case"
status: draft
---

# Audit di qualita: modulo Notify

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 720 |
| Righe di codice | 54927 |
| File di test `*Test.php` | 126 |
| Casi di test | 823 |
| Casi di test per file PHP | 1.14 |
| `@phpstan-ignore` nel codice | 1 |
| Rilievi PHPMD su `app/` | 191 |
| PHPInsights: Code | 91.8 % |
| PHPInsights: Complexity | 100.0 % |
| PHPInsights: Architecture | 85.7 % |
| PHPInsights: Style | 87.7 % |
| File `.md` sotto `docs/` | 4545 |
| `TODO`/`FIXME`/`HACK` | 7 |
| Test con casi che non girano (senza suffisso `Test.php`) | 0 |
| Collisioni di case nel codice | 14 |
| Collisioni di case nei docs | 80 |
| Marker di conflitto | 0 |
| File `.lock` committati | 0 |
| File `.code-workspace` | 1 |

PHPStan su tutto `Modules/` e a **0 errori, exit 0**, con `ignoreErrors` vuoto in
`phpstan.neon` e `reportUnmatchedIgnoredErrors: true`. Quello zero pero non copre le
soppressioni scritte nel codice come commenti `@phpstan-ignore`: quelle non passano
da `ignoreErrors` e non vengono contate da nessun gate.

## Cosa non va

### 4543 file .md sotto docs/, con 80 collisioni di case fra loro

E' la seconda superficie documentale del progetto dopo Xot, ed e' 6 volte il numero di
file PHP del modulo. Le 80 collisioni sono coppie tipo `ARCHITECTURE-DIAGRAMS.md` /
`architecture-diagrams.md`: su un filesystem case-sensitive sono due documenti che
divergono, su macOS o Windows sono un conflitto.

### 14 collisioni di case nel codice

Le collisioni sui file di test sono state chiuse il 1 settembre. Restano soprattutto
cartelle `.github/` gemelle (`DISCUSSIONS` / `discussions`, `ISSUES` / `issues`,
`ISSUE_CONTENT` / `issue_content`) e tre template Blade in due temi email.

### 1 soppressioni `@phpstan-ignore`

Ogni soppressione e un errore vero che qualcuno ha deciso di non affrontare.
Il `phpstan.neon` di questo progetto lo dice esplicitamente in testa al proprio
output: «Do not add `@phpstan-ignore` comments». Vanno lette una per una e
chiuse alla sorgente o cancellate se non corrispondono piu a niente.

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
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Notify
./tools/phpmd.sh Modules/Notify/app          # non la root: aborta sulle classi anonime
./tools/phpinsights.sh Modules/Notify
XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Notify/tests -c Modules/Notify/phpunit.xml --coverage --min=0
grep -rc "@phpstan-ignore" --include=*.php Modules/Notify | grep -v ":0$"
```

Prima di fidarsi di qualunque numero: verificare che nessun altro agente stia
scrivendo sul tree, altrimenti la misura e falsa e diversa a ogni run.

```bash
/usr/bin/find Modules -newermt '-70 seconds' -type f | wc -l   # deve dare 0
```

Audit complessivo e confronto fra tutte le unita: [`docs/quality-audit.md`](../../../../docs/quality-audit.md) nella root del progetto.

