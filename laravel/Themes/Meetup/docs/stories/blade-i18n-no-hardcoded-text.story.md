---
title: "Niente testi fissi nelle Blade del tema Meetup (multilingua it/en/de/es)"
type: story
status: implemented
theme: Meetup
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del tema Meetup

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('pub_theme::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave, e il traduttore ignora `['default' => ...]`.
- Namespace: solo `pub_theme::`, mai `meetup::` ne' `two::`. Il CMS mappa `pub_theme` su `Themes/<tema attivo>/lang`: le chiavi si risolvono quando il tema attivo e' Meetup.
- La stringa va in `Themes/Meetup/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere. Se l'originale era inglese (gran parte delle viste Meetup e Breeze), `en` lo conserva e `it` e' la traduzione.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e per i default testuali di `@props`. Frasi con variabili: `:param` e `trans_choice`; il markup resta nella Blade.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usano le rotte generiche della shell Folio: `route('container0', ['container0' => 'tickets'])` per l'indice (in Meetup si chiama `container0`, non `container0.index`) e `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])` per la pagina; il prefisso lingua lo aggiunge Folio. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori che arrivano dal modello o dal CMS.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul tema: da 304 occorrenze in 63 file a 77 in 30 file (stesso strumento, commit di partenza contro stato attuale).
- 52 Blade convertite: intestazione, footer, form di accesso e registrazione, layout di autenticazione, card, eventi, profilo e account (Breeze), servizi, pagine legali.
- Creati 10 file lingua per ognuna delle quattro lingue, circa 135 chiavi per lingua: `account`, `auth`, `cards`, `common`, `footer`, `forms`, `header`, `layout`, `legal`, `services`.
- Corrette le chiavi dell'elenco eventi che non esistevano (`events.status.*`, in `it`, `de`, `es`) e aggiunte le voci mancanti del footer (`navigation.footer.*`) in tutte le lingue; riusate le chiavi `pub_theme::navigation.*` esistenti dove il testo coincideva.
- Frasi spezzate attorno a un link (verifica e-mail) con il markup nella Blade; due punti ed emoji lasciati fuori dalla chiave.

## Residui dichiarati (77 occorrenze)

| Categoria | N |
|---|---:|
| Marchi e nomi di servizio (Laravel Pizza Meetups, documentazione di Laravel, Filament e Livewire, social, Flowbite, Tailwind CSS, Discord) | 32 |
| Direttive Blade (`@volt`, `@error`, `@csrf`, `@teleport`) e frammenti Alpine: falsi positivi | 22 |
| Autonimi di lingua (English, Italiano, Deutsch, Francais, Espanol, `ITA`) | 17 |
| Dati di esempio (indirizzo, e-mail di supporto, parole chiave meta in inglese) | 6 |

Testi in PHP: non cercati in questa campagna sul tema, quindi non toccati.

## Limiti

- Nessuna verifica a video, e il tema non e' quello servito oggi: le chiavi si risolvono solo con Meetup come tema attivo, e questo non e' stato provato.
- Parte delle viste (intestazione, footer, form di accesso, layout di autenticazione) nasce da un altro progetto (FixCity) e contiene testi di quel contesto, convertiti cosi' come sono.
- Verifica del 2026-10-30: compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

## Seguito: forma delle chiavi

Le chiavi a 2-3 segmenti create da questa campagna sono state in parte portate a `ns::file.collezione.chiave.tipo`: **26 chiavi spostate** in questo proprietario (stesso testo, tutte le lingue, usi riscritti, nessun uso della vecchia chiave rimasto). Cinque chiavi non sono state spostate perche' usate anche da Sixteen. Tre Blade nuove (non in HEAD) non compilano per cause indipendenti dal rekey: componente `ui.language-switcher` mancante e `@if` non chiuso in `components/layouts/navigation.blade.php`. La frase sui «tre o quattro elementi» qui sopra descrive lo stato precedente: le chiavi rimaste a 3-4 elementi non sono state verificate una per una; la misura assoluta, lo strumento e i residui sono in [la story di Lang](../../../../Modules/Lang/docs/stories/translation-key-shape-rekey.story.md).

### Passata 2026-10-30 (sessione 97f16a39, i18n-two-meetup-zero-user: Meetup)

Scanner `Themes/Meetup`: prima 91 occorrenze in 35 file (67 text, 8 attr, 2 phrase-key, 2 url-literal, 4 route-page-name, 5 route-unknown, 3 ns-theme), dopo 85 in 32 file (67 text, 8 attr, 0 phrase-key, 2 url-literal, 3 route-page-name, 5 route-unknown, 0 ns-theme). Il `route-page-name` in meno e' di un'altra sessione (`components/layouts/navigation`). Lo scanner non vede i testi inglesi corti: ho affiancato una scansione a mano che ha trovato 5 testi in piu'.

- Blade toccate (8): `components/ui/header` (`__('Facebook')`, `__('Twitter')` -> `pub_theme::header.social.{facebook,twitter}.label`), `components/blocks/alerts/{alert,toast}` e `blocks/utilities/badge` (`sixteen::alerts.dismiss` e `sixteen::badges.dismiss`, che non esistono neppure in Sixteen, -> `pub_theme::common.actions.close_notification.label` e `close.label`, gia' presenti nelle quattro lingue), `pages/auth/password/reset` («Or», «return to login»), `components/footer` («Built with Laravel, Filament, and Livewire.»), `components/sections/footer/v2` («Made with ❤️ and Laravel.», l'emoji passa come `:heart`), `components/ui/marketing/footer` («Terms & Conditions» -> `footer.legal.terms.label`, esistente).
- Chiavi nuove in `it`, `en`, `de`, `es`: `auth` +2 (`password.or.label`, `password.back_to_login.label`), `footer` +2 (`credits.{built_with,made_with}.message`), `header` +2. In piu', colmate in `de` e `es` le 11 chiavi `event.{fields,messages}.*` usate da `components/blocks/events/detail` (esistevano solo in `it` ed `en`).
- Originale inglese (reset password, crediti del footer, «Terms & Conditions»): `en` conserva l'originale e `it` e' la traduzione.
- Residui (85), nessuno e' un errore: direttive e frammenti (`@volt`, `@error`, `@csrf`, `@teleport`, `aria-label` Alpine di `ui/theme-toggle` che usa gia' le chiavi), marchi e servizi (Laravel Pizza Meetups, Flowbite, Tailwind CSS, Github, Discord, Facebook, Twitter, GitHub, «Laravel Docs», «Filament Docs», «Livewire Docs»: nomi di siti di documentazione, lasciati come nella passata precedente), autonimi e codici di lingua (English, Italiano, Deutsch, Français, Español, ITA), dati di esempio (indirizzo, e-mail, parole chiave meta, `<div>aaa</div>` in `blocks/events/index`, segnaposto da sistemare), esempi dentro commenti Blade (`ui/toggle`, `ui/notifiche`, `ui/hero`, `ui/accordion`, `ui/service-card`, menu utente in `ui/app/header`). `route-page-name`, `route-unknown`, `url-literal` non toccati per decisione dell'utente.
- Controlli: `check-blade-keys` Meetup da 20 chiavi mancanti a 5. Restano `user::auth.login.{title,subtitle,submit}` (`filament/widgets/auth/login.blade.php`, copia della vista di Sixteen: in `Modules/User` `auth.php` ha commenti e `login` e' gia' un array, quindi non si puo' aggiungere senza scegliere un'altra chiave) e `gdpr::register.register.{submit,submitting}` in `de`/`es` (modulo Gdpr, fuori dal mio perimetro). Aggiunti in `Modules/User/lang/{en,de,es}/login.php` i 4 testi `login.{page.title,page.subtitle,already_registered,register}` usati da `pages/auth/login`. `check-key-shape`: nessuna chiave mia tra le storte; compilazione dell'intero tema: 137 file, 0 non compilano (3 avvisi di componente preesistenti: `ui.language-switcher`, `danger-button`); `php -l` pulito sui 14 file lingua.
- Non verificato: nessuna richiesta HTTP (il tema non e' quello servito); le chiavi si risolvono solo con Meetup attivo. Le Blade con difetti preesistenti segnalate sopra non sono state corrette.
