---
title: "SendSmsAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\SendSmsAction"
qmd: "SendSmsAction dispatcher SMS driver engine SmsEngines reflection non esiste"
---

# SendSmsAction

Dispatcher SMS generico: risolve un motore per nome di driver e lo invoca via reflection.

## Input

- `array $vars`: `to`, `from`, `body` e altri campi (le chiavi stringa vengono unite alle proprieta').
- `string $driver = 'netfun'`.

## Output

- `array`: `$this->vars` unito ai valori restituiti da `getVars()` dell'engine.

## Invarianti

- `NOTIFY-SMSDISPATCH-INV-1`: il motore atteso e' `Modules\Notify\Actions\SMS\SmsEngines\{Driver}Engine`; se la classe non esiste lancia `RuntimeException`. Test: `tests/Unit/Actions/SMS/SendSmsActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-SMSDISPATCH-INV-2`: il motore deve avere `make()` e i metodi `setLocalVars`, `send`, `getVars`. Stesso test.

## Effetti collaterali

- Delega all'engine (non letto qui). Se il motore esiste, puo' inviare.

## Errori

- `RuntimeException` se la classe engine non esiste, se `make()` manca o se un metodo manca.
- `ReflectionException` riscritta come `RuntimeException`.

## Rischi rilevati

- La directory `SMS/SmsEngines` non esiste nel modulo: ogni chiamata lancia `RuntimeException` prima di inviare. La docblock (righe 21-25) dichiara il namespace legacy `Services\SmsEngines`, mai popolato. Action non funzionante.

## Non fa

- Non filtra le chiavi di `$vars` prima di passarle all'engine.
