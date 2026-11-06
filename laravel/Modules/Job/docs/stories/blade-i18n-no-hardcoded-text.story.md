---
title: "Niente testi fissi nelle Blade del modulo Job (multilingua it/en/de/es)"
type: story
status: implemented
module: Job
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Job

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('job::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/Job/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, numeri, nomi di driver (`sync`, `database`), valori che arrivano dal modello.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 23 occorrenze in 8 file a 8 in 5 file (stesso strumento, commit di partenza contro stato attuale).
- 5 Blade convertite, tutte widget Filament: orologio, ascolto della coda, stato dei job, gestione delle schedulazioni, stato delle schedulazioni.
- Creati 4 file lingua per ognuna delle quattro lingue, 15 chiavi per lingua: `common` (2), `job_status_widget` (3), `schedule_crud_widget` (9), `schedule_status_widget` (1). Hanno sostituito chiavi precedenti di soli quattro elementi: le vecchie voci di `job`, `job_status` e `schedule` non sono piu' usate dalle Blade.

## Residui dichiarati (8 occorrenze)

| Categoria | N |
|---|---:|
| Scaffold nWidart non instradato (indice e layout master) | 3 |
| Nomi di driver della coda (`sync`, `database`, `queue:`): falsi positivi | 3 |
| Pulsante di prova in una pagina di sviluppo | 1 |
| Frammento di espressione Blade: falso positivo | 1 |

Testi in PHP: non cercati in questa campagna sul modulo, quindi non toccati.

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: Job)

Scanner `Modules/Job`: prima 8 occorrenze in 5 file (8 text), dopo 8 in 5 file (invariato).

- Nessuna modifica. `check-blade-keys` su `Modules/Job`: 25 usi, 0 mancanti; compilazione 25 file OK.
- Residui (8): nomi dei driver della coda `sync` e `database` e prefisso `queue:` davanti al nome dell'artisan in `filament/widgets/job-status` (3, valori tecnici), pulsante di prova `zibibbo` in `filament/pages/job-status` (1, chiama `zibibbo()`, pagina di sviluppo), frammento `getTasks())` in `filament/widgets/schedule-crud` (1, falso positivo), stub `index` e `layouts/master` (3).
- Non verificato: nessuna pagina guardata.
