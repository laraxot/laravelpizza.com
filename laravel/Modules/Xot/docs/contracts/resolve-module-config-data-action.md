---
title: "ResolveModuleConfigDataAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Config\\ResolveModuleConfigDataAction"
qmd: "ResolveModuleConfigDataAction classe modulo ConfigData Datas make Spatie Data dataClassFor null"
---

# ResolveModuleConfigDataAction

Dalla classe di un modello, Resource o pagina di un modulo, risolve la sua `{Modulo}ConfigData` e ne restituisce un'istanza. Codice: `app/Actions/Config/ResolveModuleConfigDataAction.php:18-58`.

## Input

- `string $class`: FQCN di una classe di un modulo (`execute`, riga 22). Per `dataClassFor`: stesso input (riga 39).

## Output

- `?Data`: istanza di `{Modulo}ConfigData`, oppure `null` (righe 22-32).
- `dataClassFor()` (statico): `class-string<Data>|null`, il FQCN della ConfigData (righe 39-58).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `CONFIG-RESOLVE-INV-1` | Una classe che non inizia con `Modules\` non ha ConfigData: `null`. | righe 43-45 | `tests/Unit/Actions/Config/ResolveModuleConfigDataActionTest.php:15,16` |
| `CONFIG-RESOLVE-INV-2` | Il nome atteso è `Modules\{Modulo}\Datas\{Modulo}ConfigData`: deve esistere ed estendere `Spatie\LaravelData\Data`, altrimenti `null`. | righe 47-57 | `tests/Unit/Actions/Config/ResolveModuleConfigDataActionTest.php:24` |
| `CONFIG-RESOLVE-INV-3` | Se la classe ha il metodo `make`, lo chiama e ritorna il risultato solo se è un `Data`. | righe 25-31 | `tests/Unit/Actions/Config/ResolveModuleConfigDataActionTest.php:16` |

## Effetti collaterali

Nessuno proprio. `make()` della ConfigData può leggere la configurazione del tenant: non verificato.

## Errori

- Nessuna eccezione propria. Le eccezioni di `make()` e dell'autoload si propagano.

## Non fa

- Non mette in cache il risultato.
- Non verifica che il file di configurazione del tenant esista.
- Marker `@contract` aggiunto nel docblock della classe.
