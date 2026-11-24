---
title: "FakeSeederAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ModelClass\\FakeSeederAction"
qmd: "FakeSeederAction seeder fake factory insert batch 50 limite 200 coda notifica HasFactory"
---

# FakeSeederAction

Inserisce record fittizi generati dalla factory del modello, a blocchi, con limite per chiamata e rinvio in coda del resto. Codice: `app/Actions/ModelClass/FakeSeederAction.php`.

## Input

- `string $modelClass`: FQCN di un modello con trait `HasFactory`.
- `int $qty`: numero di record richiesti.

## Output

- `void`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `MODEL-FAKE-INV-1` | Classe inesistente, non Eloquent o senza `HasFactory` lancia `\InvalidArgumentException`. | Test: nessuno |
| `MODEL-FAKE-INV-2` | In una chiamata inserisce al massimo 200 record (`min($qty, 200)`), in blocchi da 50. | Test: nessuno |
| `MODEL-FAKE-INV-3` | Se `$qty > 200`, il resto (`$qty - 200`) è accodato con `onQueue()`. | Test: nessuno |
| `MODEL-FAKE-INV-4` | Al termine invia una notifica Filament di successo con il numero di record. | Test: nessuno |

## Effetti collaterali

- Inserimenti con `Model::insert()` per blocco: bypassano eventi, observer e mutator Eloquent. Nessuna transazione: un errore a metà lascia i blocchi già inseriti.
- Notifica Filament (`Notification::make()->send()`) per ogni chiamata, anche in coda.
- Job in coda per il resto oltre 200.

## Errori

- `\InvalidArgumentException` per classe non valida o senza `HasFactory`.
- `\RuntimeException` se `factory()` non esiste (caso non raggiungibile dopo il controllo `HasFactory`).

## Non fa

- Non gestisce esplicitamente `$qty <= 0`: il comportamento dipende dalla factory e non è coperto da test.
- Il blocco commentato `getTableName` in fondo al file non è attivo.
