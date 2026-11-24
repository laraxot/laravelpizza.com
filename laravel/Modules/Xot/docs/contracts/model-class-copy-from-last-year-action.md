---
title: "CopyFromLastYearAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ModelClass\\CopyFromLastYearAction"
qmd: "CopyFromLastYearAction copia record anno precedente anno corrente modello replicate campo anno"
---

# CopyFromLastYearAction

Copia i record dell'anno precedente in quello corrente, cambiando il campo anno. Codice: `app/Actions/ModelClass/CopyFromLastYearAction.php`.

Nome duplicato: esiste anche `app/Actions/Filament/Actions/CopyFromLastYearAction.php`. Per questo il contract porta il prefisso del sottopercorso.

## Input

- `string $modelClass`: FQCN di un modello Eloquent.
- `string $fieldName`: colonna dell'anno.
- `?string $year`: anno corrente (convertito con `(int)`).

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `MODEL-CFLY-INV-1` | Se la classe non esiste o non estende `Model`, non fa nulla. | Test: nessuno |
| `MODEL-CFLY-INV-2` | Se esistono già record con l'anno corrente, non copia nulla. | Test: nessuno |
| `MODEL-CFLY-INV-3` | Ogni record dell'anno precedente viene replicato con il solo campo anno impostato all'anno corrente. | Test: nessuno |

## Effetti collaterali

Nessuna transazione. Per ogni record: `replicate()`, `fill()`, `save()` (eventi Eloquent attivi). Nessuna coda, nessun evento proprio, nessun servizio esterno.

## Errori

- Errori del database si propagano.
- `$year` null diventa `0`: il codice copia i record con anno `-1` verso anno `0`. Non c'è controllo.

## Non fa

- Non è atomica: se un `save()` fallisce a metà, alcune righe restano copiate. Alla ripetizione l'Action si ferma subito perché l'anno corrente ha già record (`MODEL-CFLY-INV-2`), quindi la copia incompleta non viene completata.
- Non gestisce le colonne timestamp in modo esplicito.
