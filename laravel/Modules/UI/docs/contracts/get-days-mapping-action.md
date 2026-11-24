---
title: "GetDaysMappingAction — contratto"
type: contract
owner: UI
status: accepted
updated: 2026-11-24
action: "Modules\\UI\\Actions\\Datetime\\GetDaysMappingAction"
qmd: "GetDaysMappingAction giorni settimana mappa chiave etichetta lunedi sabato Carbon"
---

# GetDaysMappingAction

Mappa i giorni feriali-lavorativi (lunedì–sabato) da chiave inglese a etichetta localizzata. Codice: `app/Actions/Datetime/GetDaysMappingAction.php:23-67`.

## Input

- Nessun parametro. Usa `Carbon::now()` come punto di riferimento per la settimana.

## Output

- `array<string, string>`: chiave `monday`…`saturday` (minuscola, in inglese) => etichetta da `isoFormat('dddd')` con la capitalizzazione iniziale.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UI-DAYS-INV-1` | Il risultato ha sei chiavi, da lunedì a sabato; la domenica è assente. | righe 41-52, 25-31 | `tests/Unit/OpeningHoursRuleTest.php:47` (solo "non vuoto") |
| `UI-DAYS-INV-2` | La chiave è il nome inglese minuscolo del giorno (`format('l')`). | riga 63 | Test: nessuno |
| `UI-DAYS-INV-3` | L'etichetta dipende dal locale corrente di Carbon, non è fissa. | riga 64 | Test: nessuno |

## Effetti collaterali

Nessuno: nessuna lettura o scrittura persistente. Il risultato non dipende dall'ora corrente.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non include la domenica.
- Non imposta il locale: l'etichetta è quella del locale attivo al momento della chiamata.
