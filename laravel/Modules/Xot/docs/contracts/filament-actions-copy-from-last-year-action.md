---
title: "CopyFromLastYearAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\Actions\\CopyFromLastYearAction"
qmd: "CopyFromLastYearAction Filament azione copia dati anno precedente conferma model_class field_name year XotBaseAction"
---

# CopyFromLastYearAction

Azione Filament di copia dei dati dall'anno precedente: valida gli argomenti e delega a `ModelClass\CopyFromLastYearAction`.

Codice: `app/Actions/Filament/Actions/CopyFromLastYearAction.php:14-79`.

## Input

- `array $arguments`: deve contenere `model_class` e `field_name` stringhe; `year` stringa o nulla.
- `array $data`: solo chiavi stringa.

## Output

`void`. Effetto nei dati tramite la Action delegata.

## Invarianti

- `FIL-COPY-INV-1`: senza `model_class` o `field_name` stringhe esce senza fare nulla e senza errore (righe 69-71). Test: Nessun test dedicato.
- `FIL-COPY-INV-2`: `year` non stringa e non nullo: esce senza errore (righe 73-75). Test: Nessun test dedicato.
- `FIL-COPY-INV-3`: nell'azione Filament, argomenti e dati sono ridotti alle sole chiavi stringa (righe 31-36, 43-56). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura dati tramite `ModelClass\CopyFromLastYearAction` (fuori perimetro). Il bottone richiede conferma (`requiresConfirmation`).

## Errori

Nessuna eccezione: gli input non validi sono scartati in silenzio.

## Non fa

- Non avvisa l'utente quando l'input è scartato.
- Un anno passato come intero viene scartato senza messaggio.
