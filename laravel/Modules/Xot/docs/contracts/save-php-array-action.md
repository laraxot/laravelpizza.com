---
title: "Contratto — SavePhpArrayAction"
type: contract
action: "Modules\Xot\Actions\Arr\SavePhpArrayAction"
tags: [contract, action, file, array, php, code-style]
created: 2026-11-24
updated: 2026-11-24
---

# SavePhpArrayAction

Sorgente: `app/Actions/Arr/SavePhpArrayAction.php`. Si chiama di solito tramite [SaveArrayAction](save-array-action.md).
Il docblock spiega perché non usa `var_export`/VarExporter sull'array intero: i file scritti (traduzioni, config) sono
poi letti e modificati da persone e devono rispettare lo stile del repository.

## Input

- `array<int|string, mixed> $data`.
- `string $filename`: percorso assoluto; la cartella deve esistere.

## Output

- `bool`: `true` a scrittura riuscita.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| XOT-SAVE-PHP-INV-1 | Il file rilletto con `require` ritorna esattamente `$data`. | `XOT-SAVE-PHP-INV-1` |
| XOT-SAVE-PHP-INV-2 | Il file inizia con `<?php` e `declare(strict_types=1);`. | `XOT-SAVE-PHP-INV-2` |
| XOT-SAVE-PHP-INV-3 | Una chiave per riga a ogni livello: un array annidato non è mai scritto inline. | `XOT-SAVE-PHP-INV-3` |

## Effetti collaterali

- `Safe\file_put_contents($filename, …)`: sovrascrive il file intero.

## Errori

- `Safe\Exceptions\FilesystemException` se la cartella non esiste o il file non è scrivibile.

## Non fa

- Non crea la cartella (a differenza di `SaveJsonArrayAction`).
- Non esporta oggetti in modo rileggibile: un valore oggetto passa per `var_export` e produce `\Class::__set_state(...)`;
  passare solo scalari e array.
- Non conserva commenti o formattazione del file precedente.
- Non invalida l'opcache del file scritto.
