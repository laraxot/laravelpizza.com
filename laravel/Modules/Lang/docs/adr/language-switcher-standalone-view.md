---
title: "Lang — vista language switcher standalone"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
---

# ADR: vista language switcher standalone

## Contesto

`lang::components.language-switcher` viene montata da un componente Blade pubblico e non è garantito che esista un oggetto Livewire associato.

## Decisione

`LanguageSwitcherWidget` prepara gli URL localizzati nei dati della lingua. La vista renderizza link HTML ordinari e non accede a `$this`.

## Conseguenze

Il selettore funziona nelle pagine pubbliche Folio/Blade e resta compatibile con la sorgente di localizzazione esistente. L’interazione non richiede JavaScript.
