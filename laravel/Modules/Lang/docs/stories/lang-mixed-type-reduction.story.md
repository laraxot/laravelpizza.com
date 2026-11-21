---
qmd: "lang mixed type reduction.story"
issues: []
discussions: []
title: "Lang: ridurre l'uso di mixed dove il tipo reale e' desumibile"
type: story
module: Lang
slug: lang-mixed-type-reduction
status: done
created: 2026-09-04
updated: 2026-09-04
repository: https://github.com/laraxot/module_lang_fila5
tags:
  - phpstan
  - lang
  - type-safety
  - mixed
estimated_effort: "0.25 dev-day"
blocked_by: []
related:
  - "./lang-duplicate-array-keys.story.md"
  - "../coverage.md"
owned_scope:
  - laravel/Modules/Lang/app/Actions/Filament/AutoLabelAction.php
  - laravel/Modules/Lang/app/Models/TranslationFile.php
  - laravel/Modules/Lang/app/Models/Traits/HasStrictTranslations.php
  - laravel/Modules/Lang/app/Actions/SyncTranslationsAction.php
  - laravel/Modules/Lang/docs/coverage.md
  - laravel/Modules/Lang/docs/stories/lang-mixed-type-reduction.story.md
---

# LANG — riduzione uso di `mixed`

## Story

Come manutentore del gate statico, voglio che il modulo Lang usi `mixed` solo dove il
tipo reale non e' desumibile (payload eterogenei, contratti vendor), non come scorciatoia
generica — per la convenzione di progetto ("cerchiamo di non usare mixed, quando lo
troviamo cerchiamo di sostituirlo con qualcosa di adeguato", best-effort).

## Evidenza misurata (2026-09-04)

```text
cd laravel && grep -rnE '\bmixed\b' Modules/Lang --include="*.php" | wc -l
142 occorrenze, 47 file
```

Distinzione fatta prima di editare: native type-hint (`mixed $x`, `: mixed`) vs
docblock-only (`@param array<string, mixed>`). Priorita' data alle prime, come da
indicazione del task.

## Acceptance Criteria

1. `./vendor/bin/phpstan analyse Modules/Lang` resta a **0 errori** (baseline gia' 0
   prima di questo lavoro) — nessuna regressione, nessun nuovo `@phpstan-ignore`.
2. Ogni sostituzione di `mixed` e' giustificata dal codice circostante (uso con
   `is_array()`/narrowing gia' presente, o tipo noto dal chiamante), non da
   un'assunzione.
3. Le firme che overridano contratti vendor tipizzati `mixed` (o non tipizzati, quindi
   equivalenti a `mixed` per compatibilita' LSP) restano invariate.
4. `docs/coverage.md` aggiornato con sezione datata, prima/dopo PHPStan, esito onesto
   di Pest/PHPMD.

## Tasks / Subtasks

- [x] Censire tutte le occorrenze di `mixed`, native vs docblock-only.
- [x] Sostituire i native type-hint sicuri (`AutoLabelAction`, `TranslationFile`).
- [x] Migliorare due docblock impropri `array<mixed, mixed>` → `array<array-key, mixed>`
      (`HasStrictTranslations`, `SyncTranslationsAction`) — le chiavi PHP non sono mai
      "mixed" arbitrario.
- [x] Verificare che il narrowing su `TranslationFile::loadTranslationDataWithErrorHandling()`
      non introduca `function.alreadyNarrowedType` — rimosso il check `is_array()` divenuto
      morto, non ignorato.
- [x] Lasciare esplicitamente `mixed` sugli override di `Illuminate\Translation\Translator::get()`
      (`TranslatorAction`, `TranslatorAdapter`, `TranslatorService`), sull'interfaccia
      `CastsAttributes` (`LangField`), sui callback di `Arr::sort()`/`array_filter()` su
      dati del pacchetto `rinvex/countries` (nessun generic upstream), e sul payload di
      `config('laravellocalization.supportedLocales')`.
- [x] Rieseguire PHPStan sul modulo, confermare 0 → 0.
- [x] PHPMD scoped sui file modificati (crash su tutto il modulo, noto/flaky).
- [x] Pest: confermare via `git stash` che le failure preesistenti non dipendono da
      questo diff.

## Dev Notes

- La maggior parte delle 142 occorrenze e' gia' un docblock generico
  `array<string, mixed>` su payload di traduzione (alberi ricorsivi stringa/array): shape
  stabile ma genuinamente eterogenea, non e' stata toccata (rientra nel "dove possibile",
  non "sempre").
- Narrowing `mixed` → `array` su una closure passata a `Arr::map()`/`Arr::first()` puo'
  rendere morto un check `is_array()` successivo: PHPStan level max lo segnala come
  `function.alreadyNarrowedType`. Il fix corretto e' rimuovere il check morto, non
  reintrodurre `mixed` per evitare l'errore.
- Effetto collaterale scoperto durante la verifica Pest: la suite scrive per davvero su
  `lang/en/*.php`/`lang/it/*.php` (side effect di test come `SaveTransActionTest`/
  `AutoLabelAction`-correlati). Ripristinato con `git checkout -- lang/ && git clean -fd
  lang/` prima del commit — nessuna di queste modifiche appartiene a questa story.
- Durante la sessione, un conflitto Git non ancora risolto in
  `Modules/Cms/app/Providers/RouteServiceProvider.php:103` bloccava l'intera suite Pest
  (bootstrap condiviso via `XotBaseServiceProvider`); risolto da un'altra sessione in
  parallelo mentre questa story era in corso (commit "Reduce mixed type usage in Cms
  module") — non e' stato necessario intervenire.

## Testing

- `cd laravel && ./vendor/bin/phpstan analyse Modules/Lang --no-progress --error-format=table`
  → 0 errori prima e dopo.
- `cd laravel && ./tools/phpmd.sh <file-modificati> text ../docs/phpmd.ruleset.xml` →
  solo debito preesistente, nessun nuovo finding sulle righe modificate.
- `cd laravel && ./vendor/bin/pest Modules/Lang/tests -c Modules/Lang/phpunit.xml --no-coverage`
  → failure preesistenti confermate identiche con `git stash` (diff rimosso).

## Dev Agent Record

### Esecuzione 2026-09-04 — Claude (Sonnet 5)

4 file modificati, 4 sostituzioni native/docblock mirate, 0 regressioni PHPStan. Dettaglio
completo in `docs/coverage.md#2026-09-04-mixed-type-reduction`.
