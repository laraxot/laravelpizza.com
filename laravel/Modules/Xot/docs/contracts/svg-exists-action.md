---
title: "SvgExistsAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\SvgExistsAction"
qmd: "SvgExistsAction verifica esistenza icona SVG BladeUI Icons heroicon set registrato"
---

# SvgExistsAction

Verifica se un'icona SVG esiste nei set registrati di BladeUI Icons. Codice: `app/Actions/File/SvgExistsAction.php:15-39`.

## Input

- `string $svgName`: nome dell'icona, es. `heroicon-o-user` (`execute`, riga 23).

## Output

- `bool`: `true` se l'icona esiste (riga 37), `false` altrimenti.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-SVG-INV-1` | Stringa vuota: `false` senza interrogare il factory. | righe 25-27 | `tests/Unit/Actions/File/SvgExistsActionTest.php:14` |
| `FILE-SVG-INV-2` | `IconFactory::svg($name)` senza eccezione: `true`. Un'eccezione `\Exception`: `false`. | righe 30-37 | `tests/Unit/Actions/File/SvgExistsActionTest.php:7` |

## Effetti collaterali

Nessuno. Lettura del registro delle icone.

## Errori

- Nessuna eccezione: ogni errore diventa `false`.

## Non fa

- Non distingue il motivo del `false` (set mancante o nome errato).
- Marker `@contract` aggiunto nel docblock della classe.
