---
title: "Niente testi fissi nelle Blade del modulo Lang (multilingua it/en/de/es)"
type: story
status: implemented
module: Lang
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Lang

## GitHub (tracciamento)

| Tipo | Repo | # | URL |
|------|------|---|-----|
| Issue (coordinamento) | laraxot/base_techplanner_fila5 | 18 | https://github.com/laraxot/base_techplanner_fila5/issues/18 |
| **Discussion** (canon) | laraxot/base_techplanner_fila5 | 54 | https://github.com/laraxot/base_techplanner_fila5/discussions/54 |

Nulla e' stato pubblicato da questa story: i riferimenti servono al tracciamento.

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('lang::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave.
- La stringa va in `Modules/Lang/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori del modello, frammenti di direttive Blade, stub e pagine di sviluppo non instradati.

## Cosa e' stato fatto

- Prima di questa story il modulo non aveva un documento di tracciamento per la campagna. La misura di partenza e' quella della passata 2026-10-30 qui sotto (3 occorrenze in 2 file).

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md).

## Dev Agent Record

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: Lang)

Scanner `Modules/Lang`: prima 3 occorrenze in 2 file (3 text), dopo 3 in 2 file (invariato: stub).

- Nessuna Blade toccata. Nuovo `lang/es/widgets.php` con `language_switcher.*` (6 chiavi: seleziona lingua, lingua corrente, cambia a `:language`, nomi delle tre lingue): la usa `components/language-switcher.blade.php` e mancava in `es`. `check-blade-keys` su `Modules/Lang` da 1 chiave mancante a 0; compilazione 10 file OK; `php -l` pulito.
- Residui (3): stub `index` e `layouts/master` («Hello World», «This view is loaded from module:», «Module Lang»), non instradati.
- Non verificato: nessuna pagina guardata.
