---
title: "ApplyCalendarToPanelAction — contratto"
type: contract
owner: UI
status: accepted
updated: 2026-11-24
action: "Modules\\UI\\Actions\\Panel\\ApplyCalendarToPanelAction"
qmd: "ApplyCalendarToPanelAction calendario panel Filament disabilitato stub Filament v4"
---

# ApplyCalendarToPanelAction

Dovrebbe applicare un calendario al panel Filament; oggi è uno stub che restituisce il panel invariato. Codice: `app/Actions/Panel/ApplyCalendarToPanelAction.php:23-34`.

## Input

- `Panel $panel`: il panel Filament.
- `string $calendarClass`: non usato.

## Output

- `Panel`: lo stesso panel ricevuto, senza modifiche.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UI-CAL-INV-1` | Il panel restituito è quello ricevuto, senza modifiche. | riga 33 | Test: nessuno |

## Effetti collaterali

- Con `config('app.debug')` attivo scrive una riga `Log::info` (riga 30). Nessun'altra scrittura.

## Errori

- Nessuna eccezione.

## Non fa

- Non registra alcun calendario né widget sul panel: la reimplementazione è un TODO legato a un pacchetto compatibile con Filament v4.
- Non usa `$calendarClass`: il parametro è accettato ma ignorato.
