---
title: "Niente testi fissi nelle Blade del modulo User (multilingua it/en/de/es)"
type: story
status: implemented
module: User
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo User

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('user::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/User/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere. Se l'originale era inglese (Breeze, Jetstream), `en` lo conserva e `it` e' la traduzione.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->heading()`, `->description()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori che arrivano dal modello o dal CMS.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 286 occorrenze in 53 file a 88 in 29 file (stesso strumento, commit di partenza contro stato attuale).
- 51 Blade convertite: navigazione e menu profilo, widget di login e logout, conferma di uscita, mail e notifiche, invito al team, area personale, registrazione, modifica profilo.
- File lingua completi nelle quattro lingue: `area_personale`, `auth_pages`, `blocks`, `common`, `layout`, `logout_confirm`, `mail_message`, `notification_email`, `pages`, `profile_edit`, `register_page`, `team_invitation_email`. Le sette collezioni scritte in questa passata portano 51 chiavi per lingua (`profile_edit` ne ha 12 in piu').
- Completamento di de/es sulle chiavi preesistenti usate dalle Blade: 115 in `de`, 123 in `es`. In `de/auth` la voce `login.register` e' tornata un array con `text`, come in `it`/`en`.
- Controllo statico sulle 68 Blade di User, Employee e TechPlanner: 311 chiavi usate, nessuna mancante in `it`, `en`, `de`, `es`.
- Sorgenti inglesi (navigazione, menu profilo, invito al team, notifiche, mail): `en` e' l'originale, `it` e' la traduzione. La voce di logout e' una chiave comune, `user::common.actions.logout.label`.

## Residui dichiarati (88 occorrenze)

| Categoria | N |
|---|---:|
| Starter kit demo non instradato (pagine di esempio, benvenuto, notifica toast) | 56 |
| Direttive Blade, marchi, segnaposto e frammenti di espressione: falsi positivi | 26 |
| Scaffold nWidart non instradato (indice e layout master) | 3 |
| Link a pagine legali con prefisso lingua fisso (nessuna rotta affidabile) | 3 |

Testi in PHP: circa 54 chiamate `->label()`, `->placeholder()`, `->tooltip()`, `->heading()`, `->description()` con testo fisso (conteggio euristico), non toccate.

## Limiti

- Nessuna verifica a video: le pagine richiedono il login e non sono state aperte; chiavi e compilazione sono controllate in modo statico.
- Una parte delle chiavi usate dalle Blade (circa 137 usi) e' nata con tre o quattro elementi invece di cinque: funziona in tutte le lingue ma non e' stata rinominata.
- I file `it` e `en` di `auth` hanno commenti e strutture miste e non sono stati riscritti.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

## Seguito: forma delle chiavi

Le chiavi a 2-3 segmenti create da questa campagna sono state in parte portate a `ns::file.collezione.chiave.tipo`: **116 chiavi spostate** in questo proprietario (stesso testo, tutte le lingue, usi riscritti, nessun uso della vecchia chiave rimasto). La frase sui «tre o quattro elementi» qui sopra descrive lo stato precedente: le chiavi rimaste a 3-4 elementi non sono state verificate una per una; la misura assoluta, lo strumento e i residui sono in [la story di Lang](../../../Lang/docs/stories/translation-key-shape-rekey.story.md).

### Passata 2026-10-30 (sessione 97f16a39, i18n-two-meetup-zero-user: User)

Scanner `Modules/User`: prima 103 occorrenze in 34 file (78 text, 5 attr, 2 phrase-key, 3 href-locale, 1 url-literal, 5 route-page-name, 9 route-unknown), dopo 102 in 33 file (77 text, 5 attr, 2 phrase-key, 3 href-locale, 1 url-literal, 5 route-page-name, 9 route-unknown). Una sola Blade aveva un testo vero: `components/ui/marketing/header` («il progetto» -> `user::layout.brand.project.label`, 4 lingue; la prima versione a 5 segmenti e' stata portata a 4 con `lang-rekey`).

- Il lavoro vero e' stato sulle chiavi mancanti: `check-blade-keys` su `Modules/User` da 73 chiavi mancanti (it 7, en 2, de 54, es 72) a 10 (it 5, en 0, de 5, es 9).
- Chiavi aggiunte: de +46, es +60, en +5, it +1 (cosi' `layout.brand.project.label`). File nuovi in `de`: `super_admin_widget`, `socialite`, `terms_of_service`, `notifications_center`; in `es`: gli stessi piu' `password_expired`, `profile`; file ampliati: `profile`, `password_expired`, `login`, `login_widget`, `widgets`, `layout`. In `de/auth.php` e `es/auth.php` (hanno commenti: modifica a mano) aggiunti `auth_button.*`, `back_to_home`, `logout` e, in `es`, `password_reset.*`. In `de/widgets.php` sei valori che erano copie dell'italiano («Modifica Profilo Utente», ...) sono stati tradotti. Le voci `pub_theme::ui.header_area_personale.*` usate da `pages/area-personale/*` sono state aggiunte al tema Two (vedi la story di Two).
- Ancora mancanti (10): `user::auth.reset_password.{title,subtitle,submit}.text` (in `de` e' una stringa, in `es` manca), `user::auth.logout_success.text` e `user::auth.login-via.text` (in `de` sono stringhe, la Blade vuole un array), `user::auth.social.*` e `pub_theme::auth.login.submit` in `livewire/auth/login.blade.php` (copia non referenziata; in `it` `auth.social.*` e' un array a cinque campi). `auth.php` ha commenti e forme miste stringa/array: va riordinato da una persona prima di aggiungere chiavi.
- Residui (102), nessuno e' un errore: starter kit Genesis (pagine `genesis/about`, `genesis/power-ups`, `learn`, `dashboard`, `welcome`, `livewire/toast` con «John Doe», `index` e `layouts/master` dello scaffold nWidart): il testo stesso di `power-ups` dice di rimuovere `pages/genesis` prima della produzione. Correzione al conteggio precedente («non instradato»): `folio:list` monta `genesis/about`, `genesis/power-ups` e `learn`, ma sul sito servito rispondono 404 (GET con Two attivo); sono comunque pagine di sviluppo e non le ho tradotte (restano anche `__('Dashboard')` e `__('Learn More')`); direttive e frammenti (`@error`, `@volt`, `@svg`, `@teleport`, `@hasSection`); marchio «SALUTE ORA» in `auth/register`; `alt="Laravel Logo"`; 3 `href="/it/informativa-privacy"|"/it/cookie-policy"` in `auth/register` (vista non referenziata; per una pagina a un solo segmento il nome dell'indice cambia per tema, `container0` o `container0.index`, quindi non c'e' una rotta valida per tutti i temi); `route-unknown`, `url-literal`, `route-page-name` non toccati per decisione dell'utente.
- Controlli: `check-key-shape`: nessuna chiave mia tra le storte; compilazione Blade OK su tutto il modulo (nessun file non compila); `php -l` pulito sui 24 file lingua toccati. HTTP: le pagine User che passano da Two non sono raggiungibili senza login; nessuna prova a video.
- Non verificato: i valori `en` di `password_expired.title` e `sub_heading` sono in italiano (preesistenti, non toccati); i testi PHP (`->label()` ecc.) non cercati; le traduzioni `de`/`es` aggiunte non sono state riviste da un madrelingua.
