---
title: "SpipuPdfByHtmlAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Pdf\\Engine\\SpipuPdfByHtmlAction"
qmd: "SpipuPdfByHtmlAction engine PDF spipu html2pdf HTML disco download content path duplicato"
---

# SpipuPdfByHtmlAction

Engine PDF basato su `spipu/html2pdf`; corpo identico a `SpatiePdfByHtmlAction`.

Codice: `app/Actions/Pdf/Engine/SpipuPdfByHtmlAction.php:12-39`.

## Input

- `string $html`, `string $filename` (default `my_doc.pdf`), `string $disk` (default `cache`), `string $out` (default `download`), `string $orientation` (default `P`).

## Output

`string|BinaryFileResponse` come `Export\PdfByHtmlAction`.

## Invarianti

- `PDF-ENG-SPIPU-INV-1`: il PDF è generato con `Html2Pdf` e salvato in `Storage::disk($disk)` prima del ritorno (righe 23-27). Test: Nessun test dedicato.
- `PDF-ENG-SPIPU-INV-2`: `download`, `content`, altri valori: stesso schema di `Export\PdfByHtmlAction` (righe 33-37). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura PDF su disco.

## Errori

Eccezioni di Html2Pdf risalgono al chiamante.

## Non fa

- Duplicato di `SpatiePdfByHtmlAction` (stesso corpo).
- Non ha un ramo `content` diverso dal default: vedi `Export\PdfByHtmlAction`.
