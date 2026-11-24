---
title: "PdfByHtmlAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\PdfByHtmlAction"
qmd: "PdfByHtmlAction Export PDF HTML Html2Pdf Storage disk download content path orientamento"
---

# PdfByHtmlAction

Converte HTML in PDF, lo salva su disco e restituisce un download, il contenuto o il percorso in base a `$out`. Versione in namespace Export (duplicata da `Pdf\PdfByHtmlAction` con engine diverso).

Codice: `app/Actions/Export/PdfByHtmlAction.php:12-40`.

## Input

- `string $html`.
- `string $filename` (default `my_doc.pdf`), `string $disk` (default `cache`), `string $out` (`download` | `content` | altro), `string $orientation` (default `L`).

## Output

`string|BinaryFileResponse`: download (`download`), stringa binaria PDF (`content`), percorso (altri valori).

## Invarianti

- `EXP-PDF-INV-1`: il PDF è sempre scritto in `Storage::disk($disk)->path($filename)` prima di ritornare, per ogni valore di `$out` (righe 27-28). Test: nessuno dedicato; tests/Unit/Actions/Pdf/PdfActionsTest.php:11 menziona la classe (namespace da verificare).
- `EXP-PDF-INV-2`: `content` restituisce il binario e lascia comunque il file su disco (riga 36). Test: Nessun test dedicato.
- `EXP-PDF-INV-3`: un `HtmlParsingException` non viene catturato: risale al chiamante (riga 25, commento). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura del file PDF su disco. Il download restituito non cancella il file. Nessuna transazione o evento.

## Errori

Le eccezioni di Html2Pdf risalgono al chiamante.

## Non fa

- Non crea la directory del disco.
- Non elimina il file dopo il download.
- Il default di orientamento è `L` (diverso dal default `P` di `Pdf\PdfByHtmlAction`).
- Il commento `// D` sulla riga 36 è residuo.
