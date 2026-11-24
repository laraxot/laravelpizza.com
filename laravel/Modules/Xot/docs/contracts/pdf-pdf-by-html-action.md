---
title: "PdfByHtmlAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Pdf\\PdfByHtmlAction"
qmd: "PdfByHtmlAction Pdf PdfData engine SPIPU HTML PDF download path disk cache orientamento"
---

# PdfByHtmlAction

Converte HTML in PDF tramite `PdfData` e restituisce download o percorso. Namespace `Pdf` (duplicato di `Export\PdfByHtmlAction`).

Codice: `app/Actions/Pdf/PdfByHtmlAction.php:11-54`.

## Input

- `string $html`.
- `string $filename` (default `my_doc.pdf`), `string $disk` (default `cache`), `string $out` (default `download`), `string $orientation` (default `P`).
- `PdfEngineEnum $engine` (default SPIPU): enum `Modules\Xot\Actions\Pdf\PdfEngineEnum`.

## Output

`string|BinaryFileResponse`: download (`download`), percorso (altri valori, incluso `content`).

## Invarianti

- `PDF-PDFHTML-INV-1`: la generazione è delegata a `PdfData::fromHtml` (righe 35-45); `download` restituisce `BinaryFileResponse`, gli altri valori il percorso (righe 48-52). Test: tests/Unit/Actions/Pdf/PdfActionsTest.php:11 (menzione, namespace da verificare).
- `PDF-PDFHTML-INV-2`: il valore `content` non ha un ramo dedicato: cade nel default e restituisce il percorso (riga 51). Diverso da `Export\PdfByHtmlAction`. Test: Nessun test dedicato.

## Effetti collaterali

Scrittura PDF su disco tramite `PdfData`. In caso di `HtmlParsingException`, `PdfData` scrive un file `.html` di fallback e non segnala errore (comportamento di `Datas/PdfData.php:95-99`).

## Errori

Eccezioni diverse da `HtmlParsingException` risalgono al chiamante.

## Non fa

- Non gestisce `content`.
- Possibile `TypeError` se si passa un `PdfEngineEnum` di `Actions\Pdf` (stub con solo SPIPU) a `PdfData`, che tipizza `Modules\Xot\Enums\PdfEngineEnum`: da verificare con un'esecuzione, non provato in questo contract.
- La proprietà `$engine` è dichiarata e non usata.
