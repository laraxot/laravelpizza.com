---
title: "[DEV] PHPStan cleanup modulo Lang"
type: dev
module: Lang
status: done-with-open-decision
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, lang, enum, safe, typeCoverage, bmad]
related:
  - ./2026-10-06-phpstan-cleanup-lang.story.md
qmd: "06 phpstan cleanup lang dev"
---

# [DEV] PHPStan cleanup modulo Lang

## Technical Plan

1. Script di audit: `use function Safe\{glob,file_get_contents,file_put_contents}`, shape degli array restituiti,
   filtro `is_string()` sui risultati di `Safe\glob()`, rimozione della condizione sempre vera.
2. Stub anonimi dei test: nessun docblock da aggiungere (gia' presenti); modifiche di contenuto reali e utili
   (`private readonly` sul translator avvolto; commento d'intento sul loader vuoto) che rigenerano la entry di cache.
3. Costanti: ripristino dei tipi nativi (`const array`) e conversione degli stati in backed enum.

## Files to Modify

- `laravel/Modules/Lang/docs-archive-2026/helper-text-audit-script.php`
- `laravel/Modules/Lang/docs-archive-2026/italian-text-audit-script.php`
- `laravel/Modules/Lang/docs-archive-2026/obbligatorio-audit-script.php`
- `laravel/Modules/Lang/docs/italian-text-validation-refined.php`
- `laravel/Modules/Lang/tests/Unit/LangFinalGapsTest.php` (`private readonly` sui due translator stub)
- `laravel/Modules/Lang/tests/Unit/LangHundredPercentCoverageTest.php` (commento d'intento sul loader stub)
- `laravel/Modules/Lang/tests/Unit/Models/TranslationTest.php` (test sull'enum al posto delle costanti)
- `laravel/Modules/Lang/app/Models/Translation.php` (rimosse `STATUS_SAVED/STATUS_CHANGED`)
- `laravel/Modules/Lang/app/Enums/TranslationStatusEnum.php` (nuovo, `enum ...: int`)
- `laravel/Modules/Lang/app/Models/Post.php`, `database/seeders/LanguageLineSeeder.php`,
  `database/seeders/TranslationSeeder.php` (costanti tipizzate `const array`, come in `HEAD`)
- Docs: `docs/README.md`, `../wiki/index-3.md`, questa coppia di story.

- Docs: `docs/README.md`, `docs/wiki/index.md`, questa coppia di story.

## Implementation Steps

- [x] Letto scopo e chiamanti degli script (nessun chiamante nel codice: script CLI standalone, path base placeholder)
- [x] `Safe\*` + tipi + filtro `is_string()` nei 4 script
- [x] Rimossa condizione ridondante in `italian-text-validation-refined.php` e pattern `'conferma'` duplicato
- [x] Smoke test dei 4 script contro un base path finto (scratchpad): report generati, output atteso
- [x] Diagnosticata la causa degli errori sugli stub anonimi (cache phpdoc `ftm-<file>`), modifiche utili ai test
- [x] `TranslationStatusEnum` creato; costanti rimosse; `grep` su `Modules` e `Themes`: solo `TranslationTest`
- [x] Costanti di configurazione tipizzate
- [ ] Decisione utente su `composer.json` `php: ^8.2` (3 errori `classConstant.nativeTypeNotSupported` residui)

## Testing

Pest NON eseguito: `phpunit.xml` forza sqlite `:memory:`, ma `.env.testing` punta a MySQL (`techplanner_data_test`) con
`APP_ENV=local`; per la regola "dati DB sacri" non e' stato avviato nessun test. Verifiche alternative:
`php -l` su tutti i file toccati; smoke PHP puro dell'enum (`from(1) === CHANGED`, `tryFrom(2) === null`);
esecuzione reale dei 4 script con base path finto.

## Verification

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Lang --memory-limit=-1 --no-progress
# risultato: 3 errori classConstant.nativeTypeNotSupported (Post.php:121, LanguageLineSeeder.php:17, TranslationSeeder.php:16)
php -l Modules/Lang/app/Enums/TranslationStatusEnum.php
grep -rnE "STATUS_(SAVED|CHANGED)" Modules Themes --include='*.php'   # nessun risultato
```

Prima: 108 errori in 11 file (lista del gruppo) -> dopo: 0 errori reali di codice; 3 errori di configurazione
(`^8.2` vs costanti tipizzate), vedi Analysis nella story.

## Lessons Learned

- **PHPStan: `classConstant.nativeTypeNotSupported` vs `constantTypeCoverage`.** PHPStan deriva la versione minima di PHP
  da `require.php` di `laravel/composer.json` (`^8.2`), quindi le costanti tipizzate (8.3+) sono errore mentre quelle non
  tipizzate fanno scendere la copertura. Soluzione unica: `"php": "^8.3"` nel `composer.json` radice (o `phpVersion` nel neon).
- **Errori su docblock di classi anonime possono essere artefatti di cache.** `FileTypeMapper` salva la mappa phpdoc con
  chiave `ftm-<file>` e dentro il nome della classe anonima (hash del path relativo al cwd + riga). Run con cwd/path diversi
  sulla stessa `tmpDir` lasciano entry stale: il docblock c'e', PHPStan non lo trova. Controprova: copiare il file con un
  altro nome nel progetto e analizzarlo (0 errori). Se la causa e' la cache, non aggiungere docblock a caso.
- **`Safe\glob()` e' `list<mixed>`** (docblock di `thecodingmachine/safe`): per tipizzare i path usare `is_string()`
  nel loop (come `GetAllTranslationAction`), non cast.
- **Condizioni "sempre vere" sono spesso copia-incolla**: `stripos(...) !== false` ripetuto dentro il ramo che gia' lo
  garantisce. Verificare l'intento (qui: escludere falsi positivi) prima di toglierla.
- **Pitfall di tooling**: in uno script Python con stringhe non raw, `Safe\file_get_contents` diventa form-feed (`\f`);
  usare sempre `r'''...'''` quando si scrivono namespace PHP.
