---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "continuazione domani"
issues: []
discussions: []
title: "Continuazione BMAD — Domani (Lang)"
type: module-fix
scope: Lang
epic: "12"
bmad_version: v3.30.1
updated_at: '2026-09-22'
status: in-progress
related:
  - ../../stories/12.1.retire-lang-http-switchers.story.md
  - ../livewire-inventory.md
  - ../livewire-widget-decision-log.md
  - ../livewire-widget-epics.md
---

# Lang — Continuazione Domani

## Stato verificato ora (sessione 2026-09-22, verifica su codice, non sulla doc)

- Epic 12.1 (ritiro `Http\Livewire\Lang\Switcher`/`Change` → `Filament\Widgets\LanguageSwitcherWidget`)
  e' **done**, verificato sul codice reale, non solo sulla doc:
  - `app/Http/Livewire/Change.php` e `Switcher.php`: **assenti**.
  - `app/Http/Livewire/_components.json`: `[]` (nessun alias stale).
  - `Modules/UI/resources/views/components/headernav/simple.blade.php:59`:
    `@livewire(\Modules\Lang\Filament\Widgets\LanguageSwitcherWidget::class)`
    (il widget, non `<livewire:lang.change>`).
  - Combacia con `docs/bmad/livewire-inventory.md` (SSoT dettagliato, verificato
    riga per riga il 21/09), che dichiara "Campagna Lang **chiusa**".
- **Le doc `docs/bmad/livewire-widget-decision-log.md` e
  `docs/bmad/livewire-widget-epics.md` sono STALE** (stub generici da ~450-800
  byte, non il file SSoT): dicono ancora "12.1 **blocked** — Switcher ritirato,
  Change ancora montato (`UI headernav:60`), widget pronto ma non agganciato" e
  "migrazione dei 3 test che importano `Switcher` (ora rotti)". Verificato oggi:
  falso su entrambi i punti — `UI headernav:60` monta gia' il widget (sopra),
  e i 3 test citati (`tests/Unit/LangCoverageGapsTest.php`,
  `tests/Unit/Filament/LocaleSwitcherRefreshTest.php`, ecc.) importano
  `LocaleSwitcherRefresh`/`LanguageSwitcherWidget`, non la classe HTTP ritirata
  — falso positivo sul nome "Switcher".
- `git log`: ultimo commit di codice reale e' `1cfd45f1` (refactor
  `LanguageSwitcherWidget` config-driven), poi solo commit "." e cleanup
  doc/gitignore fino a `09ad0b16` (`.gitignore` per `graphify-out/`).
- `git status --short`: solo `docs/bmad/stories/` non tracciata (questo file).

## Continuazione domani (in ordine di priorita')

1. **Correggere lo stato stale** in `docs/bmad/livewire-widget-decision-log.md`
   e `docs/bmad/livewire-widget-epics.md`: Epic 12.1 e' `done`, non `blocked`
   (verificato sul codice oggi, vedi sopra) — allineare a
   `docs/bmad/livewire-inventory.md`, che resta la SSoT.
2. **`app/Actions/SaveTransAction.php:48`** — `dddx([...])` **live** (non
   commentato) dentro un `catch (\Exception $e)`: qualsiasi eccezione nel
   caricamento di un file di traduzione fa dump-and-die invece di un log/throw
   gestito. Rischio reale in produzione se un file trans e' corrotto o
   mancante permessi. Da sostituire con log strutturato + rilancio o gestione
   esplicita.
3. **`app/View/Components/LanguageSwitcher.php`** resta un wrapper inerte:
   registrazione Blade commentata in `app/Providers/LangServiceProvider.php:42`
   (`// BladeService::registerComponents(...)`) e alias assente da
   `_components.json`. Decidere: eliminarlo (dead code, il widget Filament e'
   l'unico switcher vivo per verdetto di `livewire-inventory.md`) o riattivarlo
   con uno scopo esplicito — non lasciarlo ambiguo.
4. **2 `@phpstan-ignore trait.unused` residui**: `app/Models/Traits/
   HasStrictTranslations.php:12` e `app/Providers/Traits/TranslatorTrait.php:11`.
   Non indagati oggi — verificare con una run PHPStan a modulo intero (non
   isolata) se sono davvero trait morti o falsi positivi cross-modulo (memoria
   second brain: `trait.unused` puo' essere un artefatto di scope quando il
   trait e' usato solo da un altro modulo).
5. **Struttura docs**: `docs/bmad/stories/` (nuova) contiene solo questo file;
   le story reali del modulo (es. `12.1.retire-lang-http-switchers.story.md`)
   vivono in `docs/stories/`. Verificare se vanno consolidate sotto
   `docs/bmad/stories/` per coerenza con la standing order del repo
   ("story BMAD sempre in `laravel/Modules/<Mod>/docs/bmad/...`") o se
   `docs/stories/` resta la posizione canonica per Lang — non duplicare,
   decidere e basta.

## Second brain

`qmd query "Lang LanguageSwitcherWidget Change Switcher retire 12.1"` prima di
riprendere; `qmd update` dopo la chiusura del punto 1 (correzione doc stale).
