---
title: "PdfByViewAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\PdfByViewAction"
qmd: "PdfByViewAction PDF da vista Blade render Export PdfByHtmlAction orientamento"
---

# PdfByViewAction

Renderizza una `View` Laravel e delega la conversione a `Export\PdfByHtmlAction`.

Codice: `app/Actions/Export/PdfByViewAction.php:11-26`.

## Input

- `View $view`.
- `string $filename` (default `my_doc.pdf`), `string $disk` (default `cache`), `string $out` (default `download`), `string $orientation` (default `L`).

## Output

`string|BinaryFileResponse`, come `Export\PdfByHtmlAction`.

## Invarianti

- `EXP-VIEW-INV-1`: l'HTML è `$view->render()` (riga 22), poi passa a `Export\PdfByHtmlAction` con tutti i parametri (riga 24). Test: Nessun test dedicato.

## Effetti collaterali

Rendering della vista; scrittura PDF su disco tramite la Action delegata.

## Errori

Errori di rendering della vista si propagano.

## Non fa

- Non valida la vista né l'orientamento.
