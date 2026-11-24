---
title: "PdfByModelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\PdfByModelAction"
qmd: "PdfByModelAction PDF da modello vista show.pdf GetViewByModelClassAction transKey fields Eloquent"
---

# PdfByModelAction

Genera un PDF da un modello Eloquent: risolve la vista `.show.pdf` della classe e delega il rendering a `Export\PdfByHtmlAction`.

Codice: `app/Actions/Export/PdfByModelAction.php:13-39`.

## Input

- `Model $model`.
- `string $filename` (default `my_doc.pdf`), `string $disk` (default `cache`), `string $out` (default `download`).

## Output

`string|BinaryFileResponse`, come `Export\PdfByHtmlAction`.

## Invarianti

- `EXP-MODEL-INV-1`: il nome vista è `GetViewByModelClassAction(classe, '.show.pdf')` (riga 26). Test: Nessun test dedicato.
- `EXP-MODEL-INV-2`: la vista riceve `view`, `row` (il modello) e `transKey` = `GetTransKeyByModelClassAction(classe, '.fields')` (righe 28-33). Test: Nessun test dedicato.
- `EXP-MODEL-INV-3`: il PDF è prodotto da `Export\PdfByHtmlAction` con gli stessi `filename`, `disk`, `out` (riga 37). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura PDF su disco tramite `PdfByHtmlAction`.

## Errori

Errori di `GetViewByModelClassAction` e di Laravel per vista mancante si propagano; nessuna gestione propria.

## Non fa

- Non valida che il modello abbia una vista `.show.pdf` prima di renderizzare.
- Non imposta orientamento: usa il default di `PdfByHtmlAction` (`L`).
