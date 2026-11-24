---
title: "ExportXlsByQuery — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\ExportXlsByQuery"
qmd: "ExportXlsByQuery export Excel query Builder limite righe QueryExport download"
---

# ExportXlsByQuery

Esporta il risultato di un Eloquent Builder in Excel, con limite opzionale applicato al builder.

Codice: `app/Actions/Export/ExportXlsByQuery.php:15-49`.

## Input

- `Builder $query`.
- `string $filename` (default `test.xlsx`).
- `array $fields`: convertiti a stringhe.
- `?int $limit`: se non nullo, applicato con `$query->limit()`.

## Output

`BinaryFileResponse` da `Excel::download`.

## Invarianti

- `XLS-QUERY-INV-1`: `transKey` è sempre `null`: le intestazioni non vengono tradotte (riga 38). Test: Nessun test dedicato.
- `XLS-QUERY-INV-2`: se `$limit` non è nullo, il builder ricevuto viene modificato con `limit()` (righe 43-45). Test: Nessun test dedicato.

## Effetti collaterali

Modifica del builder passato come argomento (`limit`). Download via layer Excel.

## Errori

Nessuna eccezione propria.

## Non fa

- Il limite è applicato DOPO la costruzione di `QueryExport` (righe 36-45): l'effetto dipende dal fatto che `QueryExport` mantenga lo stesso builder per riferimento. Da verificare in `Exports/QueryExport`.
- Non impone un limite di default: una query senza limite esporta tutte le righe.
