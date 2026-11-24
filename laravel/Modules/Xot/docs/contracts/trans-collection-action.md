---
title: "TransCollectionAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Collection\\TransCollectionAction"
qmd: "TransCollectionAction traduzione elementi collezione transKey fallback underscore SafeStringCastAction"
---

# TransCollectionAction

Traduce ogni elemento di una collezione tramite una chiave di traduzione, con fallback che sostituisce i punti con underscore.

Codice: `app/Actions/Collection/TransCollectionAction.php:26-75`.

## Input

- `Collection $collection`: elementi da tradurre.
- `?string $transKey`: prefisso di traduzione; se `null` non si traduce.

## Output

`Collection` di stringhe, stessa cardinalità dell'input.

## Invarianti

- `TRANS-COLL-INV-1`: con `transKey` nullo ogni elemento viene solo convertito in stringa con `SafeStringCastAction`, senza traduzione (righe 28-30). Test: tests/Unit/Actions/Collection/TransCollectionActionTest.php:35.
- `TRANS-COLL-INV-2`: con `transKey` prova `{transKey}.{item}`; se non esiste una stringa, prova `{transKey}.{item con . → _}`; se nessuna delle due esiste restituisce l'elemento originale (righe 55-74). Test: tests/Unit/Actions/Collection/TransCollectionActionTest.php:12 (caso positivo) e :44 (fallback).
- `TRANS-COLL-INV-3`: un elemento vuoto viene restituito senza tradurre (riga 50). Test: Nessun test dedicato.

## Effetti collaterali

Scrive la proprietà pubblica `$transKey` sull'istanza (riga 32): lo stato resta nell'oggetto anche dopo la chiamata. Nessun I/O oltre alla lettura delle traduzioni.

## Errori

Nessuna eccezione propria; le conversioni passano da `SafeStringCastAction`.

## Non fa

- `trans()` è pubblico e legge `$this->transKey`: se viene chiamato direttamente dopo un `execute()` con chiave, usa la chiave residua. Da verificare se è un uso previsto.
- Non esegue traduzioni con namespace di modulo diversi da quello indicato in `transKey`.
