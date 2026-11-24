---
title: "GeneratePdfAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\GeneratePdfAction"
qmd: "GeneratePdfAction pdf html2pdf generazione output download content file orientamento A4"
---

# GeneratePdfAction

Genera un PDF da HTML con Html2Pdf, in una delle tre modalità di uscita. Codice: `app/Actions/GeneratePdfAction.php` (classe a riga 15, `execute()` a riga 15).

## Input

- `string $html`.
- `string $filename`.
- `string $orientation`: default `P`.
- `string $outputMode`: `download` (default), `content` o `file`.

## Output

- `string`: i byte del PDF (`content`), il nome/percorso passato (`file`), oppure il risultato di `Output()` (`download`).

## Invarianti

- `GENERATE-PDF-INV-1` — Formato A4, lingua `it`, `setTestTdInOnePage(false)`. Test: nessuno.
- `GENERATE-PDF-INV-2` — `content` produce `Output(filename.pdf, 'S')`: il suffisso `.pdf` è aggiunto. Test: nessuno.
- `GENERATE-PDF-INV-3` — `file` scrive il PDF nel percorso `$filename` così com'è. Test: nessuno.
- `GENERATE-PDF-INV-4` — Errori `Html2PdfException` pulisce il buffer e rilancia. Test: nessuno.

## Effetti collaterali

- `file`: scrittura su filesystem al percorso indicato.
- `download`: output diretto al browser tramite Html2Pdf.

## Errori

- `Html2PdfException` rilanciata dopo `clean()`.

## Non fa

- Non sanifica `$filename`: in modalità `file` un percorso con `..` o assoluto è scritto dove indicato. Il chiamante deve validarlo.
- Incoerenza: `content` aggiunge `.pdf`, `file` no.
- `download` ignora `$filename`.
