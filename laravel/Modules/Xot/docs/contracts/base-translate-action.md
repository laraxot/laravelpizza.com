---
title: "BaseTranslateAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Translation\\BaseTranslateAction"
qmd: "BaseTranslateAction classe astratta traduzione firma execute provider DeepL Google Systran MyMemory Apertium"
---

# BaseTranslateAction

Classe astratta che fissa la firma comune dei provider di traduzione. Non è eseguibile direttamente.

Codice: `app/Actions/Translation/BaseTranslateAction.php:9-14`.

## Input

- Firma: `execute(string $text, string $from, string $to)`.

## Output

`string` (dalle sottoclassi).

## Invarianti

- `TRANS-BASE-INV-1`: la firma `execute(string, string, string): string` è obbligatoria per ogni provider (riga 13). Test: nessuno; la firma è garantita da PHP.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria.

## Non fa

- Non contiene logica di traduzione.
