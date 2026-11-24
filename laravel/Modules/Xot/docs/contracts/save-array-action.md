---
title: "Contratto — SaveArrayAction"
type: contract
action: "Modules\Xot\Actions\Arr\SaveArrayAction"
tags: [contract, action, file, array, config, translations]
created: 2026-11-24
updated: 2026-11-24
---

# SaveArrayAction

Sorgente: `app/Actions/Arr/SaveArrayAction.php`. Unico punto con cui i moduli scrivono un array su file: file di
traduzione (`Lang/app/Actions/SaveTransAction.php`, `PublishTranslationAction.php`), config dei tenant
(`Tenant/app/Actions/Config/SaveTenantConfigAction.php`), righe JSON dei model "su file"
(`Tenant/app/Actions/Json/{Create,Update,Delete}JsonFileByRecordAction.php`), config di modulo
(`Xot/app/Filament/Resources/ModuleResource/Pages/EditModule.php`).

## Input

- `array<int|string, mixed> $data`: l'array completo da scrivere (non un delta).
- `string $filename`: percorso assoluto del file.
- `string $format`: `'php'` (default) o `'json'`.

## Output

- `bool`: `true` se il file è stato scritto (in pratica sempre: un errore di scrittura è un'eccezione).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| XOT-SAVE-ARRAY-INV-1 | Senza `$format` scrive PHP (`<?php … return [...]`) rileggibile con `require` allo stesso array. | `XOT-SAVE-ARRAY-INV-1` |
| XOT-SAVE-ARRAY-INV-2 | Con `'json'` scrive JSON che `json_decode(…, true)` riporta allo stesso array. | `XOT-SAVE-ARRAY-INV-2` |
| XOT-SAVE-ARRAY-INV-3 | Un formato diverso da `php`/`json` è un'eccezione, mai un file scritto in un formato a caso. | `XOT-SAVE-ARRAY-INV-3` |

## Effetti collaterali

- Delega a [SavePhpArrayAction](save-php-array-action.md) o [SaveJsonArrayAction](save-json-array-action.md): **sovrascrive**
  il file intero.

## Errori

- `InvalidArgumentException('Formato non supportato: <format>')` per un formato sconosciuto.
- Le eccezioni delle Action delegate (`Safe\Exceptions\FilesystemException`, `JsonException`).

## Non fa

- Non unisce con il contenuto esistente: chi vuole aggiornare una chiave legge, modifica e passa l'array completo.
- Non fa backup, non scrive in modo atomico, non prende lock: due scritture concorrenti sullo stesso file, vince l'ultima.
- Non valida il percorso: chi chiama decide dove si scrive (mai un percorso preso da input utente senza controllo).
- Non invalida cache di config o traduzioni (`config:cache`, cache delle traduzioni): lo fa il chiamante se serve.
