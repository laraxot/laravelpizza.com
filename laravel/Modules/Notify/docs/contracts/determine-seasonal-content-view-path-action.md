---
title: "DetermineSeasonalContentViewPathAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\DetermineSeasonalContentViewPathAction"
qmd: "DetermineSeasonalContentViewPathAction vista stagionale email natale pasqua estate halloween sixteen emails"
---

# DetermineSeasonalContentViewPathAction

Sceglie la vista del contenuto email in base alla data corrente (Carbon::now) e restituisce il namespace di vista `sixteen::emails.<nome>`.

## Input

- `string $defaultViewName = 'base-content'`: vista usata fuori dai periodi stagionali.

## Output

- `string`: `sixteen::emails.<vista>`, con vista tra `christmas-content`, `easter-content`, `summer-content`, `halloween-content` o `$defaultViewName`.

## Invarianti

- `NOTIFY-SEASONAL-INV-1`: 1 dicembre - 10 gennaio restituisce `christmas-content`. Test: `tests/Unit/Actions/DetermineSeasonalContentViewPathActionTest.php` (file dedicato, asserti non verificati).
- `NOTIFY-SEASONAL-INV-2`: da Pasqua - 2 giorni a Pasqua + 1 giorno restituisce `easter-content`; la Pasqua e' calcolata con l'algoritmo gregoriano (righe 75-94). Stesso test.
- `NOTIFY-SEASONAL-INV-3`: 15 luglio - 31 agosto restituisce `summer-content`. Stesso test.
- `NOTIFY-SEASONAL-INV-4`: 25 ottobre - 1 novembre restituisce `halloween-content`. Stesso test.
- `NOTIFY-SEASONAL-INV-5`: negli altri casi restituisce `$defaultViewName`. Stesso test.
- Ordine di priorita' reale: Natale, Pasqua, estate, Halloween (la prima condizione vera vince).

## Effetti collaterali

- Nessuno. Legge solo l'orologio di sistema.

## Errori

- `Assert::isInstanceOf` su `getEasterDate` lancia se Carbon non viene restituito (non atteso).

## Non fa

- Non verifica che la vista esista su disco.
- Non usa il fuso orario dell'applicazione in modo esplicito: `Carbon::now()` segue la configurazione corrente.
