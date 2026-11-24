---
title: "GetViewBlocksOptionsByTypeAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\Block\\GetViewBlocksOptionsByTypeAction"
qmd: "GetViewBlocksOptionsByTypeAction blocchi vista components blocks opzioni glob moduli screenshot png AssetAction WIP"
---

# GetViewBlocksOptionsByTypeAction

Elenca i blocchi Blade di un tipo in tutti i moduli, restituendo vista→nome oppure vista→URL dello screenshot. Marcata WIP.

Codice: `app/Actions/Filament/Block/GetViewBlocksOptionsByTypeAction.php:21-107`.

## Input

- `string $type`: non vuoto.
- `bool $img`: se `true` restituisce l'URL dello screenshot `img/screenshots/{nome}.png`.

## Output

`array<string, string>`: chiave `{modulo}::components.blocks.{tipo}.{nome}`; valore nome oppure URL.

## Invarianti

- `FIL-BLOCKS-INV-1`: un tipo vuoto fa fallire `Assert::stringNotEmpty` (riga 34). Test: Nessun test dedicato.
- `FIL-BLOCKS-INV-2`: i blocchi sono cercati con glob in `Modules/*/resources/views/components/blocks/{tipo}/*.blade.php` (righe 39-40). Test: Nessun test dedicato.
- `FIL-BLOCKS-INV-3`: con `$img = true` ogni screenshot passa da `AssetAction`, che lancia `Exception` se il PNG manca; non c'è gestione locale, quindi un solo PNG mancante fa fallire l'intera mappa (righe 82-89). Test: Nessun test dedicato.

## Effetti collaterali

Solo lettura del filesystem e risoluzione URL. Nessuna copia di file.

## Errori

`Assert` per input e percorsi; `Exception` di `AssetAction` per screenshot mancante.

## Non fa

- Il docblock indica stato WIP.
- Il nome del modulo è ricavato dal percorso con separatori di sistema.
