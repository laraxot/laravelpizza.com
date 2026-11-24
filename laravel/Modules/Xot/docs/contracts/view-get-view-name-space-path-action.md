---
title: "GetViewNameSpacePathAction (View) — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\View\\GetViewNameSpacePathAction"
qmd: "GetViewNameSpacePathAction View cartella resources views modulo nwidart resource_path null vuoto"
---

# GetViewNameSpacePathAction (View)

Restituisce la cartella delle viste di un modulo (`resources/views`), o quella globale `resource_path('views')` se il modulo non è indicato. Codice: `app/Actions/View/GetViewNameSpacePathAction.php:10-30`.

Nota: esiste una classe omonima in `Actions/File`, con firma e semantica diverse. Il contratto di quella è in `file-get-view-name-space-path-action.md`.

## Input

- `?string $module_name = null` (`execute`, riga 17).

## Output

- `string`: percorso della cartella (righe 19-28).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `VIEW-NSPATH-INV-1` | Modulo non nullo e non vuoto: `Module::getModulePath($modulo) . 'resources/views'`. La concatenazione non aggiunge separatore: dipende dal trailing slash restituito da nwidart. | righe 19-22 | Test: nessuno |
| `VIEW-NSPATH-INV-2` | Modulo nullo o vuoto: `resource_path('views')`. | righe 23-25 | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Le eccezioni di nwidart per modulo inesistente si propagano (dubbio: comportamento non verificato).

## Non fa

- Non verifica che la cartella `resources/views` esista.
- Marker `@contract` aggiunto nel docblock della classe.
