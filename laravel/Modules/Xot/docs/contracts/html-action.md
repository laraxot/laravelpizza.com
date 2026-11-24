---
title: "HtmlAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\HtmlAction"
qmd: "HtmlAction toPdf html pdf output show file content debug request storage test.pdf"
---

# HtmlAction

Converte HTML in PDF con Html2Pdf, o restituisce l'HTML in modalità debug. Codice: `app/Actions/HtmlAction.php` (classe a riga 17, `toPdf()` statico).

## Input

- `string $html`.
- `string $out = 'show'`: `content_PDF`, `file` o altro (default: invio al browser).
- `string $pdforientation = 'L'`.
- `string $filename = ''`: se vuoto usa `storage/app/test.pdf` (disco `local`).

## Output

- `string`: il PDF (`content_PDF`), il percorso (`file`), il risultato di `Output()` (default), oppure l'HTML se il parametro `debug` è attivo.

## Invarianti

- `HTML-ACTION-INV-1` — Con il parametro di request `debug` valorizzato, il risultato è `$html` e nessun PDF è generato. Test: nessuno.
- `HTML-ACTION-INV-2` — `content_PDF` restituisce i byte; `file` scrive `$filename` e lo restituisce. Test: nessuno.
- `HTML-ACTION-INV-3` — Errori Html2Pdf: `clean()` e rilancio. Test: nessuno.

## Effetti collaterali

- `file`: scrittura del PDF nel percorso.
- Default: output diretto al browser.

## Errori

- `Html2PdfException` rilanciata.

## Non fa

- Non sanifica `$filename`.
- Dubbio di sicurezza: `?debug=1` restituisce l'HTML sorgente a qualunque richiedente che lo passi, in qualunque ambiente. Da verificare e, se confermato, limitare.
