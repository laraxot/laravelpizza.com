---
title: "[STORY] PHPStan zero errors nel modulo Lang"
type: story
status: review
priority: high
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, lang, test-fixtures, rebase-regression, bmad, swarm]
related:
  - "../../../../../docs/stories/all-modules-phpstan-zero-errors.story.md"
  - "17.4.helper-testcase-dichiarati-mai-scritti.story.md"
---
# Story: PHPStan zero errors nel modulo Lang

## User Request
Swarm PHPStan Modules (baseline 1600 errori / 181 file): ambito `laravel/Modules/Lang/**`, 213 errori in 13 file
(112 nei test, 101 in `app/` e `docs/*.php`). Risolvere la causa, non l'errore; scopo prima dell'errore.

## Analysis
Quasi tutto discende da **un solo evento**: il commit `d8c78ba7` (2026-10-28 15:34, "rebase (start): checkout laraxot/dev").
E' il replay del vecchio commit `ceaed311` (2026-09-24) sopra `b3d8baa2`, committato **con i marcatori di conflitto**
(`<<<<<<< HEAD`, ripuliti poi da `2250dbef`). Gli hunk non in conflitto hanno rimesso lo stato di settembre sopra quello di ottobre.
`7fb93059` (merge precedente) e' l'ultimo stato coerente: li' tutto compilava.

| Causa radice | Errori | Scopo del codice | Risoluzione |
|---|---:|---|---|
| 17 file `tests/Fixtures/*` cancellati da `d8c78ba7` ma ancora importati da `LangFinalGapsTest`, `LangHundredPercentCoverageTest`, `LangCoverageGapsTest` | ~110 (`class.notFound`, `property.nonObject`, `argument.type`, `unresolvableType`) | Stub/host per coprire rami difensivi (strict translations, `forcedCountries`, auto-label, scrittura file fallita) | Ripristinati da `7fb93059` (esistevano in entrambi i lineage). Nessun test riscritto. |
| `use` persi nel replay: `Config` (SaveTransAction), `Log` (TranslationFile), `TextColumn` (ListTranslationFiles), `SaveTransAction` (tests/TestCase), `Translator` (TranslatorAdapterTest) | 9 | Codice che gia' li usava | Import reinseriti. |
| `ThemeComposer::buildAdminLanguageUrl()` tornato `private`; 3 test lo chiamano come API pubblica (era `public` in `b3d8baa2` e `7fb93059`) | 3 | URL del selettore lingua in admin | Riportato `public`; i test chiamano il metodo direttamente (nessuna reflection su privato). |
| `EditTranslationFile::schemaFromRecord()` chiamato dai test, inesistente; closure con `mixed $record` | 7 | Schema del form dal record `content` | Estratto `schemaFromRecord(?object): array`; la closure passa `is_object($record) ? $record : null`. |
| `ListTranslationFiles::getTableColumns()` ritornava `array<string,mixed>` (`TextColumn` senza import) | 3 | Colonna `key` cercabile | Import + lista di `TextColumn`. |
| `WriteTranslationFileAction::putTranslationFile()` `int|false` vs `File::put(): int|bool` | 1 | Scrittura file di traduzione | Seam protetto che normalizza `bool→false`/`int`; lo stub di test lo sovrascrive. |
| `docs/*-audit-script.php` (4 script): `glob`/`file_get_contents`/`file_put_contents` nativi, `array` senza shape, `mixed` a cascata | 95 | Script di audit lingua usati a mano | `use function Safe\...`, shape `array{...}` sul ritorno/parametri, `is_string($file)` sul risultato di `glob`; tolta una `stripos` ridondante (`alwaysTrue`). |
| `LangHundredPercentCoverageTest:173` `assertStringContainsString` su `mixed` | 1 | Verifica chiave `lang::` | `assertIsString(...)` prima dell'asserzione. |
| `tests/TestCase.php`: `mkdir`/`file_put_contents` nativi | 2 | Preparare file traduzione | `use function Safe\mkdir/file_put_contents`. |

## Result
- Prima: **213** (elenco swarm). All'ingresso dell'agent, dopo edit paralleli gia' presenti nel working tree (15:58), `phpstan analyse Modules/Lang` dava **188**.
- Dopo: **0**: `cd laravel && ./vendor/bin/phpstan analyse Modules/Lang --memory-limit=-1 --no-progress` → exit 0 (2026-10-28 16:1x).
- `php -l` pulito sui file toccati. Nessun file cancellato (`git status` senza ` D`).
- **Pest NON eseguito**: `.env.testing` punta a MySQL; i test Lang non sono unit puri (`TestCase` con `DatabaseTransactions`).

## Acceptance Criteria
- [x] `phpstan analyse Modules/Lang` = 0 errori, senza `@phpstan-ignore*`, baseline, `phpstan.neon` intatto
- [x] Nessun file cancellato/spostato; fixture ripristinate, non riscritte
- [x] Funzioni native non sicure sostituite con `Safe\`
- [x] Storia + dev-story BMAD; write-back in `docs/PHPSTAN-FIXES.md`
- [ ] Pest in ambiente sicuro (sqlite/replica `*_test`): i test con stub ora "vivi" non sono mai stati eseguiti in questa sessione
- [ ] Decisioni aperte qui sotto

## Decisioni aperte
1. **Resto del replay `d8c78ba7` non toccato** (non erano errori PHPStan): `git diff 7fb93059 d8c78ba7 --stat -- app config`. Verificati a vista:
   `AutoLabelAction` ha perso `$default_val` (una sezione senza titolo persiste "empty" come intestazione); `NationalFlagSelect` estende `Select`
   invece di `XotBaseSelect`; `TranslationEditor`/`ThemeComposer` tornati a versioni piu' vecchie (`LangData::collection`, `DataCollection::filter`).
   Non esaminati: `Post.php` (235 righe), `config/lang.php` (-20), `LangField` (-5). Da decidere: ripristinare file per file da `7fb93059`.
2. **Seam morti** (gia' censiti da LANG-17.4): `finalizeFilteredCountries`, `findCallerFrame`, `titleForGuid`, `writeLangTempContents` non esistono su alcun genitore;
   `AutoLabelNullCallerStub` presuppone un ritorno anticipato, mentre `AutoLabelAction` lancia `No object class found`. PHPStan non li vede (nessun `#[Override]`),
   ma quei test non coprono quello che dichiarano. Aggiunti in `app/` solo `resolveCountries()` e `putTranslationFile()` (seam di test in produzione): da confermare o togliere.
3. **Colonna `status`** della tabella `translations` mancante e `TranslationStatusEnum` senza cast (nota 2026-10-06): non toccata, nessuna migrazione inventata.
4. **Doc duplicati `*-1.md`** in `docs/` (9: `filament-translations-1`, `validation-messages-1`, `lang-service-provider-1`, `pluralization-and-localization-1`,
   `translation-notify-conversion-1`, `translation-standards-1`, `translation-file-management-1`, `laravel-localization-usage-1`, `permessi-errori-filesystem-1`):
   il nome corretto esiste gia' → collisione, unire richiede cancellare. Non rinominati.
5. Working tree modificato in parallelo da uno scrittore non identificato (15:58–16:05) sugli stessi file; il conteggio finale e' misurato sull'insieme.

## GitHub (tracciamento)
- Issue: TODO (`gh` non installato)
- Discussion: TODO

## Rimando: trait.unused di Post (2026-11-05)
`Post` componeva le copie piatte `Traits/PostMutators.php` e `Traits/PostRelations.php` (entrate col commit `.` `dc34e53d6`, contenuto stale) mentre le copie
nelle sottocartelle `Traits/Mutators/` e `Traits/Relationships/` (merge coerente `bd6a68733`) restavano inutilizzate. Ora `Post` usa le sottocartelle.
Dettaglio e prove: `../../../User/docs/stories/phpstan-unused-relation-traits.story.md`.

**Chiusura (2026-11-05, sera):** rimosse le due copie piatte, in avanti e senza `git checkout`/`reset`. Prove prima di cancellare: nessun
`use` o riferimento alle copie piatte in tutto il repo (`rg` su `Traits\PostMutators`/`Traits\PostRelations`); le copie nelle sottocartelle
sono le piu' nuove e piu' rigorose (`getTxt(?string $value = null): string` con fallback su `attributes['txt']`, contro `getTxt(?string $value): ?string`);
`Post` si carica con `HasSlug, PostMutators, PostRelations, Updater`. PHPStan su `Modules/Lang/app/Models`: i 2 `trait.unused` delle copie sono spariti
(resta `HasStrictTranslations`, gia' in baseline). **Rischio noto:** sono il vecchio nome ricomparso dopo il sync (`merge -s resolve` non gestisce le
rinomine); se un clone gemello ha ancora i file piatti, `merge_remote_repo_2.sh` puo' riportarli. In quel caso ricancellarli e non ripristinarli.
