---
title: "Docs Lang: studio del codice e correzione degli ingressi (DOC-010, DOC-002)"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: Lang
tags: [docs, lang, autolabel, savetransaction, translator, docs-organizer, bmad]
qmd: "lang docs studio 2026-10-14 AutoLabelAction SaveTransAction save_missing_translations TranslatorAdapter non agganciato README falso best_practices api_reference"
related:
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ./lang-autolabelaction-hardening.story.md
---

# Docs Lang: studio del codice e correzione degli ingressi

## Richiesta
Fase BMAD documentazione/qualita' (DOC-010 + DOC-002): studiare Lang con attenzione al writer dei file di lingua (nel brief: «`__()` su chiave mancante crea righe nel DB e il writer scrive i file»), correggere `README.md`, `00-INDEX.md`, `index.md` solo con fatti verificati.

## Analisi
Il brief va precisato: oggi `__()` da solo non scrive nulla. Verificato il 2026-10-14:
- `app('translator')` e' `Illuminate\Translation\Translator` (tinker). `Adapters\TranslatorAdapter`, che con `RecordMissingTranslationAction` registrerebbe le chiavi mancanti in `Translation` (DB), non e' agganciato: in `LangServiceProvider::boot()` la riga `$this->registerTranslator()` e' commentata e il trait `TranslatorTrait` e' usato solo da una classe-sonda per PHPStan.
- Chi scrive i file e' `Actions\SaveTransAction`, chiamata da `AutoLabelAction` (registrata via `configureUsing` su Select, Field, Entry, Section, BaseFilter, Column, Step, Action), da `Xot` `NavigationLabelTrait` e `TransFuncTrait`, e da `EditTranslationFile`. `AutoLabelAction` costruisce `<modulo>::<file>.fields|sections|steps|actions.<nome>.<label|placeholder|helper_text|...>`, chiama `trans()` e, se torna la chiave, la scrive con il nome del componente come valore.
- Interruttore: `Config::get('lang.save_missing_translations', ! app()->runningUnitTests())`. `config/lang.php` lo imposta a `true`, ma `config('lang.save_missing_translations')` e' `NULL` a runtime: vale il ripiego, cioe' acceso fuori dai test. `git status` su `Modules/Lang` fuori da `docs/` era pulito all'inizio di questa verifica.
- Lingue: il modulo dichiara `it,en,de`; il sito pubblica `de,en,es,it` (`laravellocalization.supportedLocales`, `app.locale` e `fallback_locale` entrambi `it`). `lang/` del modulo ha `de|en|it`.
- Il vecchio README citava `Services/TranslationService`, trait `HasTranslator`, chiamate statiche `ReadTranslationFileAction::execute([...])` (la firma e' `execute(string $filePath)`, istanza via `app()`), `laravel/config/local/lang/config.php` con chiavi inesistenti, `resources/lang`, `trans_has()`: nessuno esiste (nessun `app/Services`, `app/Traits`, `resources/lang`).
- `index.md` linkava 41 volte `best_practices.md`, `BEST_PRACTICES.md`, `api_reference.md`, `API_REFERENCE.md` (23 con ancora): i file esistono come `best-practices.md` e `api-reference.md` (stesso titolo "Modulo Lang - Laraxot").

## Modifiche
- `README.md`: sostituito il blocco da "# Documentation" a "Dipendenze" con identita', cosa fa, attenzione al writer (con interruttore e prova), lingue, cosa non c'e', test, mappa; footer "Production" sostituito dalla data di verifica. `status: active`.
- `00-INDEX.md`: stato verificato al posto di "PHPStan Level 10 Compliant / Module Version 1.5.0" (non in `module.json`), sezione sul writer, mappa delle directory, 3 voci corrette (`autoregistration-commands.md` stale, `automatic-translations.md` descrive l'auto-label non motori esterni, `phpstan-analysis-lang.md` del 2025-11-05).
- `index.md`: 41 link ripuntati a `best-practices.md` e `api-reference.md` (ancore tolte, perche' i titoli hanno emoji), 5 link a file mancanti annotati.
- `wiki/index.md` e `wiki/log.md`: 3 link morti annotati; voce datata in `wiki/log.md`.
- `docs-organizer.py stale --fix`: `autoregistration-commands.md` (il modulo non ha comandi) e `phpstan-analysis-lang.md`.

## Verifica
- tinker: `Illuminate\Translation\Translator` e `NULL` per `config('lang.save_missing_translations')`; `php artisan list`: dei comandi di Lang solo `lang:publish`, che e' del framework.
- Link (eventi `unresolved` con `--busy-minutes 0`, solo i 7 file toccati): prima 50, dopo 9, tutti annotati (senza annotazione: 0). Intero modulo: 2435 prima, 2394 dopo. Con la metrica di `audit` (link rotti nei soli file indice) il brief indicava 67, ora 26.
- Frontmatter in dry-run: 307 eventi `frontmatter-dry` ancora in attesa nel modulo (308 prima: `README.md` e `00-INDEX.md` ora hanno `status`); gli altri non sono stati toccati.
- Test non eseguiti: `SaveTransAction` scrive nei file di lingua dell'albero di lavoro; il README indica come lanciarli.

## Decisioni
- Nessun file spostato o cancellato; nessuna modifica al codice. Il README non promette `TranslatorAdapter` finche' non e' agganciato.

## Aperto
- Decidere se agganciare `TranslatorAdapter` (registrazione nel DB) o eliminare l'adapter e `RecordMissingTranslationAction`.
- `config('lang.*')` e' `NULL` a runtime: la config del modulo non e' caricata con quel nome; per spegnere il writer in sviluppo serve oggi `config([...])` a runtime.
- Migration duplicate di `posts` e `translations` (2026-01-21 e 2026-08-06).
- `wiki/` ha 286 file, `wiki/integrations/translation-consolidated.md` da solo 296 link irrisolti.
