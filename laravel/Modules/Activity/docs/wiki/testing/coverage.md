---
title: Coverage
module: Activity
type: note
updated: 2026-10-08
tags: [docs, activity, wiki]
qmd: "activity   quality gate status (2026-09-22) activity"
status: superseded
superseded_by: ../coverage.md
---

# Activity — quality gate status (2026-09-22)

Eseguito dopo la pulizia dei marker di conflitto in `docs/*.md` (commit
`5fe111e1`, `e6eb12dd`, `7836580e`, `d79c39d5`). Modifiche di questa sessione
sono solo documentazione (`docs/`, `.github/`); gate PHP eseguiti per
conferma, come da procedura standing order.

## PHPStan (Modules/Activity)

```
[OK] No errors
```

## PHPMD (`tools/phpmd.sh Modules/Activity`)

Exit code 0. Findings solo su `tests/` (parametri inutilizzati nei mock
Filament, import mancanti, variabile lunga, flag booleano) — nessuno
introdotto da questa sessione (solo file `docs/` toccati).

Il parser (pdepend, via phpmd.phar) muore con `UnexpectedTokenException`
su `tests/Unit/Listeners/LoginLogoutListenerBehaviorTest.php:32`:
sintassi PHP 8.4 `new ReflectionClass(...)->getProperty(...)` (chaining su
`new` senza parentesi) non supportata dal parser di phpmd.phar. Verificato
`php -l` sul file: nessun errore di sintassi, file valido. Falso negativo
noto del tool, non un difetto del codice (vedi memoria
`feedback-phpmd-phar-dies-on-dnf-types.md`).

## PHPInsights (`tools/phpinsights.sh analyse Modules/Activity`)

| Metrica | Punteggio |
|---|---|
| Code | 95.3 |
| Complexity | 100 |
| Architecture | 78.6 |
| Style | 90.1 |
| Security issues | 0 |

Nessuna regressione attesa: nessun file PHP toccato in questa sessione.

## Pest

**Non eseguito**: DB `10.100.200.53:3306` non raggiungibile (`nc -z`
fallito), come da pattern noto (`project-test-db-unreachable-drives-skips.md`).
Nessun test è stato eseguito per evitare hang; da rilanciare quando il DB
di test è raggiungibile.
