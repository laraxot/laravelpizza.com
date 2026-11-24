---
title: "GenerateModelByModelClass — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Generate\\GenerateModelByModelClass"
qmd: "GenerateModelByModelClass generazione modello artisan module:make-model replace BaseModel HasXotFactory protected table fillable"
---

# GenerateModelByModelClass

Esegue `module:make-model` per un modello e riscrive il file generato: base class `BaseModel`, import HasXotFactory rimosso, eventuale `$table`.

Codice: `app/Actions/Generate/GenerateModelByModelClass.php:14-110`.

## Input

- `string $model_class`: classe già esistente (asserita con `Assert::classExists`).
- `array<string,string> $replaces` (proprietà pubblica), impostabile con `setCustomReplaces`.

## Output

`string`: il namespace con separatori `/` (riga 30).

## Invarianti

- `GEN-MODEL-INV-1`: chiama `module:make-model` prima di leggere e modificare il file (riga 33 e 84). Test: Nessun test dedicato.
- `GEN-MODEL-INV-2`: sostituisce ` extends Model` con ` extends BaseModel` e rimuove l'import `HasXotFactory` (righe 45-46). Test: Nessun test dedicato.
- `GEN-MODEL-INV-3`: scrive il file solo se il contenuto è cambiato (righe 49-51). Test: Nessun test dedicato.
- `GEN-MODEL-INV-4`: `replaceDummyTable` richiede `protected $fillable` nel file (asserito, riga 59-62) e aggiunge `protected $table` solo se manca (righe 64-68). Test: Nessun test dedicato.
- `GEN-MODEL-INV-5`: ogni chiave di `$replaces` è applicata solo se esiste il metodo `replace{Chiave}` (righe 38-41). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura su disco: creazione del modello via Artisan e riscrittura del file. Nessuna transazione.

## Errori

`Assert` per classe mancante o fillable assente; errori di Artisan si propagano.

## Non fa

- Il modello deve già esistere (`Assert::classExists` precede `generate`): da verificare cosa faccia `module:make-model` in quel caso.
- Il nome `$namespace` contiene percorsi con `/`, non un namespace.
- Il sostituto `BaseModel` è applicato con una stringa fissa.
