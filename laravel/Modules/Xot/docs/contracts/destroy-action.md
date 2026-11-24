---
title: "DestroyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\DestroyAction"
qmd: "DestroyAction elimina modello delete flash status sessione eliminato"
---

# DestroyAction

Cancella il modello passato e segnala l'esito in sessione. Codice: `app/Actions/Model/DestroyAction.php`.

## Input

- `Model $model`: il modello da cancellare.
- `array<string, mixed> $_data` e `array<string, mixed> $_rules`: non usati dal corpo.

## Output

- `Model`: lo stesso modello ricevuto, anche quando `delete()` ritorna `false`.

## Invarianti

- `DESTROY-INV-1` — Viene chiamato `$model->delete()` e in base al risultato la sessione riceve `status = 'eliminato'` (true) o `status = 'NON eliminato'` (false). Prova: `execute()`. Test: `tests/Unit/Actions/Model/DestroyActionTest.php`.
- `DESTROY-INV-2` — Il ritorno è sempre il modello in input. Prova: `execute()`. Test: `tests/Unit/Actions/Model/DestroyActionTest.php`.

## Effetti collaterali

Un `DELETE` (soft o hard secondo il trait del modello) e una scrittura in sessione tramite `Session::flash('status', ...)`. Nessuna transazione, nessun evento proprio, nessuna coda.

## Errori

- Nessuna eccezione propria. Le eccezioni di `delete()` (es. database) si propagano.

## Non fa

- Non verifica autorizzazioni.
- Non cancella né scollega relazioni pivot. Il commento `DA FIXARE` nel corpo di `execute()` segnala un dubbio non risolto su pivot e chiavi sfasate: non è un fatto verificato.
- Ignora `$_data` e `$_rules`.
