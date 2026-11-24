---
title: "GetClassNameByPathAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\GetClassNameByPathAction"
qmd: "GetClassNameByPathAction nome classe FQCN da file PHP regex namespace class parsing"
---

# GetClassNameByPathAction

Ricava il FQCN di una classe leggendo il file PHP con regex (namespace e prima dichiarazione `class`). Codice: `app/Actions/File/GetClassNameByPathAction.php:12-28`.

## Input

- `string $path`: percorso del file PHP (`execute`, riga 16).

## Output

- `string`: `Namespace\Classe`, oppure `Classe` se manca il namespace, oppure `''` se manca la classe (righe 23-26).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-CLASSNAME-INV-1` | Il namespace è il primo match di `namespace\s+(.+);`; la classe è il primo match di `class\s+(\w+)`. | righe 18-24 | `tests/Unit/Actions/File/GetClassNameByPathActionTest.php:20,33` |
| `FILE-CLASSNAME-INV-2` | Solo la parola `class` è riconosciuta: `interface`, `trait` ed `enum` non lo sono. | riga 21 | come sopra (copertura non verificata) |

## Effetti collaterali

Nessuno. Lettura del file.

## Errori

- Le funzioni `Safe\*` lanciano se il file non si legge.

## Non fa

- Non usa un tokenizer. La prima occorrenza della parola `class` può trovarsi in un commento o in un docblock.
- Non gestisce più classi nello stesso file.
- Il blocco di commento in fondo al file è codice morto, lasciato dall'autore.
- Marker `@contract` aggiunto nel docblock della classe.
