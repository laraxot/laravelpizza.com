---
title: "SpatiePdfByHtmlAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Pdf\\Engine\\SpatiePdfByHtmlAction"
qmd: "SpatiePdfByHtmlAction engine PDF nome Spatie implementazione Html2Pdf duplicato SpipuPdfByHtmlAction"
---

# SpatiePdfByHtmlAction

Engine PDF con nome `Spatie` che in realtà usa `spipu/html2pdf`; corpo identico a `SpipuPdfByHtmlAction`.

Codice: `app/Actions/Pdf/Engine/SpatiePdfByHtmlAction.php:12-39`.

## Input

- `string $html`, `string $filename` (default `my_doc.pdf`), `string $disk` (default `cache`), `string $out` (default `download`), `string $orientation` (default `P`).

## Output

`string|BinaryFileResponse` come `Export\PdfByHtmlAction`.

## Invarianti

- `PDF-ENG-SPATIE-INV-1`: il PDF è generato con `Html2Pdf` (non con `spatie/laravel-pdf`) e salvato in `Storage::disk($disk)` prima del ritorno (righe 23-27). Test: Nessun test dedicato.
- `PDF-ENG-SPATIE-INV-2`: `download`, `content`, altri valori: stesso schema di `Export\PdfByHtmlAction` (righe 33-37). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura PDF su disco.

## Errori

Eccezioni di Html2Pdf risalgono al chiamante.

## Non fa

- Il nome suggerisce Spatie ma non dipende da `spatie/laravel-pdf`.
- Duplicato di `SpipuPdfByHtmlAction`: fondere o eliminare dopo verifica dei riferimenti.
