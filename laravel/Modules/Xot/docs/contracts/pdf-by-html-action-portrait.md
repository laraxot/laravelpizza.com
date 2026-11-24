---
title: "PdfByHtmlAction_Portrait — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\PdfByHtmlAction_Portrait"
qmd: "PdfByHtmlAction_Portrait PDF HTML orientamento portrait verticale Html2Pdf Storage download content"
---

# PdfByHtmlAction_Portrait

Variante di `Export\PdfByHtmlAction` con orientamento fisso verticale (`P`) e senza parametro `orientation`.

Codice: `app/Actions/Export/PdfByHtmlAction_Portrait.php:12-37`.

## Input

- `string $html`, `string $filename` (default `my_doc.pdf`), `string $disk` (default `cache`), `string $out` (default `download`).

## Output

`string|BinaryFileResponse`, come `Export\PdfByHtmlAction`.

## Invarianti

- `EXP-PDF-P-INV-1`: il PDF è creato in orientamento `P` e salvato su disco prima del ritorno (righe 22-26). Test: Nessun test dedicato.
- `EXP-PDF-P-INV-2`: i valori di `$out` seguono lo stesso schema di `Export\PdfByHtmlAction` (righe 32-36). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura del file PDF su disco; nessuna cancellazione.

## Errori

Le eccezioni di Html2Pdf risalgono al chiamante.

## Non fa

- Il nome include un underscore (`PdfByHtmlAction_Portrait`): non segue la convenzione dei nomi delle classi.
- Duplica `Export\PdfByHtmlAction` salvo l'orientamento: candidata a fusione con parametro.
