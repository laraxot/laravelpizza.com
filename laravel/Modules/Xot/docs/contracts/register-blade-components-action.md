---
title: "RegisterBladeComponentsAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Blade\\RegisterBladeComponentsAction"
qmd: "RegisterBladeComponentsAction registra componenti Blade anonimi namespace prefisso GetComponentsAction Blade::component"
---

# RegisterBladeComponentsAction

Registra nel compilatore Blade i componenti trovati sotto un percorso, con namespace e prefisso.

Codice: `app/Actions/Blade/RegisterBladeComponentsAction.php:16-30`.

## Input

- `string $path`: cartella da scandire.
- `string $namespace`: namespace base; all'interno si aggiunge `\View\Components`.
- `string $prefix`: prefisso dei tag (default stringa vuota).

## Output

`void`.

## Invarianti

- `BLADE-REG-INV-1`: se `GetComponentsAction` non restituisce elementi, non registra nulla e rientra (riga 20-22). Test: tests/Unit/Actions/Blade/RegisterBladeComponentsActionTest.php:42.
- `BLADE-REG-INV-2`: registra con `Blade::component` solo gli elementi `ComponentFileData`; gli altri vengono saltati senza errore (righe 24-29). Test: tests/Unit/Actions/Blade/RegisterBladeComponentsActionTest.php:17 copre solo il caso positivo.

## Effetti collaterali

Lettura filesystem tramite `GetComponentsAction`. Scrittura nello stato globale del compilatore Blade (vale per il processo corrente). Nessuna transazione, evento, coda o servizio esterno.

## Errori

Nessuna eccezione propria; gli errori di `GetComponentsAction` si propagano.

## Non fa

- Non valida che `$path` esista: la verifica è delegata a `GetComponentsAction`.
- Non deregistra né deduplica componenti già registrati.
