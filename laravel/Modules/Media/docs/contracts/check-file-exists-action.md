---
title: "CheckFileExistsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\S3\\CheckFileExistsAction"
qmd: "CheckFileExistsAction S3 headObject esistenza file 404 bool logging"
---

# CheckFileExistsAction

Dice se una chiave esiste nel bucket con `headObject`. Codice: `app/Actions/S3/CheckFileExistsAction.php:10-43`.

## Input

- `string $key`: chiave dell'oggetto.

## Output

- `bool`: `true` se la HEAD riesce; `false` se S3 risponde 404.

## Invarianti

- **CHECK-FILE-EXISTS-INV-1** — Solo lo status 404 produce `false`; ogni altro `S3Exception` viene registrato come errore e rilanciato.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:218-224` (solo classe, metodo e superclasse).
- **CHECK-FILE-EXISTS-INV-2** — Ogni esito è registrato a livello `info` (esistenza) o `error` (eccezione).
  Test: nessuno.

## Effetti collaterali

- Una richiesta HEAD di sola lettura e scrittura nel log.

## Errori

- `S3Exception` diverso da 404 rilanciato dopo il log.

## Non fa

- Un 403 (senza permesso di lista, S3 risponde così per un oggetto mancante) viene rilanciato, non tradotto in `false`.
- Non riprova le richieste.
