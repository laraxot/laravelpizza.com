# UI Wiki Log

## [2026-05-06] phpstan | Dynamic array normalization
- Nuova pagina: `concepts/phpstan-dynamic-array-normalization.md`.
- Documentato pattern per convertire output dinamici action/Livewire in array tipizzati senza `@var` inline, ignore o baseline.
- Applicato a `UserCalendarWidget`, `InteractiveMap` e `LocationSelector`.

## [2026-04-28] governance | Model States ownership e compatibilita' Laravel 13
- Nuova pagina: `concepts/model-states-module-ownership.md`.
- Distinto ownership tecnico (`UI` + `Xot`) da compatibilita' runtime.
- Verificato che `spatie/laravel-model-states` latest stable richiede `PHP ^8.4`, mentre `2.12.1` si ferma a `Laravel 12`.

## [2026-04-23] governance | EnumSelect API collisions (Filament v5)
- Nuova pagina: `concepts/enumselect-filament-api-collisions.md`.
- Documentati i fatal tipici: collisione firme `make()/enum()` e collisione visibilita' `getLabel()` quando si estende `Select`.

## [2026-04-23] hardening | EnumSelect phpstan/runtime guardrails
- Aggiornata `concepts/enum-select-contract-and-false-friends.md` con regole aggiuntive emerse dal fix runtime e dal check PHPStan.
- Inserite best practices su firma `enum(string|Closure|null)` e narrowing `int|string` prima di `tryFrom()`.
- Esplicitato false friend: `Class ... not found` puo' essere sintomo secondario di fatal in fase di caricamento della classe.

## [2026-04-23] governance | Filament component autoload nel modulo UI
- documentata la regola `module-filament-component-autoload-rule`
- componenti PHP del modulo UI sotto `app/`; fatal recente `EnumSelect` ricondotto a path autoload errato, non al widget consumer

## [2026-04-23] governance | EnumSelect contract, best practices, bad practices, false friends
- Documentato il contratto minimo di `Modules\UI\Filament\Forms\Components\EnumSelect`.
- Fissate le regole su firma compatibile di `make(?string $name = null)`, validazione backed enum, fallback label/icon e rischi di autoload/visibilita'.
- Nuova pagina: `concepts/enum-select-contract-and-false-friends.md`.

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`
