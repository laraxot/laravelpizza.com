---
id: remove-dead-livewire-registration
title: "Rimuovere la registrazione Livewire morta dal provider di Xot"
type: story
status: done
priority: P1
owner: module:Xot
module: Xot
tags: [phpstan, livewire, provider, dead-code, filament-widgets]
qmd: "registerLivewireComponents RegisterLivewireComponentsAction class.notFound Http/Livewire no-module-livewire-use-filament-widgets"
related: [test-database-guard, story-xxx-phpstan-zero-error-compliance-bmad]
---

# Rimuovere la registrazione Livewire morta

Fase BMAD: Dev (analisi, rimozione, verifica PHPStan).

## Richiesta
PHPStan livello max su `Modules/Xot` segnala due `class.notFound` in `XotBaseServiceProvider.php:143`: il metodo `registerLivewireComponents()` chiama `Modules\Xot\Actions\Livewire\RegisterLivewireComponentsAction`, che non esiste piu'.

## Scopo originale
Il metodo scansionava `Http/Livewire` del modulo e registrava i componenti Livewire, cosi' i moduli potevano esporre UI interattiva senza configurazione.

## Causa
- La chiamata nel `boot()` e' gia' commentata (`// $this->registerLivewireComponents(); //usiamo filament widget`).
- La classe e' stata svuotata in un commit precedente (`0934c54f2`, 0 righe nel diff).
- La regola del progetto vieta `Http/Livewire` nei moduli: UI interattiva va in `Filament/Widgets/...` (`bashscripts/ai/wiki/rules/no-module-livewire-use-filament-widgets.md`).
- Il metodo non ha altri chiamanti in `app/`.

## Decisione
Il meccanismo non serve piu': si rimuove il metodo, il suo import e la riga commentata nel `boot()`. Nessuna classe stub, nessun `@phpstan-ignore`, nessuna baseline. Il codice morto non deve restare come documentazione: la regola sta nel wiki.

## Verifica
- PHPStan `analyse Modules/Xot`: zero errori.
- Nessun riferimento residuo a `registerLivewireComponents` o `RegisterLivewireComponentsAction` in `Modules/Xot`.
