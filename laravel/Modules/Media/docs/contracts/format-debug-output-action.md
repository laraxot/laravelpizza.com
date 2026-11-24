---
title: "FormatDebugOutputAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\FormatDebugOutputAction"
qmd: "FormatDebugOutputAction formatta output diagnostica testo blocchi title status data"
---

# FormatDebugOutputAction

Trasforma i blocchi di diagnostica in testo leggibile. Codice: `app/Actions/Diagnostic/S3/FormatDebugOutputAction.php:18-102`.

## Input

- `array<string, mixed> $debugResults`: lista di blocchi con `title`, `status`, `data`.
- `string $emptyMessage`: testo restituito se la lista è vuota.

## Output

- `string`: blocchi uniti con `\n`. Ogni blocco ha intestazione `=== title ===`, riga `Status:`, righe `chiave: valore` (array in JSON indentato) e una linea di 50 trattini.

## Invarianti

- **FORMAT-DEBUG-OUTPUT-INV-1** — Lista vuota → `$emptyMessage` invariato.
  Test: `tests/Unit/Actions/Diagnostic/FormatDebugOutputActionTest.php:19`.
- **FORMAT-DEBUG-OUTPUT-INV-2** — Un blocco senza `title`, `status` o `data` (anche se `null`) viene ignorato in silenzio.
  Test: nessuno.
- **FORMAT-DEBUG-OUTPUT-INV-3** — Valori non stringa né scalari né `Stringable` diventano stringa vuota.
  Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- Nessuno dichiarato. `Safe\json_encode` lancia se la codifica fallisce.

## Non fa

- Non applica escape: il testo è destinato a un blocco preformattato, non a HTML.
