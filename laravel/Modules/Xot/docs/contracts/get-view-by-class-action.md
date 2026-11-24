---
title: "GetViewByClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\GetViewByClassAction"
qmd: "GetViewByClassAction vista da classe kebab basename parametri ViewFacade pages executeOld"
---

# GetViewByClassAction

Crea una vista Blade il cui nome deriva dal basename della classe. Codice: `app/Actions/GetViewByClassAction.php` (classe a riga 17, `execute()` a riga 26). Il nome copia `View/GetViewByClassAction`: il contract locale descrive questa copia.

## Input

- `string $class`: FQCN.
- `array<string, mixed> $params`: parametri della vista.
- `?string $viewName`: nome esplicito.

## Output

- `View`.

## Invarianti

- `GET-VIEW-BY-CLASS-INV-1` — Senza `viewName` il nome è il kebab del basename della classe (senza modulo). Test: `tests/Unit/Actions/ViewActionsTest.php`, `tests/Unit/Actions/View/GetViewByClassActionTest.php`.
- `GET-VIEW-BY-CLASS-INV-2` — Il nome è passato a `ViewFacade::make` con i parametri. Test: come sopra.

## Effetti collaterali

Nessuno oltre alla creazione dell'oggetto vista.

## Errori

- Nessuno a questo livello: l'errore di vista mancante emerge al render.

## Non fa

- Non verifica l'esistenza della vista.
- `executeOld` ricava `modulo::pages.<kebab>` dal namespace, con `InvalidArgumentException` fuori da `Modules\`. Non è chiamato da `execute()`; nessun chiamante trovato nel perimetro: da verificare.
