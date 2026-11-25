---
title: "Lang — vista language switcher standalone"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
---

# ADR: vista language switcher standalone

## Contesto

`lang::components.language-switcher` viene montata da un componente Blade pubblico e non è garantito che esista un oggetto Livewire associato.

## Decisione

`LanguageSwitcherWidget` prepara gli URL localizzati nei dati della lingua. La vista renderizza link HTML ordinari e non accede a `$this`.

## Alternative scartate

Non documentate al momento della decisione: da ricostruire.

## Conseguenze

Il selettore funziona nelle pagine pubbliche Folio/Blade e resta compatibile con la sorgente di localizzazione esistente. L’interazione non richiede JavaScript.

## Verifica

- `rg -c '\$this' laravel/Modules/Lang/resources/views/components/language-switcher.blade.php` non trova nulla
  (controllato il 2026-11-24): la vista non accede a `$this`.
- `Modules/Lang/tests/Unit/Filament/LanguageSwitcherWidgetTest.php` verifica `getAvailableLocales()` (un URL per locale)
  e `getLanguageUrl()` con fallback.
- `Modules/Lang/tests/Unit/LangHundredPercentCoverageTest.php` copre gli URL e i dati di vista del widget
  (test «covers changeLanguage urls and view data»).
- Contratto della vista: [language-switcher-component](../contracts/language-switcher-component.md).
