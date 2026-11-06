---
title: "Niente testi fissi nelle Blade del modulo UI (multilingua it/en/de/es)"
type: story
status: implemented
module: UI
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo UI

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('ui::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/UI/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere. Se l'originale era inglese, `en` lo conserva e `it` e' la traduzione.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt`, per i default testuali di `@props` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori che arrivano dal modello o dal CMS, `alt=""` decorativo.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 2.685 occorrenze in 192 file a 135 in 50 file (stesso strumento, commit di partenza contro stato attuale).
- Oltre 180 Blade convertite: blocchi CMS (hero, CTA, blog, sezioni di funzioni, header, galleria, newsletter, listini, statistiche, testimonianze, appuntamenti, documenti, materiali, idoneita', dashboard paziente, notifiche, profilo), componenti `ui/`, `filament/` e `livewire/`. Portati a `__()` anche i default testuali di `@props` e i `?? 'Testo'`.
- Creati 24 file lingua per ognuna delle quattro lingue, circa 860 chiavi per lingua: 21 di blocchi (`blocks_hero`, `blocks_cta`, `blocks_blog`, `blocks_feature_sections`, `blocks_header`, `blocks_gallery`, `blocks_newsletter`, `blocks_newsletter_archivied`, `blocks_appointments`, `blocks_documents_list`, `blocks_educational_materials`, `blocks_eligibility_checker`, `blocks_notifications_list`, `blocks_patient_dashboard`, `blocks_pricing`, `blocks_pricing_plans`, `blocks_slider`, `blocks_stats`, `blocks_testimonials`, `blocks_user_profile`, `blocks_demo_shared`) e 3 di componenti (`components_ui`, `components_shell`, `components_common`).
- Completati de/es nei file condivisi per le chiavi usate dalle Blade: `auth`, `components`, `datepicker`, `interactive_map`, `navigation`, `redirect`, `services`, `stepper`, `studio-selector`, `widgets`.
- Scelte: gli originali italiani restano identici in `it`; gli originali inglesi (demo Tailwind) sono identici in `en`; il riempitivo latino e' uguale in tutte le lingue; le date demo seguono il formato di ogni lingua; le frasi spezzate dal markup sono scritte perche' la coda resti valida; i parametri sono `:plan`, `:price`, `:count`, `:company`, `:number`.

## Residui dichiarati (135 occorrenze)

| Categoria | N |
|---|---:|
| Direttive Blade e frammenti Alpine (`@error`, `@csrf`, `@svg`, `@teleport`, ...): falsi positivi | 40 |
| Nomi di persona nei blocchi demo (autori, testimonianze) | 37 |
| Riempitivo latino (lorem ipsum), senza lingua | 31 |
| Marchi (social, loghi di clienti demo) | 10 |
| Segnaposto e scaffold di sviluppo | 6 |
| Codice valuta `USD` | 4 |
| Nomi di file in pannelli di codice demo | 4 |
| Luogo (nome proprio) in un annuncio demo | 3 |

Testi in PHP (`->label()` e simili): non cercati in questa campagna sul modulo, quindi non toccati.

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- In `blocks_pricing_plans`, `blocks_stats` e `blocks_testimonials` i valori `it` erano l'originale inglese dei demo Tailwind. Sono stati tradotti (148 valori: 100, 44 e 4) con `:parametri` ed entita' `&nbsp;` invariati; restano uguali il lorem ipsum, che e' segnaposto in tutte le lingue, e i nomi di piano che sono nomi di prodotto (Enterprise, Hobby, Premium, Scale, Starter, Startup, Team).
- Alcuni file `de` preesistenti contengono ancora voci in italiano, non sovrascritte; alcune chiavi preesistenti hanno quattro elementi invece di cinque e non sono state rinominate.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

## Seguito: forma delle chiavi

Le chiavi a 2-3 segmenti create da questa campagna sono state in parte portate a `ns::file.collezione.chiave.tipo`: **62 chiavi spostate** in questo proprietario (stesso testo, tutte le lingue, usi riscritti, nessun uso della vecchia chiave rimasto). La frase sui «tre o quattro elementi» qui sopra descrive lo stato precedente: le chiavi rimaste a 3-4 elementi non sono state verificate una per una; la misura assoluta, lo strumento e i residui sono in [la story di Lang](../../../Lang/docs/stories/translation-key-shape-rekey.story.md).

## Chiavi mancanti colmate

Il controllo statico `bashscripts/tools/i18n/check-blade-keys.php` (solo `Modules/UI`, 300 Blade, 2.909 usi) segnalava 36 chiavi distinte usate dalle Blade e assenti dai file lingua, tutte anteriori alla campagna. Una chiave assente mostra la chiave grezza (o l'italiano, se manca solo in `en`/`de`/`es`).

| Lingua | Prima | Dopo |
|---|---:|---:|
| `it` | 14 | 0 |
| `en` | 17 | 2 |
| `de` | 23 | 2 |
| `es` | 36 | 2 |

Aggiunti i valori alle chiavi cosi' come le usano le Blade (nessuna rinominata, nessuna Blade toccata). Le chiavi a 3-4 elementi di `studio_selector`, `widgets.user-calendar`, `aws_test` e `pages.s3test` restano nella forma gia' in uso.

| Chiave (famiglia) | Blade | File lingua toccati |
|---|---|---|
| `ui::studio_selector.*` (11) | `ui/studio-selector` | `studio_selector.php` nuovo in `it`, `en`, `de`, `es` |
| `ui::widgets.user-calendar.*` (3) | `filament/widgets/user-calendar` | `widgets.php` in `it`, `en`, `de`, `es` |
| `ui::auth.profile.*`, `ui::auth.logout.cancel_button` (10) | `components/blocks/change_password` | `auth.php` in `de` (requisiti password) e `es` |
| `ui::components.state_icons.no_transitions` | `components/ui/state-icons-split` | `components.php` in `de`, `es` |
| `ui::aws_test.no_results` | `awstest`, `test-results` | `aws_test.php` nuovo in `en`, `de`, `es` (in `it` c'era gia') |
| `ui::pages.s3test.*` (2) | `filament/clusters/test/pages/s3test` | `pages.php` nuovo in `es` |
| `ui::opening_hours.*` (6) | `filament/forms/components/opening-hours-field` | `opening_hours.php` nuovo in `es` |

Note sui valori: `it` e' l'italiano naturale (nessuna Blade aveva un testo di riserva); `en`, `de`, `es` sono traduzioni, con `:studio_name` e `:count` invariati. `doctors_count` e' letto con `trans_choice` e usa il formato `{1} ...|[2,*] ...`. Per `studio_selector` in `es` la parola e' «clinica» e in `de` «Praxis», come nel `studio-selector.php` esistente.

Restano 2 chiavi, fuori dal perimetro di questa passata (non sono in `Modules/UI/lang`): `user::login.page.title` e `user::login.page.subtitle`, usate da `components/layouts/auth-split` e assenti in `en`, `de`, `es` del modulo User.

Da sapere, non toccato: `de/auth.php` ha ancora in italiano `register.*`, la maggior parte di `profile.*` (anche `update_password`, usata da `change_password`), `user_dropdown.*` e `logout.*` (il controllo le conta come presenti perche' la chiave esiste); `en/studio-selector.php` e `de/studio-selector.php` hanno ancora in italiano le voci `actions`, `empty`, `fields`, `accessibility`. Il controllo e' euristico e non cerca chiavi costruite a runtime; nessuna pagina e' stata guardata in un browser.

### Passata 2026-10-30 (sessione 97f16a39, i18n-geo-ui: UI)

Scanner `Modules/UI`: prima 162 occorrenze in 57 file (126 text, 9 attr, 3 route-page-name, 24 route-unknown), dopo 162 in 57 file: nessuna Blade toccata, ogni voce valutata.

- Falsi positivi dello scanner (nessun testo da tradurre): direttive Blade e frammenti Alpine (`@error`, `@csrf`, `@method`, `@svg`, `@teleport`, `@break @case`, `, 'disabled': currentStep` in `stepper`, `aria-label` con `getDayAriaLabel(day)` e con `@js(__('ui::auth.navigation.*'))`).
- Demo Tailwind lasciate: nomi di persona e di luogo («San Francisco, CA»), lorem ipsum, `USD`, marchi (Facebook, Twitter, WhatsApp, loghi `alt` Tuple/Mirage/StaticKit/Transistor/Workcation), nomi di file nei pannelli di codice.
- Scaffold: `index` («Hello World»), `layouts/master` («Module UI»), `components/nav-link` («nav-link»), `filament/table/collapsible-row-content` («AAAAAAA»), `filament/widgets/stat-with-icon` («BBB», la Blade non compila gia' prima: la corregge un altro agente).
- Non toccate per decisione dell'utente: 24 `route-unknown` e 3 `route-page-name` (`profile.edit` in `patient_dashboard`, `user_profile`, `ui/app/header`).
- Controlli: `check-blade-keys` su `Modules/UI`: restano 2 chiavi mancanti, entrambe `user::login.page.*` (modulo User); le altre erano gia' state colmate dalla sezione «Chiavi mancanti colmate» qui sopra (task `ui-missing-lang-keys`), non da questa passata.
- Non verificato: il confronto `en == it` sulle 944 chiavi usate dalle Blade trova 173 (en), 169 (de) e 157 (es) valori uguali all'italiano; la gran parte e' lorem ipsum, nomi di prodotto o termini uguali (Blog, Video, Logo); le voci italiane vere in `de/auth.php` sono gia' elencate sopra e non sono state toccate.
