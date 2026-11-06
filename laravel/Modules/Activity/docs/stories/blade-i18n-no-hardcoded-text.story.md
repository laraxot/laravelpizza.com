---
title: "Niente testi fissi nelle Blade del modulo Activity (multilingua it/en/de/es)"
type: story
status: implemented
module: Activity
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Activity

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('activity::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/Activity/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori che arrivano dal modello.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 10 occorrenze in 5 file a 9 in 4 file (stesso strumento, commit di partenza contro stato attuale).
- 1 Blade convertita: la pagina di elenco dei log di attivita' (etichetta `Batch:`).
- Nuovo file lingua `list_log_activities` in `it`, `en`, `de`, `es` (1 chiave per lingua).
- `log_viewer`, che esisteva solo in `it`/`en`, completato in `de` ed `es` (23 chiavi per lingua).

## Residui dichiarati (9 occorrenze)

| Categoria | N |
|---|---:|
| Elemento di dashboard con dati d'esempio (scaffold) non instradato | 5 |
| Scaffold nWidart non instradato (indice e layout master) | 3 |
| Attributo che e' gia' una chiave: falso positivo | 1 |

Testi in PHP: non cercati in questa campagna sul modulo, quindi non toccati.

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- Il prefisso dinamico `activity::activities.events.` e' costruito a runtime: il controllo statico delle chiavi non puo' verificarlo.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: Activity)

Scanner `Modules/Activity`: prima 9 occorrenze in 4 file (8 text, 1 attr), dopo 9 in 4 file (invariato).

- Nessuna modifica. `check-blade-keys` su `Modules/Activity`: 22 usi, 0 mancanti; compilazione 9 file OK.
- Residui (9): `admin/dashboard/item` con dati di esempio (5, nessuna vista o classe lo richiama), stub `index` e `layouts/master` (3), `placeholder=__('activity::log_viewer.placeholders.search')` (1, e' gia' una chiave).
- Non verificato: nessuna pagina guardata.
