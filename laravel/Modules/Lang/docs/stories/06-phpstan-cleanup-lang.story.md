---
title: "[STORY] PHPStan cleanup modulo Lang (script di audit, stub di test, enum stato traduzione)"
type: story
module: Lang
status: done-with-open-decision
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, lang, enum, safe, typeCoverage, bmad]
related:
  - ./2026-10-06-phpstan-cleanup-lang.dev.md
---

# [STORY] PHPStan cleanup modulo Lang

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalita', non sull'errore;
aumenta la qualita' del codice; usa enum al posto delle costanti».

Gruppo Lang: 108 errori in 11 file. Verifica: `./vendor/bin/phpstan analyse Modules/Lang --memory-limit=-1 --no-progress` (da `laravel/`).

## Analysis

Scopo del codice toccato, non solo l'errore:

- **Script di audit i18n** (`docs-archive-2026/{helper-text,italian-text,obbligatorio}-audit-script.php`,
  `docs/italian-text-validation-refined.php`): script CLI standalone. Scansionano `*/lang/{en,de,es,fr}/*.php`
  (o `*/lang/*/*.php` per helper_text), cercano testo italiano residuo / `helper_text` uguale alla chiave padre,
  e scrivono un report `.md`. Servono come prova tracciata degli audit di traduzione del 2026; devono restare
  eseguibili. `glob` / `file_get_contents` / `file_put_contents` ora sono `Safe\*` (lanciano invece di
  restituire `false`), i risultati sono tipizzati con shape `array<string, list<array{...}>>`.
  - `Safe\glob()` dichiara `list<mixed>` (docblock di `thecodingmachine/safe`): gli elementi vengono filtrati
    con `is_string()` (stesso pattern di `GetAllTranslationAction`), non con cast.
  - `docs/italian-text-validation-refined.php`: la condizione `stripos($line, $pattern) !== false` era ripetuta
    dentro il ramo che la garantisce gia' (sempre vera, `notIdentical.alwaysTrue`): rimossa, la semantica
    di esclusione dei falsi positivi e' invariata.
  - `italian-text-audit-script.php`: voce `'conferma'` duplicata nell'elenco pattern (produceva due righe di report
    identiche per ogni match): rimossa la seconda.
  - `helper-text-audit-script.php`: `$parentKey ? ... : ...` trattava `'0'` come "nessun parent": ora `!== ''`.
- **Stub di test con classe anonima** (`LangFinalGapsTest`, `LangHundredPercentCoverageTest`,
  `LangCoverageBoostTest`): i docblock `@param/@return array<...>` erano gia' corretti. Gli errori
  `missingType.iterableValue` erano un artefatto della cache phpdoc (`ftm-<file>`, chiave = solo nome file)
  che memorizza il nome della classe anonima derivato dal path relativo al cwd: run da root diversi
  lasciano una entry stale e il docblock "sparisce". Verificato copiando lo stesso file con un altro nome
  (0 errori). Vedi Lessons Learned nel dev file.
- **Costanti**: `Post::SEARCHABLE_FIELDS`, `LanguageLineSeeder::ENTRIES`, `TranslationSeeder::ENTRIES` sono costanti di
  configurazione (campi cercabili / righe di seed): restano costanti, tipizzate `const array`.
  `Translation::STATUS_SAVED/STATUS_CHANGED` rappresentano un insieme di valori (stato di sincronizzazione della riga
  col file di lingua) -> `Modules\Lang\Enums\TranslationStatusEnum: int`. Nessun consumatore fuori da
  `Modules/Lang/tests/Unit/Models/TranslationTest.php` (grep su `Modules` e `Themes`), quindi nessun alias deprecato.
  La tabella `translations` non ha la colonna `status` (vedi migration `2026_08_06_190100_create_translations_table`):
  nessun cast aggiunto al modello.
- **Conflitto di configurazione (decisione utente)**: con `laravel/composer.json` -> `"php": "^8.2"` PHPStan assume
  PHP minimo 8.2 e segnala `classConstant.nativeTypeNotSupported` su ogni costante tipizzata, mentre la regola
  `constantTypeCoverage` (full-tree) chiede costanti tipizzate. Le due regole non sono soddisfacibili insieme finche'
  la versione minima non diventa `^8.3` (runtime 8.4.26, `Modules/Lang/composer.json` gia' `^8.3`).

## Acceptance Criteria

- [x] Zero errori PHPStan sui 4 script PHP di audit (corretti sul posto, non spostati/cancellati)
- [x] Stub anonimi dei test: nessun errore `missingType.iterableValue` su `Modules/Lang`
- [x] `Translation::STATUS_*` sostituito da `TranslationStatusEnum` (backed enum `int`), test aggiornato
- [x] Costanti di configurazione di Lang tipizzate (`const array`)
- [x] Script di audit ancora eseguibili (smoke test con base path finto)
- [ ] `phpstan analyse Modules/Lang` a 0: restano 3 `classConstant.nativeTypeNotSupported` (decisione su `composer.json`)
- [ ] Decisione utente: i `.php` in `docs/` e `docs-archive-2026/` devono essere analizzati da PHPStan?

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
