---
title: "FixDoubleEncodedUtf8Action — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\String\\FixDoubleEncodedUtf8Action"
qmd: "FixDoubleEncodedUtf8Action UTF-8 doppia codifica mojibake Windows-1252 latin1 ripara testo"
---

# FixDoubleEncodedUtf8Action

Ripara il testo UTF-8 codificato due volte (es. `SÃ¬` → `Sì`) passando per Windows-1252. Codice: `app/Actions/String/FixDoubleEncodedUtf8Action.php`.

## Input

- `string $text`: testo da verificare.

## Output

- `string`: il testo riparato se la conversione è senza perdite e produce UTF-8 valido; altrimenti il testo originale invariato.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `STR-FIX-UTF8-INV-1` | Testo ASCII puro o non UTF-8 valido è restituito invariato. | `tests/Unit/Actions/String/FixDoubleEncodedUtf8ActionTest.php` (riferisce la classe) |
| `STR-FIX-UTF8-INV-2` | Testo UTF-8 pulito (es. `Città`) è restituito invariato. | `tests/Unit/Actions/String/FixDoubleEncodedUtf8ActionTest.php` (riferisce la classe) |
| `STR-FIX-UTF8-INV-3` | La riparazione è accettata solo se la conversione di andata e ritorno Windows-1252 riproduce il testo originale. | Test: nessuno esplicito |
| `STR-FIX-UTF8-INV-4` | Caratteri che Windows-1252 non rappresenta (es. emoji) fanno fallire la riparazione: il testo resta invariato. | Test: nessuno esplicito |

## Effetti collaterali

Nessuno. Funzione pura, nessuna scrittura.

## Errori

- Le conversioni usano `Safe\mb_convert_encoding`: un errore di conversione lancia eccezione della libreria Safe, non viene catturato.

## Non fa

- Applica un solo passaggio: non ripara triple codifiche.
- Non gestisce altri mojibake (solo doppia codifica via Windows-1252).
- Non modifica il database: lavora sul valore passato.
