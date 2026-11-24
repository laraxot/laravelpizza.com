---
title: "GetPropertiesFromMethodsByModelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Factory\\GetPropertiesFromMethodsByModelAction"
qmd: "GetPropertiesFromMethodsByModelAction belongsTo relazioni factory foreign key sorgente metodo reflection"
---

# GetPropertiesFromMethodsByModelAction

Cerca nei metodi del modello le relazioni `belongsTo` e propone la chiave esterna con la factory del correlato. Codice: `app/Actions/Factory/GetPropertiesFromMethodsByModelAction.php` (classe a riga 30, `execute()` a riga 38).

## Input

- `Model $model`.

## Output

- `array<string, string>`: chiave esterna => frammento `factory(Classe::class)`.

## Invarianti

- `GET-PROPS-METHODS-INV-1` — Sono considerati i metodi non `get*` e non definiti in `Model`. Test: nessuno diretto (`tests/Unit/XotExecuteCoverage50Test.php` menziona la classe).
- `GET-PROPS-METHODS-INV-2` — Il corpo del metodo è letto dal file sorgente e il metodo è considerato solo se contiene `$this->belongsTo(`. Test: come sopra.
- `GET-PROPS-METHODS-INV-3` — La relazione è ottenuta eseguendo il metodo sul modello. Test: come sopra.
- `GET-PROPS-METHODS-INV-4` — Ogni eccezione per metodo è ignorata. Test: non verificato.

## Effetti collaterali

Esegue metodi del modello, che possono avere effetti. Legge file sorgente. Nessuna scrittura.

## Errori

- Nessuno propagato: tutte le eccezioni sono ingoiate.

## Non fa

- Considera solo `belongsTo`.
- Esclude i metodi il cui nome inizia con `get`.
- Il rilevamento è una ricerca testuale sul sorgente: un `belongsTo` scritto diversamente non è trovato.
