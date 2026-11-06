---
title: "Niente testi fissi nelle Blade del modulo Cms (multilingua it/en/de/es)"
type: story
status: implemented
module: Cms
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Cms

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('cms::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/Cms/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere. Se l'originale era inglese (Flowbite, builder dei menu), `en` lo conserva e `it` e' la traduzione: copiare l'inglese in `it` lascerebbe gli italiani con testo inglese.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle (`URL`), numeri, valori che arrivano dal modello o dal contenuto CMS.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 200 occorrenze in 35 file a 29 in 16 file (stesso strumento, commit di partenza contro stato attuale).
- 33 Blade convertite: blocchi `footer` e `headernav` (presenti in quattro alberi di viste duplicati, `Components/` e `components/`), pagina dei temi, suggerimenti della barra di ricerca del blog, builder dei menu, ispettore del database, blocchi di pagina, ordinamento dei pannelli, sezioni, contenuto di pagina.
- Creati 8 file lingua per ognuna delle quattro lingue, 73 chiavi per lingua: `block_footer`, `block_headernav`, `blog`, `db_inspector`, `menu_builder`, `page_blocks`, `panel_sort`, `themes_page`.
- Completati de/es sulle chiavi che altre passate avevano creato solo in `it`/`en` (builder dei menu, blog, ispettore, blocchi, ordinamento, sezioni).

## Residui dichiarati (29 occorrenze)

| Categoria | N |
|---|---:|
| Marchio Flowbite nei footer (testo, logo, `alt`), nei quattro alberi duplicati | 18 |
| Sigla `URL` nel builder dei menu, uguale in ogni lingua | 8 |
| Scaffold nWidart non instradato (indice e layout master) | 3 |

Testi in PHP non toccati: circa 56 chiamate `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()` con testo fisso nei PHP di Cms e Notify insieme (conteggio euristico).

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- I testi dei contenuti CMS (pagine e blocchi nei JSON o nel database) non fanno parte di questa campagna: in de/es restano nella lingua in cui sono stati scritti, dove non tradotti.
- Una parte delle chiavi (builder dei menu, blog, ispettore del database, blocchi di pagina) e' nata con tre o quattro elementi invece di cinque: funziona in tutte le lingue ma non e' stata rinominata.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

## Seguito: forma delle chiavi

Le chiavi a 2-3 segmenti create da questa campagna sono state in parte portate a `ns::file.collezione.chiave.tipo`: **56 chiavi spostate** in questo proprietario (stesso testo, tutte le lingue, usi riscritti, nessun uso della vecchia chiave rimasto). Due chiavi non sono state spostate (il gruppo `sections.preview` e' letto come array). Le Blade `builder_body_a` e `builder_body_b` non compilano gia' in HEAD: vedi [la story di User](../../../User/docs/stories/blade-templates-that-do-not-compile.story.md). La frase sui «tre o quattro elementi» qui sopra descrive lo stato precedente: le chiavi rimaste a 3-4 elementi non sono state verificate una per una; la misura assoluta, lo strumento e i residui sono in [la story di Lang](../../../Lang/docs/stories/translation-key-shape-rekey.story.md).

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: Cms)

Scanner `Modules/Cms`: prima 37 occorrenze in 20 file (22 text, 7 attr, 8 route-unknown), dopo 37 in 20 file (invariato). Escluse le 8 `route-unknown` (`route('profile.show')`, residui con decisione dell'utente), le occorrenze utili sono 29 prima e 29 dopo.

- Blade toccate (2): `resources/views/Components/headernav/simple.blade.php` e `resources/views/Components/blocks/headernav/simple.blade.php` (copie identiche). Usavano `user::auth.login-in.text` e `user::auth.sign-up`, chiavi del proprietario User che mancano in `de` (la voce `sign-up` e' italiana) e in `es`: ora usano chiavi di Cms, come per Seo (`seo::social_share`).
- Chiavi nuove: `cms::block_headernav.auth.login.label` e `auth.sign_up.label` in `it` (Accedi, Registrati; stesso output di prima), `en`, `de`, `es` (2 per lingua); `es/sections.php` +1 (`preview.empty`, usata da `section-preview.blade.php`).
- Controlli: `check-blade-keys` su `Modules/Cms` da 3 chiavi mancanti (de 1, es 3) a 0; compilazione Blade 85 file, 2 non compilano (`builder_body_a`, `builder_body_b`: copie troncate morte, non toccate, vedi story di User); `php -l` pulito sui file lingua toccati; `check-key-shape`: nessuna delle chiavi nuove e' tra le storte.
- Residui (29 + 8 `route-unknown`): marchio Flowbite nei footer (18: testo, logo, `alt="Flowbite Logo"`, nei quattro alberi duplicati), sigla `URL`/`Url` e segnaposto `url` del builder dei menu (8, di cui 3 nelle copie `builder_body_a/b`), stub nWidart non instradato (`index`, `layouts/master`).
- Le copie `Components/` e `components/` dei blocchi `headernav` non sono identiche: quella in minuscolo usa `pub_theme::components.ui.auth-buttons` (nessun testo fisso) e non e' stata toccata.
- Non verificato: nessuna pagina guardata in un browser; i testi PHP (`->label()` ecc.) non cercati.
