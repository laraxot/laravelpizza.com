---
title: "PdfEngineEnum — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Pdf\\PdfEngineEnum"
qmd: "PdfEngineEnum enum engine PDF stub SPIPU duplicato Enums PdfEngineEnum SPATIE"
---

# PdfEngineEnum

Enum stub con il solo engine `SPIPU`, duplicato dell'enum `Modules\Xot\Enums\PdfEngineEnum`. Non è una Action.

Codice: `app/Actions/Pdf/PdfEngineEnum.php:12-19`.

## Input

- Nessuno (enum).

## Output

Valori: `SPIPU = 'spipu'`.

## Invarianti

- `PDF-ENUM-INV-1`: il valore unico è `spipu`; il commento dichiara lo stub temporaneo (righe 9-18). Test: tests/Unit/Actions/Pdf/PdfActionsTest.php, tests/Unit/XotHundredPercentCoverageTest.php (menzione).

## Effetti collaterali

Nessuno.

## Errori

Nessuna.

## Non fa

- Non implementa `HasLabel`, `HasIcon`, `HasColor`, a differenza di `Modules\Xot\Enums\PdfEngineEnum` che ha anche `SPATIE`.
- Duplicato: `Modules\Xot\Enums\PdfEngineEnum` è quello usato da `PdfData`. Candidato alla rimozione dopo verifica dei riferimenti.
