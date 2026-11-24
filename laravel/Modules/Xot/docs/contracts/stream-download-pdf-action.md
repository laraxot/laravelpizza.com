---
title: "StreamDownloadPdfAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Pdf\\StreamDownloadPdfAction"
qmd: "StreamDownloadPdfAction PDF download streaming HTML vista report prefisso Html2Pdf streamDownload"
---

# StreamDownloadPdfAction

Genera un PDF da HTML o da vista e restituisce una risposta di download in streaming.

Codice: `app/Actions/Pdf/StreamDownloadPdfAction.php:12-49`.

## Input

- `?string $html`, `?string $view`, `?array $data`.
- `string $filename` (default `my_doc.pdf`).

## Output

`StreamedResponse` da `response()->streamDownload`, con nome `report-{filename}`.

## Invarianti

- `PDF-STREAM-INV-1`: il nome del download è `report-` seguito dal filename (riga 47). Test: Nessun test dedicato.
- `PDF-STREAM-INV-2`: con `html` nullo e `view` valorizzata, la vista deve esistere; altrimenti `\Exception` "View ... not found" (righe 32-35). Test: Nessun test dedicato.
- `PDF-STREAM-INV-3`: l'HTML è convertito in PDF (`writeHTML`) prima di restituire la risposta; l'output avviene nel callback dello stream (riga 46). Test: Nessun test dedicato.

## Effetti collaterali

Nessuna scrittura su disco. L'output è emesso dalla libreria dentro lo stream.

## Errori

`\Exception` per vista mancante; `Assert` per HTML assente; eccezioni di `writeHTML` avvengono prima della risposta.

## Non fa

- Non salva il PDF.
- `$engine` è dichiarato e non usato.
