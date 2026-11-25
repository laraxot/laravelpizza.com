---
title: "ADR — Nei test i contenuti JSON del tenant si scrivono in una copia sotto storage"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/Config/GetTenantFilePathAction.php
  - ../../app/Models/Traits/SushiToJson.php
qmd: "tenant json content isolated tests test"
---

# ADR: nei test i contenuti JSON del tenant si scrivono in una copia sotto storage

## Contesto

- I modelli Sushi (`Modules/Tenant/app/Models/Traits/SushiToJson.php`) leggono e scrivono le righe in
  `config/<tenant>/database/content/<tabella>.json`: pagine, sezioni, menu sono dati del sito versionati in git.
- Ogni `Model::create()` in un test scriveva in quella cartella, e la modifica finiva nel commit.
- Senza contenuti però i test delle pagine CMS rispondevano 404 (210 test di un'installazione, docblock di
  `prepareTestingContent()`).
- Domanda: come far leggere ai test i contenuti veri senza lasciarli scrivere sui file versionati?

## Decisione

`GetTenantFilePathAction::execute()`: con `app()->runningUnitTests()` e un nome che inizia con `database/content/`, il
percorso diventa `storage/framework/testing/tenant-content/<tenant>/<file>`. Una volta per processo
(`prepareTestingContent()`) la copia si svuota e si riempie dai JSON versionati; poi file o cartelle mancanti si copiano
alla prima richiesta. Le altre config del tenant (`database.php`, `xra.php`...) restano i file veri.

## Alternative scartate

- Fixture JSON dedicate ai test: divergono dai contenuti reali, e i test delle pagine provano altro da ciò che va online.
- Ripristinare i file con git dopo i test: dipende da chi lancia i test e fallisce a metà esecuzione.
- Database in memoria per i modelli Sushi: le righe si leggono comunque dal file (`SushiToJson::getSushiRows()`).

## Conseguenze

- Pro: `config/` non cambia mai per effetto dei test; i test vedono i contenuti versionati.
- Contro: un ramo `runningUnitTests()` nel codice di produzione; chi aggiunge un nuovo tipo di contenuto scrivibile fuori
  da `database/content/` deve estendere la regola.

## Verifica

`Modules/Tenant/tests/Unit/Actions/Config/GetTenantFilePathActionTest.php`, test
`keeps JSON content written by tests out of the versioned tenant config` (group `TENANT-FILE-PATH-INV-3`).
