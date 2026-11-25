---
title: "Contratto del componente language switcher"
type: presentation-contract
owner: Lang
status: accepted
updated: 2026-11-23
contract: Modules\\Lang\\View\\Components\\LanguageSwitcher
qmd: "language switcher component contratto componente"
---

# Contratto del componente language switcher

## Input

- locale corrente fornito dall'applicazione;
- lingue supportate da `LaravelLocalization` tramite il widget Lang.

## Output

La view Blade riceve una collection di lingue con codice, nomi, bandiera e URL
localizzato già calcolato dal widget.

## Invarianti

- la view non usa `$this`: è un componente Blade, non una view Livewire;
- la view non genera URL né contiene fallback di localizzazione;
- ogni link usa l'URL prodotto da `LanguageSwitcherWidget::getLanguageUrl()`;
- il cambio lingua è una navigazione HTML ordinaria.

## Effetti collaterali

Nessuno nella view. La navigazione successiva è gestita dal browser e dalle
route localizzate.

## Errori

Il widget applica il fallback previsto per locale non supportato o URL non
stringa; la view non deve duplicarlo.

## Non fa

- non invoca metodi sul contesto Blade;
- non definisce funzioni globali PHP;
- non persiste preferenze nel browser;
- non implementa un secondo language switcher Livewire.

## Verifica

- `Modules/Lang/tests/Unit/Filament/LanguageSwitcherWidgetTest.php` verifica la
  generazione degli URL;
- la pagina localizzata verifica che la view sia renderizzabile senza contesto
  Livewire.

La view Blade riceve lingue con URL già calcolati da
`LanguageSwitcherWidget::getLanguageUrl()`. Non usa `$this`, non definisce
funzioni globali e non invoca metodi Livewire: il cambio lingua è una
navigazione HTML ordinaria.
