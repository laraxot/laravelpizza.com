---
qmd: "lang services to actions.story"
issues: []
discussions: []
title: "Lang: app/Services retired, no-services-rule compliance"
type: story
module: Lang
slug: lang-services-to-actions
status: done
created: 2026-09-04
updated: 2026-09-04
repository: https://github.com/laraxot/module_lang_fila5
tags:
  - architecture
  - queueable-action
  - no-services-rule
  - refactor
estimated_effort: "0.25 dev-day"
blocked_by: []
related:
  - "../../../Tenant/docs/concepts/tenant-service-to-actions-migration.md"
  - "../../../../../bashscripts/ai/wiki/rules/no-services-rule.md"
  - "../coverage.md"
owned_scope:
  - laravel/Modules/Lang/app/Services/
  - laravel/Modules/Lang/tests/Unit/Services/
  - laravel/Modules/Lang/tests/Unit/LangCoverageGapsTest.php
  - laravel/Modules/Lang/tests/Unit/LangHundredPercentCoverageTest.php
  - laravel/Modules/Lang/docs/stories/lang-services-to-actions.story.md
---

# Lang — app/Services retired, no-services-rule compliance

## Story

Come manutentore del pattern QueueableAction (`bashscripts/ai/wiki/rules/no-services-rule.md`,
status "RELIGION"), voglio che nessuna classe di business logic viva sotto `app/Services/` in
`Modules/Lang`: la cartella conteneva un solo file, `TranslatorService.php`, e va trattato secondo
il giudizio richiesto dalla regola, non forzato meccanicamente in `Actions/`.

## Cosa c'era davvero

`app/Services/TranslatorService.php` NON era una "god service facade" multi-metodo (Kind A del
task) né un vero collaborator/Strategy da spostare intatto (Kind B classico). Era un **doppione
morto**: un sottotipo di `Illuminate\Translation\Translator`, pensato per essere bindato come
singleton `translator` nel container, di cui esisteva già una versione migrata e superiore,
`app/Adapters/TranslatorAdapter.php`:

- stessa firma `get()`,
- ma `notifyMissingKey()` delega a `app(RecordMissingTranslationAction::class)->execute($key, $locale)`
  (una vera QueueableAction in `app/Actions/Translation/`), invece di inlineare
  `Translation::firstOrCreate()` come faceva `TranslatorService`.
- `Modules\Lang\Providers\LangServiceProvider::registerTranslator()` bindava già `TranslatorAdapter`
  come singleton `translator` (la chiamata a `registerTranslator()` in `boot()` è oggi commentata,
  pre-esistente, fuori scope di questa story — non riattivata qui).

`TranslatorService` non aveva **nessun call site di produzione**: zero `app(TranslatorService::class)`,
zero `new TranslatorService(...)` fuori dal file stesso e da due test di coverage che lo
istanziavano direttamente solo per esercitare le righe.

## Classificazione (tabella per il coordinatore)

| File | Kind | Motivazione | Destinazione |
|---|---|---|---|
| `app/Services/TranslatorService.php` | **Doppione morto**, non A né B | Superato al 100% da `app/Adapters/TranslatorAdapter.php`, già esistente, già delegante a una QueueableAction reale. Zero call site di produzione. Una classe senza un vero `execute()` che fa da adapter per un binding framework non vive in `Actions/`: il carve-out della regola stessa la colloca in `Adapters/`, dove esisteva già una versione migliore. | **Eliminato** (file + cartella vuota). Nessuna nuova classe creata: sarebbe stata un quarto doppione. |

Non esisteva un secondo file Kind A o Kind B: `app/Services/` di questo modulo era già ridotto a un
unico relitto di una migrazione precedente incompleta, non un god-service vivo.

## Call site aggiornati

- `tests/Unit/LangCoverageGapsTest.php` — rimosso l'import, test rinominato e riscritto per
  istanziare `TranslatorAdapter` al posto di `TranslatorService`.
- `tests/Unit/LangHundredPercentCoverageTest.php` — idem, con l'aggiunta di un'asserzione sulla
  missing-key per continuare a coprire il percorso `RecordMissingTranslationAction` (il vecchio
  test copriva solo `notifyMissingKey` inline).
- `tests/Unit/Services/TranslatorServiceTest.php` — **eliminato**: non istanziava mai
  `TranslatorService` (risolveva `app('translator')`, che con `registerTranslator()` commentato
  risolve al translator stock di Laravel), duplicava `tests/Unit/Adapters/TranslatorAdapterTest.php`
  senza testare nulla di specifico alla classe che il nome del file dichiarava di coprire.

Grep repo-wide (`Modules/`) per `Lang\\Services`, `TranslatorService::`, `new TranslatorService`,
`app(TranslatorService::class)`: nessun hit fuori dai quattro file sopra. Nessun altro modulo
referenzia `Modules\Lang\Services\*`.

## Debito noto, non toccato (fuori scope)

`app/Actions/TranslatorAction.php` è una terza copia quasi identica della stessa classe (logica
inline, non raggruppata per contesto — flat in `Actions/` invece che in un sottofolder, `execute()`
fittizio a corpo vuoto). Non è sotto `app/Services/`, quindi fuori dal perimetro letterale di questa
story; segnalato qui perché la prossima sessione non lo riscopra alla cieca. Andrebbe idealmente
ritirato in favore di `TranslatorAdapter`, con lo stesso ragionamento di questa story.

## Collisione con un'altra sessione (scoperta, non causata da questa story)

Durante la verifica, `app/Actions/TranslatorAction.php` è stato trovato con un errore di sintassi
(`use Spatie\QueueableAction\ActionJob;` duplicato tre volte, due delle quali dentro corpi di
metodo) — coerente con una modifica in corso di un'altra sessione AI concorrente
(`bashscripts/ai/wiki/rules/multi-agent-same-repo-race.md`). Ripristinato esattamente allo stato
trovato dopo un fix locale temporaneo usato solo per sbloccare la verifica PHPStan/Pest di questo
modulo (mai committato). `lang/it/txt.php` era già modificato prima dell'inizio di questa story e ha
continuato a cambiare durante il lavoro: lasciato intatto ed escluso dal commit.

## Verifica

- PHPStan: baseline vera (`clear-result-cache` + `analyse Modules/Lang`) 0 errori → finale 0 errori.
- Pest: run completo bloccato da un `dddx()` pre-esistente in `SaveTransAction.php` (uccide il
  processo PHP, non introdotto da questa story). Verifica mirata con `--filter` sui tre test
  toccati: 6 passed (15 assertions).
- PHPMD: crash pre-esistente sull'intero modulo (`visitAnonymousClass`); scoped ai due file di test
  modificati, solo debito pre-esistente fuori dalle righe toccate.

Dettagli completi: `../coverage.md` (sezione "2026-09-04 — app/Services retired").
