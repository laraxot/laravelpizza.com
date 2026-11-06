---
title: "Niente testi fissi nelle Blade del modulo Xot (multilingua it/en/de/es)"
type: story
status: implemented
module: Xot
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Xot

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('xot::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/Xot/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`: le classi base `XotBase*` le usano in tutti i moduli.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori che arrivano dal modello.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 57 occorrenze in 27 file a 24 in 12 file (stesso strumento, commit di partenza contro stato attuale).
- 17 Blade convertite: terminale, e-mail di record, gestore dei comandi artisan, pagine ambiente e salute, widget ambiente e orologio, gestione lingue del modulo, valutazione a stelle, componente tabella base, importazione XLS, pagine di sviluppo (errori, elenco rotte, ispettore del database). Le viste `Components/` e `components/` sono copie identiche: modificate entrambe.
- Creati 10 file lingua per ognuna delle quattro lingue, 30 chiavi per lingua: `common`, `terminal`, `manage_lang_module`, `rate`, `xot_base_table_component`, `xls_import`, `record_email`, `db_inspector`, `error_log`, `route_list`.
- Estesi `health` e `artisan-commands-manager` (creato anche in `es`). In `en` e `de` sette voci di `artisan-commands-manager` erano copiate in italiano: tradotte.

## Residui dichiarati (24 occorrenze)

| Categoria | N |
|---|---:|
| Scaffold e pagine di test o sviluppo non instradate (Hello World, widget e PDF di prova, dati di esempio) | 22 |
| Frammenti di codice e valori tecnici (`weekly` della sitemap): falsi positivi | 2 |

Testi in PHP non toccati: circa 33 chiamate `->label()`, `->placeholder()`, `->tooltip()` con testo fisso nelle classi base e nelle azioni comuni (conteggio euristico).

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- Alcune chiavi delle pagine di sviluppo (ispettore del database, elenco rotte, log errori) sono nate con tre o quattro elementi invece di cinque: funzionano in tutte le lingue ma non sono state rinominate.
- In `health` e `artisan-commands-manager` restano chiavi preesistenti mancanti in alcune lingue: ricadono sull'italiano.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

## Seguito: forma delle chiavi

Le chiavi a 2-3 segmenti create da questa campagna sono state in parte portate a `ns::file.collezione.chiave.tipo`: **15 chiavi spostate** in questo proprietario (stesso testo, tutte le lingue, usi riscritti, nessun uso della vecchia chiave rimasto). La frase sui «tre o quattro elementi» qui sopra descrive lo stato precedente: le chiavi rimaste a 3-4 elementi non sono state verificate una per una; la misura assoluta, lo strumento e i residui sono in [la story di Lang](../../../Lang/docs/stories/translation-key-shape-rekey.story.md).

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: Xot)

Scanner `Modules/Xot`: prima 24 occorrenze in 12 file (22 text, 2 attr), dopo 20 in 11 file (18 text, 2 attr).

- Blade toccata (1): `pdf/spatie-test.blade.php` («Generato il», «Nessun dato fornito.», «Chiave», «Valore»), usata da `MakePdfSpatieTestAction`. La data resta nel formato `d/m/Y H:i:s` e `<html lang="it">` non e' stato cambiato (attributo, fuori regola).
- Chiavi nuove: `xot::pdf_spatie_test.{sections.generated_at.label (:date), sections.empty.message, fields.key.label, fields.value.label}` in `it`, `en`, `de`, `es` (4 per lingua). `it` e' il testo originale identico.
- Buchi colmati (chiavi usate dalle Blade, presenti solo in `it`/`en`): nuovi `de/widgets.php` e `es/widgets.php` (10 chiavi ciascuno: `base.*`, `infolist.record_not_available.label`, `modules_overview.*`, `schema.submit.label`) e nuovi `de/xot_base_resource_form.php` e `es/xot_base_resource_form.php` (6 chiavi: `actions.{submit,previous,next}`, `steps.{privacy,data,summary}`). Totale: it +4, en +4, de +20, es +20.
- Controlli: `check-blade-keys` su `Modules/Xot` da 11 chiavi mancanti (de, es) a 0; compilazione Blade 60 file, 1 non compila (`rss/feed.blade.php`, gia' rotta prima, la sistema un altro agente; `livewire/test` ora compila); `php -l` pulito sui file lingua toccati; `check-key-shape`: nessuna delle chiavi nuove e' tra le storte.
- Residui (20): pagine di test o sviluppo non instradate (`livewire/test` in due copie, `test` in due copie, `filament/widgets/test` con testo italiano di prova ma `TestWidget` usa `xot::filament.widgets.base`; 13 occorrenze), stub `index` e `layouts/master` (3), `title="titolo di prova"` in `components/dashboard/item` (2 copie, componente mai usato), `weekly` della sitemap (valore `changefreq`, falso positivo), frammento `@endif @endforeach` in `livewire/rate/multi` (falso positivo).
- Resta da fare: le chiavi `xot::widgets.*` e `xot::xot_base_resource_form.*` hanno 3 segmenti dopo `::` (preesistenti, non rinominate).
- Non verificato: nessun PDF generato e nessuna pagina guardata; testi PHP non cercati (il titolo «Spatie PDF Test» e' in `MakePdfSpatieTestAction`).
