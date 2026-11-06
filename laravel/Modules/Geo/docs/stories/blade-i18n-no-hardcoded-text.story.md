---
title: "Niente testi fissi nelle Blade del modulo Geo (multilingua it/en/de/es)"
type: story
status: implemented
module: Geo
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Geo

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('geo::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/Geo/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, coordinate e numeri, valori che arrivano dal modello.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 261 occorrenze in 17 file a 212 in 13 file (stesso strumento, commit di partenza contro stato attuale). Di queste, 183 sono nel sito statico di terzi descritto sotto.
- 9 Blade convertite: home, widget della mappa, ricerca indirizzi per categoria, scheda luogo, widget latitudine e longitudine, mappa Webbingbrasil, selettore di coordinate.
- Creati file lingua in `it`, `en`, `de`, `es`: `home`, `geo_map_widget`, `form_search_address_categories` (32 chiavi per lingua in totale); `lat_lng`, `place`, `webbingbrasil-map` e `coordinate-picker` completati nelle lingue mancanti (`de`, `es`).

## Residui dichiarati (212 occorrenze)

| Categoria | N |
|---|---:|
| Sito statico di terzi non instradato (copia vendored in tedesco, licenza MIT) e una copia della sua barra laterale: non e' interfaccia del progetto | 183 |
| Stub Laravel e scaffold nWidart non instradati | 15 |
| Pagine di sviluppo e dati finti (debug, esempi) | 10 |
| Direttive Blade e binding Alpine: falsi positivi | 3 |
| Marchio | 1 |

Testi in PHP non toccati: circa 14 chiamate `->label()`, `->placeholder()`, `->tooltip()` con testo fisso (conteggio euristico).

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- Il sito statico di terzi non e' stato tradotto per scelta: non e' parte dell'interfaccia del progetto.
- Una parte delle chiavi (`home`, `geo_map_widget`, `form_search_address_categories`, scheda luogo, widget coordinate) e' nata con tre o quattro elementi invece di cinque: funziona in tutte le lingue ma non e' stata rinominata.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

## Seguito: forma delle chiavi

Le chiavi a 2-3 segmenti create da questa campagna sono state in parte portate a `ns::file.collezione.chiave.tipo`: **31 chiavi spostate** in questo proprietario (stesso testo, tutte le lingue, usi riscritti, nessun uso della vecchia chiave rimasto). Due chiavi non sono state spostate: `de/coordinate-picker.php` contiene commenti e lo strumento rifiuta quel file. La frase sui «tre o quattro elementi» qui sopra descrive lo stato precedente: le chiavi rimaste a 3-4 elementi non sono state verificate una per una; la misura assoluta, lo strumento e i residui sono in [la story di Lang](../../../Lang/docs/stories/translation-key-shape-rekey.story.md).

### Passata 2026-10-30 (sessione 97f16a39, i18n-geo-ui: Geo)

Scanner `Modules/Geo`: prima 213 occorrenze in 13 file (194 text, 17 attr, 1 phrase-key, 1 url-literal), dopo 207 in 11 file (188 text, 17 attr, 1 phrase-key, 1 url-literal).

- Blade toccate (2): `filament/widgets/lat-lng.blade.php` (titolo, «lat», «lng», «err_code», «err_message»: i due punti e il markup restano nella Blade) e `filament/widgets/geo-map-widget.blade.php` (titolo «farmshops.eu Replica»).
- Chiavi nuove in `it`, `en`, `de`, `es`: `lat_lng.widget.{heading.title, latitude.label, longitude.label, error_code.label, error_message.label}` (5) e `geo_map_widget.sections.title.title` (1). `it` e' il testo originale identico; `en`, `de`, `es` sono traduzioni.
- Buchi colmati nelle Blade gia' convertite (chiavi usate ma assenti): `geo::addresses.field.help.{title,description,primary_note}` (nuovo `es/addresses.php`; in `en` e `de` i valori erano copie dell'italiano e sono stati tradotti), `geo::coordinates.fields.{latitude,longitude}.{label,placeholder}` (nuovi `de/coordinates.php` e `es/coordinates.php`, solo le 4 chiavi usate), `geo::widgets.location.submit` (nuovo `es/widgets.php`; `en` e `de` erano «Seleziona»). Totale: it +6 chiavi, en +6 (+4 valori corretti), de +10 (+4 corretti), es +14.
- Controlli: `check-blade-keys` su `Modules/Geo` da 17 chiavi mancanti a 9, tutte `fixcity::` (nessuna `geo::` manca piu' in `it`, `en`, `de`, `es`); compilazione Blade OK sulle 2 Blade toccate e su `addresses-field`; `php -l` pulito sui 16 file lingua toccati; `check-key-shape`: nessuna delle chiavi aggiunte e' tra le storte.
- Residui (207): sito statico di terzi `maps/farmshops/index.blade.php` (92) e la sua barra laterale `layouts/partials/sidebar.blade.php` (91), non instradati, in tedesco, non sono interfaccia del progetto; stub `welcome` (13), `index` (2), `layouts/master` (1); pagine di sviluppo `livewire/test` (`__('Add Address')` con `__FILE__`/`__LINE__`), `components/blocks/article_list/v1` («non dovrei essere qua»); dati finti `components/card/place` (nome e categoria di un locale demo, prezzo e voto; i `title` erano gia' tradotti); `@error('email')` e `@error('cap')` in `livewire/form_search_address_categories` (direttive Blade, falsi positivi); `title=address` in `location-picker` (binding Alpine `:title`, falso positivo). `admin/index` («flash-message») e' scaffold. Nessun testo e' dentro `<script>`.
- Da decidere, non toccato: `components/geolocation/address-field`, `components/geolocation/partials/address-field-geolocation-script` e `components/map-lit` usano 9 chiavi `fixcity::segnalazione.*` / `fixcity::ticket.map.image.alt` che non esistono in nessun file lingua (neppure in Sixteen o Fixcity): in pagina escono le chiavi grezze. Serve scegliere il proprietario (Fixcity o `geo::`) e il testo italiano, che oggi non c'e'.
- Residuo preesistente: `geo::widgets.location.submit` ha 3 segmenti dopo `::` (non rinominata: la foglia `submit` accanto a `messages` richiede lo strumento `lang-rekey`).
- Non verificato: nessuna pagina guardata in un browser; i testi PHP (`->label()` ecc.) non cercati; i valori `en`/`de` degli altri file Geo non sono stati riletti uno per uno (il confronto automatico `en == it` sulle 78 chiavi usate dalle Blade trova solo voci identiche legittime: Home, Menu, Foto).
