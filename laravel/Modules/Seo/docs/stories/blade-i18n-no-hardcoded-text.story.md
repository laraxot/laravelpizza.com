---
title: "Niente testi fissi nelle Blade del modulo Seo (multilingua it/en/de/es)"
type: story
status: implemented
module: Seo
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Seo

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('seo::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/Seo/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Un modulo non deve dipendere da chiavi di un tema (`pub_theme::...`): quel namespace esiste solo se il tema attivo definisce la collezione.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri (Twitter, LinkedIn, WhatsApp, Telegram), sigle, numeri.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 12 occorrenze in 4 file a 7 in 3 file (stesso strumento, commit di partenza contro stato attuale).
- 2 Blade convertite: il componente di condivisione sui social e il widget di generazione della sitemap.
- Creati `social_share` (3 chiavi) e `generate_sitemap_widget` (2 chiavi) in `it`, `en`, `de`, `es`: la cartella `lang` del modulo era vuota.
- Il componente di condivisione leggeva chiavi che esistevano solo in un tema (`pub_theme::event.*`): ora usa `seo::social_share.*` e funziona con qualunque tema attivo.

## Residui dichiarati (7 occorrenze)

| Categoria | N |
|---|---:|
| Frammenti `@break @case(...)` dei nomi dei social: falsi positivi | 4 |
| Scaffold nWidart non instradato (indice e layout master) | 3 |

Testi in PHP non toccati: circa 1 chiamata `->label()`, `->placeholder()`, `->tooltip()` con testo fisso (conteggio euristico).

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: Seo)

Scanner `Modules/Seo`: prima 7 occorrenze in 3 file (7 text), dopo 7 in 3 file (invariato).

- Nessuna modifica. `check-blade-keys` su `Modules/Seo`: 6 usi, 0 mancanti; compilazione 12 file OK.
- Residui (7): frammenti `@break @case('twitter')` ecc. in `components/social-share` (4, falsi positivi), stub `index` e `layouts/master` (3).
- Non verificato: nessuna pagina guardata.
