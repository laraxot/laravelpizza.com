---
title: "GetLoginStatsAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Login\\GetLoginStatsAction"
qmd: "GetLoginStatsAction statistiche accessi oggi ieri 7 giorni 30 giorni variazione percentuale trend fuso orario"
---

# GetLoginStatsAction

Statistiche di accesso per il widget di monitoraggio: totale, oggi, ieri, ultimi 7 e 30 giorni, variazione e trend a 7 giorni. Codice: `app/Actions/Login/GetLoginStatsAction.php:10-126`.

## Input

- Nessuno: legge la config `user.login-monitoring` (modello, colonna, fuso) tramite `ResolvesLoginLogQuery`.

## Output

- `array` con `total`, `today`, `yesterday`, `last_7_days`, `last_30_days`, `previous_7_days`, `change_percentage` (float), `trend` (7 interi), `labels` (7 stringhe `d/m`) (righe 98-125).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `LOGIN-STATS-INV-1` | Ogni conteggio è un numero di righe del modello configurato con colonna non nulla. | righe 59, 65-68, 99 | Test: nessuno. |
| `LOGIN-STATS-INV-2` | Se entrambi i periodi valgono 0 la variazione è `0.0`; se il periodo precedente è 0 è `100.0`; altrimenti variazione arrotondata a due decimali. | righe 89-96 | Test: nessuno. |
| `LOGIN-STATS-INV-3` | Le finestre sono calcolate sui giorni locali del fuso configurato e convertite in UTC per il confronto. | righe 38-52 | Test: nessuno. |
| `LOGIN-STATS-INV-4` | Nessuna cache: scelta esplicita per evitare fughe fra tenant (righe 54-58). | righe 54-58 | Test: nessuno. |

## Effetti collaterali

Sola lettura: 13 query di conteggio (7 per il trend, più last 7, previous 7, totale, oggi, ieri, ultimi 30).

## Errori

- Nessuna gestione esplicita; eccezioni della configurazione (ereditate da `ResolvesLoginLogQuery`) e del database si propagano.

## Non fa

- Non conta gli utenti distinti: il docblock (righe 17-19) dice "each user is counted once", ma il codice conta le righe di `authentication_logs`. Il contratto descrive il codice; la discrepanza va risolta nel docblock o nel codice.
