---
title: "Niente testi fissi nelle Blade del modulo Gdpr (multilingua it/en/de/es)"
type: story
status: implemented
module: Gdpr
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Gdpr

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('gdpr::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave, e mai una chiave senza il prefisso del modulo (`account.delete.*` non esiste: `gdpr::account.delete.*` si): il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/Gdpr/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle (`SSL`, `GDPR`), numeri, valori che arrivano dal modello.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: 14 occorrenze in 6 file sia prima sia dopo. Il numero non cambia perche' la vista corretta usava chiavi senza prefisso, che lo strumento non conta come testo fisso: il difetto era una vista che non poteva mostrare alcun testo.
- 1 Blade sistemata: la pagina di cancellazione dell'account (dieci chiavi non risolvibili riportate a `gdpr::account.delete.*`, e una riga con apice non chiuso che impediva la compilazione).
- `account` esteso con il gruppo `delete.*` (10 chiavi per lingua, testi gia' esistenti in quattro lingue); in `es` la voce `cancel` diceva «Editar» per errore ed e' ora «Cancelar».
- `register` completato in `de` ed `es` (12 chiavi).

## Residui dichiarati (14 occorrenze)

| Categoria | N |
|---|---:|
| Direttive `@error`: falsi positivi | 7 |
| Scaffold nWidart non instradato (indice e layout master) | 3 |
| Sigle (`SSL`, `GDPR`) | 2 |
| Segnaposto di lavoro in corso | 1 |
| Attributo che e' gia' una chiave: falso positivo | 1 |

Testi in PHP: non cercati in questa campagna sul modulo, quindi non toccati.

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico; la pagina di cancellazione dell'account non e' stata aperta.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: Gdpr)

Scanner `Modules/Gdpr`: prima 14 occorrenze in 6 file (13 text, 1 attr), dopo 14 in 6 file (invariato): tutte falsi positivi o stub.

- Nessuna Blade toccata. Chiave nuova in `de` ed `es` (`register.links.and`: «und», «y»): la usa `components/consent-label.blade.php` e mancava. `check-blade-keys` su `Modules/Gdpr` da 1 chiave mancante a 0; compilazione 9 file OK; `php -l` pulito sui due file lingua.
- Residui (14): direttive `@error` in `filament/widgets/auth/register` (7, falsi positivi), stub `index` e `layouts/master` (3), sigle `SSL` e `GDPR` in `components/already-registered` (2), «WIP» in `filament/pages/profile` (pagina Filament senza classe che la richiami), `title=__('gdpr::account.delete.heading.title')` in `account/delete` (1, e' gia' una chiave).
- Non verificato: nessuna pagina guardata.
