---
title: "SanitizeAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\String\\SanitizeAction"
qmd: "SanitizeAction sanitize strip_tags html_entity_decode trim testo"
---

# SanitizeAction

Rimuove i tag HTML, decodifica le entità e applica `trim`. Codice: `app/Actions/String/SanitizeAction.php`.

## Input

- `string $str`: testo potenzialmente con HTML.

## Output

- `string`: testo senza tag, con entità decodificate, senza spazi ai bordi.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `STR-SANITIZE-INV-1` | Il risultato non contiene tag HTML letterali presenti nell'input prima della decodifica. | `tests/Unit/Actions/String/SanitizeActionTest.php` (riferisce la classe) |
| `STR-SANITIZE-INV-2` | Il risultato non ha spazi iniziali o finali. | `tests/Unit/Actions/String/SanitizeActionTest.php` (riferisce la classe) |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non è sicuro come output HTML: `html_entity_decode` avviene dopo `strip_tags`, quindi entità come `&lt;script&gt;` tornano `<script>` nel risultato. Chi stampa il risultato in HTML deve fare escape.
- Il blocco di codice commentato in fondo al file (`htmlspecialchars`, `preg_replace`) non è attivo.
