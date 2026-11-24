---
title: "RegisterDynamicRoutesAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Route\\RegisterDynamicRoutesAction"
qmd: "RegisterDynamicRoutesAction registra route dinamiche risorse resource acts subs gruppo prefix namespace controller Assert"
---

# RegisterDynamicRoutesAction

Registra nel router le route descritte da un array di definizioni: risorsa, azioni extra e sotto-definizioni annidate. Codice: `app/Actions/Route/RegisterDynamicRoutesAction.php`.

## Input

- `array $array`: lista non vuota di definizioni. Chiavi usate: `name` (obbligatoria se mancano `prefix`/`controller`), `prefix`, `as`, `namespace`, `controller`, `only`, `param_name`, `acts` (lista con `name`, `act`, `method`), `subs` (lista ricorsiva).
- `?string $namespace`: non usato.
- `?string $namespaceStart`: namespace radice dei controller; se passato, sostituisce quello della prima chiamata sull'istanza.
- `?string $curr`: namespace corrente per le azioni extra.

## Output

- `void`. Effetto: route registrate nel router.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ROUTE-DYN-INV-1` | Un array vuoto lancia `Assert` con `The $array parameter cannot be empty.` | `tests/Unit/Actions/Route/RegisterDynamicRoutesActionTest.php` (riferisce la classe) |
| `ROUTE-DYN-INV-2` | Ogni elemento deve essere un array. | `tests/Unit/Actions/Route/RegisterDynamicRoutesActionTest.php` (riferisce la classe) |
| `ROUTE-DYN-INV-3` | La risorsa ha il parametro `id_<name>` (o `param_name`) vincolato a `[0-9]+`. | `tests/Unit/Actions/Route/RegisterDynamicRoutesActionTest.php` (riferisce la classe) |
| `ROUTE-DYN-INV-4` | Il nome delle route di risorsa è prefissato dal valore di `as` (es. `admin.user.index`). | `tests/Unit/Actions/Route/RegisterDynamicRoutesActionTest.php` (riferisce la classe) |
| `ROUTE-DYN-INV-5` | Le sotto-definizioni sono registrate ricorsivamente con il namespace corrente. | Test: nessuno esplicito |

## Effetti collaterali

- Registra route nel router globale: va chiamata in fase di registrazione route.
- Imposta `$namespaceStart` sull'istanza: il valore resta anche nelle chiamate successive sulla stessa istanza.

## Errori

- `Assert` (Webmozart) lancia per chiavi mancanti o di tipo errato.
- Un `name` assente con `prefix` assente genera un warning di chiave indefinita, poi un errore.

## Non fa

- Il parametro `$namespace` non è usato; `$group_opts` viene scritto nell'array locale e non serve.
- Non controlla duplicati di nome route.
- Lo stato `$namespaceStart` sull'istanza può contaminare chiamate successive sulla stessa istanza.
