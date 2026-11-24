---
title: "MakePdfSpatieTestAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Pdf\\MakePdfSpatieTestAction"
qmd: "MakePdfSpatieTestAction PDF test spatie laravel-pdf Browsershot download StreamedResponse vista xot pdf spatie-test"
---

# MakePdfSpatieTestAction

Costruisce una risposta di download PDF di prova con `spatie/laravel-pdf` (Browsershot) da una vista di test.

Codice: `app/Actions/Pdf/MakePdfSpatieTestAction.php:14-89`.

## Input

- `array $data`: payload della vista.
- `string $filename` (default `spatie-pdf-test.pdf`).
- `string $view` (default `xot::pdf.spatie-test`).

## Output

`StreamedResponse` con `Content-Type: application/pdf` e `Content-Disposition: attachment`.

## Invarianti

- `PDF-SPATIE-INV-1`: se la facciata `Spatie\LaravelPdf\Facades\Pdf` non esiste lancia `RuntimeException` (righe 47-50). Test: Nessun test dedicato.
- `PDF-SPATIE-INV-2`: il builder è formato `a4`, con nome file e `showBackground`; i binari Node, npm e Chrome sono impostati solo se presenti in config (righe 62-86). Test: tests/Unit/Actions/Pdf/MakePdfSpatieTestActionTest.php:12 (caso positivo).
- `PDF-SPATIE-INV-3`: il PDF è generato nel callback dello stream (`base64()` alla riga 32): il rendering avviene durante l'invio, non prima della risposta. Test: Nessun test dedicato.

## Effetti collaterali

Esecuzione di Browsershot (processo Chromium esterno) durante lo stream. Lettura di `config(laravel-pdf.browsershot.*)`. Nessuna scrittura su disco.

## Errori

`RuntimeException` per facciata assente o builder non valido; errori di Browsershot compaiono durante lo stream, dopo che la risposta è stata creata.

## Non fa

- Non salva il PDF su disco.
- Il nome file è inserito tra virgolette senza escaping.
