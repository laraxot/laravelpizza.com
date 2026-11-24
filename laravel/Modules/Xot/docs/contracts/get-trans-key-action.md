---
title: "GetTransKeyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\GetTransKeyAction"
qmd: "GetTransKeyAction chiave traduzione backtrace modulo classe Filament risorsa pagina snake kebab"
---

# GetTransKeyAction

Costruisce la chiave di traduzione `modulo::chiave` a partire da una classe, o dallo stack di chiamata se la classe non appartiene a un modulo. Codice: `app/Actions/GetTransKeyAction.php` (classe a riga 17, `execute()` a riga 20).

## Input

- `string $class = ''`: FQCN. Se vuoto, si usa il chiamante dallo stack.

## Output

- `string`: `modulo::chiave`, con modulo in minuscolo.

## Invarianti

- `GET-TRANS-KEY-INV-1` — Con classe di modulo `Modules\<M>\...`: modulo = segmento 1 in minuscolo; tipo = singolare del penultimo segmento; il suffisso del tipo è rimosso dal nome; poi snake. Test: `tests/Unit/Actions/GetTransKeyActionTest.php`.
- `GET-TRANS-KEY-INV-2` — Un prefisso verbale (`dashboard`, `list`, `get`, `manage`, `edit`, `view`, `create`) è rimosso, così come il suffisso `action` e `form_schema`. Per `list` il risultato è al singolare. Test: come sopra.
- `GET-TRANS-KEY-INV-3` — Fuori da `Modules\`, il chiamante viene cercato nello stack; se non c'è, la chiave è `<main_module>::<pagina snake>` dal primo argomento del backtrace. Test: `tests/Feature/Filament/XotBaseResourceCoverageTest.php` (menzione).

## Effetti collaterali

Lettura di `debug_backtrace()` e della configurazione del modulo principale (`XotData`).

## Errori

- `Webmozart` se il nome di classe o la pagina non sono stringhe.

## Non fa

- Dipende dalla forma del namespace e dallo stack: cambi di struttura producono chiavi sbagliate senza errore.
- Il ramo di backtrace è fragile per natura: va usato solo dove la classe non è nota.
