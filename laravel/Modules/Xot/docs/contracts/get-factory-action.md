---
title: "GetFactoryAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Factory\\GetFactoryAction"
qmd: "GetFactoryAction factory modello risolve carica file module:make-factory generazione Artisan require_once"
---

# GetFactoryAction

Risolve la factory di un modello, caricandola da disco o generandola con `module:make-factory`. Codice: `app/Actions/Factory/GetFactoryAction.php` (classe a riga 26, `execute()` a riga 43).

## Input

- `class-string<TModel> $model_class`: FQCN del modello.

## Output

- `Factory<TModel>`: istanza ottenuta con `Factory::new()`.

## Invarianti

- `GET-FACTORY-INV-1` — Il modello deve esistere. Test: nessuno.
- `GET-FACTORY-INV-2` — La classe factory è `<Modulo>\Database\Factories\<Nome>Factory`, derivata dal nome del modello. Test: nessuno.
- `GET-FACTORY-INV-3` — Se la classe non è caricata, il file `module_path(<Modulo>, database/factories/<Nome>Factory.php)` è incluso con `require_once` se esiste. Test: nessuno.
- `GET-FACTORY-INV-4` — Se ancora manca, si esegue `module:make-factory` e si ricarica; se la classe continua a mancare, lancia. Test: nessuno.

## Effetti collaterali

Caricamento di file PHP. Se la factory manca, `Artisan::call('module:make-factory')` scrive un file nel modulo sul disco.

## Errori

- `InvalidArgumentException` se il modulo non è determinabile dal namespace; `Assert` su classe mancante.

## Non fa

- Non verifica il contenuto della factory.
- La generazione su disco può avvenire anche in produzione se la factory manca: da valutare.
