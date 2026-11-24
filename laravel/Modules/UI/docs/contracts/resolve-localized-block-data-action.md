---
title: "Contratto — ResolveLocalizedBlockDataAction (UI)"
type: contract
action: "Modules\UI\Actions\Block\ResolveLocalizedBlockDataAction"
tags: [contract, action, blocks, cms, localization]
created: 2026-11-24
updated: 2026-11-24
---

# ResolveLocalizedBlockDataAction (UI)

Sorgente: `app/Actions/Block/ResolveLocalizedBlockDataAction.php`. Perché è fatta così:
[ADR delega opzionale a Cms](../adr/optional-cms-delegation-for-block-data.md). Chiamante: `View/Components/Render/Block.php::render()`.

## Input

- `array<string, mixed> $viewParams`: il `data` del blocco, già con chiavi stringa.

## Output

- `array<string, mixed>`: i dati risolti da `Modules\Cms\Actions\ResolveLocalizedBlockDataAction::execute()`, oppure
  `$viewParams` invariato se Cms non c'è, se il resolver non ha `execute()` o se non ritorna un array.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| UI-BLOCKDATA-INV-1 | Con il resolver di Cms disponibile, l'output è il suo risultato (UI non aggiunge né toglie chiavi). | `UI-BLOCKDATA-INV-1` |
| UI-BLOCKDATA-INV-2 | Senza resolver utilizzabile l'input esce identico: l'assenza di Cms non è un errore. | `UI-BLOCKDATA-INV-2` |
| UI-BLOCKDATA-INV-3 | Le chiavi dell'output sono sempre stringhe (diventano variabili della vista). | `UI-BLOCKDATA-INV-3` |
| UI-BLOCKDATA-INV-4 | Nessun file di `UI/app` importa una classe `Modules\Cms\`: Cms è raggiunto solo per nome stringa. | `UI-BLOCKDATA-INV-4` |

## Effetti collaterali

- Nessuno proprio. Risolve dal container la classe di Cms; gli effetti sono quelli del resolver di Cms (che non scrive).

## Errori

- `UnexpectedValueException('Block view data must have string keys.')` se il resolver di Cms ritorna un array con chiavi
  non stringa. Le eccezioni del resolver di Cms risalgono invariate.

## Non fa

- Non localizza nulla da sé: la logica (URL e locale) è in `Modules/Cms/app/Actions/ResolveLocalizedBlockDataAction.php`.
- Non sceglie la vista né controlla che esista (`Render\Block`).
- Non mette in cache il risultato.
- Non va "irrobustita" con `use Modules\Cms\...` o con un `require` di Cms in `module.json`: rompe l'indipendenza di UI.
