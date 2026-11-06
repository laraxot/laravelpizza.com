---
title: "Niente testi fissi nelle Blade del modulo AI (multilingua it/en/de/es)"
type: story
status: implemented
module: AI
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo AI

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano. Una frase usata come chiave (`__('Frase intera')`) non e' tradotta da nessun file e compare uguale ovunque.

## Regola operativa

- Ogni testo visibile passa da `{{ __('ai::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/AI/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori che arrivano dal modello.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 10 occorrenze in 5 file a 8 in 3 file (stesso strumento, commit di partenza contro stato attuale).
- 2 Blade convertite: le pagine Filament di completamento e di fine-tuning, che usavano frasi intere come chiave.
- Nuovi file lingua `completion_page` e `fine_tuning_page` in `it`, `en`, `de`, `es` (1 chiave per lingua ciascuno).

## Residui dichiarati (8 occorrenze)

| Categoria | N |
|---|---:|
| Elemento di dashboard con dati d'esempio (scaffold) non instradato | 5 |
| Scaffold nWidart non instradato (indice e layout master) | 3 |

Testi in PHP non toccati: circa 12 chiamate `->label()`, `->placeholder()`, `->tooltip()` con testo fisso (conteggio euristico).

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: AI)

Scanner `Modules/AI`: prima 8 occorrenze in 3 file (8 text), dopo 8 in 3 file (invariato).

- Nessuna modifica. `check-blade-keys` su `Modules/AI`: 2 usi, 0 mancanti; compilazione 7 file OK.
- Residui (8): `admin/dashboard/item` con dati di esempio (5, non richiamato da nulla), stub `index` e `layouts/master` (3).
- Non verificato: nessuna pagina guardata.
