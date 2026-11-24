---
title: "HtmlToPdfAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Html\\HtmlToPdfAction"
qmd: "HtmlToPdfAction HTML PDF Html2Pdf spipu output show file content_PDF debug storage local test.pdf"
---

# HtmlToPdfAction

Converte HTML in PDF con Html2Pdf, con tre modalità di output selezionate dal parametro `$out`.

Codice: `app/Actions/Html/HtmlToPdfAction.php:21-61`.

## Input

- `string $html`: contenuto da convertire.
- `string $out`: `show` (default), `file`, `content_PDF`.
- `string $pdforientation`: default `L`.
- `string $filename`: default `Storage::disk('local')->path('test.pdf')`.

## Output

`string`: HTML (se `debug`), binario PDF (`content_PDF`), percorso (`file`) o output di `Html2Pdf::Output()` (altri valori).

## Invarianti

- `HTML-PDF-INV-1`: con `$filename` vuoto il file di destinazione è sempre `local/test.pdf` (righe 31-33): non è unico. Test: Nessun test dedicato.
- `HTML-PDF-INV-2`: se la request contiene `debug` truthy, ritorna l'HTML senza generare PDF (righe 35-37). Test: Nessun test dedicato.
- `HTML-PDF-INV-3`: `content_PDF` restituisce il binario con nome `{filename}.pdf`; `file` scrive in `{filename}` e ritorna `{filename}`; altri valori usano `Output()` senza argomenti (righe 43-53). Test: Nessun test dedicato.

## Effetti collaterali

Modalità `file`: scrittura su disco (`Output(..., 'F')`). Modalità predefinita: l'output viene emesso direttamente dalla libreria. Nessuna transazione, evento o coda.

## Errori

Rilancia `Html2PdfException`. Bug: il `catch` (riga 55) chiama `$html2pdf->clean()` su una variabile che può non essere definita se il costruttore lancia, quindi l'errore si trasforma in un altro `Error`.

## Non fa

- Non passa da `PdfByHtmlAction`: il docblock spiega il motivo (conflitto di `PdfEngineEnum` duplicato).
- Non valida `$pdforientation`.
- Le modalità `content_PDF` e `file` non usano lo stesso nome file (con e senza `.pdf`).
