---
title: "Contratto — GetActivityStatisticsAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Query\\GetActivityStatisticsAction"
qmd: "contract GetActivityStatisticsAction activity statistiche totale per tipo oggi settimana mese cache cinque minuti ACT-QSTATS"
---

# GetActivityStatisticsAction

Statistiche del log attività (totale, per tipo, oggi, settimana, mese) per la dashboard, con cache di 5 minuti per utente.

## Input

- `?UserContract $user = null`: se valorizzato, statistiche limitate alle attività causate da quell'utente.

## Output

- `array{total: int, by_type: array<string, int>, today: int, this_week: int, this_month: int}`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-QSTATS-INV-1` | Il risultato è in cache per 5 minuti sotto la chiave `activity.statistics.<id utente>` o `activity.statistics.global`. Utenti diversi non condividono la cache. | Test: nessuno su TTL o chiave; `CoverageHundredActionsTest.php` (~righe 189-193) copre solo il percorso |
| `ACT-QSTATS-INV-2` | Un utente che non è un Eloquent `Model` lancia `InvalidArgumentException('User must be an Eloquent model')`, ma solo al calcolo: con cache calda non viene lanciata. | Test: nessuno |
| `ACT-QSTATS-INV-3` | La forma del risultato è fissa; `by_type` ignora gli `event` vuoti. | `AdapterActivityLoggerDelegationTest.php` (verifica la chiave `total`) |
| `ACT-QSTATS-INV-4` | Valori non numerici della cache sono normalizzati a `0`. | Test: nessuno |

## Effetti collaterali

- Scrittura nello store di cache applicativo (`Cache::remember`).
- Sei query di conteggio/aggregazione al primo accesso (totale, gruppo per tipo, oggi, settimana, mese).
- Nessuna invalidazione alla scrittura di nuove attività: i numeri possono restare vecchi fino a 5 minuti.

## Errori

- `InvalidArgumentException` (INV-2).

## Non fa

- Non invalida la cache quando si registra un'attività.
- La settimana segue `startOfWeek()`, quindi la configurazione locale dell'app (non verificata qui).
- `ActivityLogger::getStatistics()` calcola gli stessi numeri senza cache (vedi `activity-logger.md`).

