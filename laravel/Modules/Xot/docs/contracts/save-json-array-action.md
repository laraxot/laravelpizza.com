---
title: "Contratto — SaveJsonArrayAction"
type: contract
action: "Modules\Xot\Actions\Arr\SaveJsonArrayAction"
tags: [contract, action, file, array, json]
created: 2026-11-24
updated: 2026-11-24
---

# SaveJsonArrayAction

Sorgente: `app/Actions/Arr/SaveJsonArrayAction.php`. Si chiama di solito tramite [SaveArrayAction](save-array-action.md)
con `'json'`; la usano i model che tengono le righe su file JSON del tenant (`Tenant/app/Actions/Json/*`).

## Input

- `array<int|string, mixed> $data`.
- `string $filename`: percorso assoluto.

## Output

- `bool`: `true` a scrittura riuscita.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| XOT-SAVE-JSON-INV-1 | Il file decodificato (`json_decode(…, true)`) ritorna esattamente `$data`, anche quando è `[]`. | `XOT-SAVE-JSON-INV-1` |
| XOT-SAVE-JSON-INV-2 | La cartella del file viene creata se manca (installazione nuova di un tenant). | — |

## Effetti collaterali

- `File::ensureDirectoryExists(dirname($filename))`: può creare cartelle.
- `Safe\file_put_contents` con `JSON_PRETTY_PRINT`: sovrascrive il file intero.

## Errori

- `Safe\Exceptions\JsonException` se `$data` non è codificabile (UTF-8 non valido, risorse).
- `Safe\Exceptions\FilesystemException` se il file non è scrivibile.

## Non fa

- Non usa `JSON_UNESCAPED_UNICODE` né `JSON_UNESCAPED_SLASHES`: accenti e `/` escono come `è` e `\/`.
- Non distingue lista da oggetto per un array vuoto: `[]` si scrive come `[]`, mai `{}`.
- Non scrive in modo atomico né prende lock.
