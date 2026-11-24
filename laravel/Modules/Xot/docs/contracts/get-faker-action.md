---
title: "GetFakerAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Factory\\GetFakerAction"
qmd: "GetFakerAction espressione faker nome tipo colonna factory codice generato"
---

# GetFakerAction

Restituisce il frammento di codice Faker da usare per una colonna. Codice: `app/Actions/Factory/GetFakerAction.php` (classe a riga 22, `execute()` a riga 24).

## Input

- `string $name`: nome della colonna.
- `?string $type`: tipo della colonna.
- `?string $_table`: non usato.

## Output

- `string`: frammento PHP come testo, per esempio `$faker->safeEmail`.

## Invarianti

- `GET-FAKER-INV-1` — Se `type` inizia con `factory(`, è restituito così com'è. Test: nessuno.
- `GET-FAKER-INV-2` — Altrimenti il nome della colonna è cercato nella mappa dei nomi, poi il tipo nella mappa dei tipi, infine il default `$faker->word`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non genera valori: restituisce solo codice come testo.
- Ignora la tabella.
