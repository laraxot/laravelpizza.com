---
title: "Localizzazione e traduzioni del tema Meetup"
type: rule
status: active
theme: Meetup
qmd: "localizzazione localization mcamara laravel-localization traduzioni pub_theme lang chiavi hardcoded stringhe locale prefix url localizzati folio SetFolioLocale"
---

# Localizzazione e traduzioni del tema Meetup

## Perche' esiste

Il prefisso lingua dell'URL (`/it`, `/en`, `/de`, ...) deve comandare tutto: la lingua del documento, i link che l'utente segue, le azioni dei form e ogni testo della pagina. Basta un link scritto a mano o una frase dentro una Blade per avere una pagina tedesca con pezzi in italiano. Questa pagina e' lo standard unico per URL localizzati e traduzioni nel tema; il selettore lingua e' in [language-switcher.md](language-switcher.md).

## Come funziona

- **Pacchetto**: `mcamara/laravel-localization`. Lingue in `config/laravellocalization.php`: `it`, `en`, `de`, `fr`, `es`, `ru` (ordine in `localesOrder`); `hideDefaultLocaleInURL` e' `false`, quindi anche l'italiano ha il prefisso.
- **Rotte**: `Modules/Cms/app/Providers/FolioVoltServiceProvider.php` registra le pagine Folio del tema una volta per lingua (`Folio::path($theme_path)->uri($locale)`), con il middleware `SetFolioLocale` davanti a tutti gli altri.
- **Lingua della richiesta**: `Modules/Cms/app/Http/Middleware/SetFolioLocale.php` sceglie, in quest'ordine: primo segmento dell'URL se e' una lingua supportata (vince sulla preferenza dell'utente); altrimenti la lingua salvata dall'utente (`lang`), se supportata; altrimenti `config('app.locale')`. Poi chiama sia `app()->setLocale()` sia `LaravelLocalization::setLocale()`: senza la seconda, `localizeUrl()` e `getLocalizedURL()` ricadrebbero sull'italiano.
- **Traduzioni**: `ThemeServiceProvider` registra `Themes/Meetup/lang` con il namespace `pub_theme::`.
- **`<html lang>`**: `x-layouts.main` lo ricava da `app()->getLocale()`. Una URL `/de` deve produrre `lang="de"`.

### Le pagine Folio non impostano la lingua

Folio esegue il blocco PHP iniziale di ogni pagina anche solo per leggere `name()` e `middleware()` (per esempio quando si genera `route('login')` in un'e-mail inviata dalla coda). Un `setLocale()` li' cambiava la lingua dell'intero processo e le e-mail in tedesco uscivano in italiano. Quindi nessuna pagina in `resources/views/pages` chiama `setLocale()`; la guardia e' `Modules/Meetup/tests/Unit/Architecture/FolioPagesWithoutSideEffectsTest.php`. La lingua la decide solo il middleware.

`Modules/UI/app/Http/Middleware/SetLocale.php` (lingua da sessione, solo `it`/`en`) e `Modules/UI/app/Http/Controllers/LanguageController.php` sono un altro meccanismo: il tema non li usa.

## URL: sempre localizzati

| Cosa | Come |
|---|---|
| Link a una pagina | `LaravelLocalization::localizeUrl('/events')` (percorso senza prefisso) |
| `action` di un form (login, registrazione, invio) | URL localizzato, es. `localizeUrl('/auth/login')`: altrimenti il redirect del middleware trasforma il POST in GET |
| Cambio lingua mantenendo la pagina | `LaravelLocalization::getLocalizedURL($code, null, [], true)` |
| Lingua corrente in PHP | preferire `LaravelLocalization::getCurrentLocale()` a `app()->getLocale()` |
| Link a pagine CMS | rotte Folio generiche: `route('container0', ['container0' => 'events'])`, `route('container0.view', ['container0' => 'events', 'slug0' => 'my'])`; il prefisso lo aggiunge Folio |

Da non fare: `url('/it/events')`, `url(app()->getLocale().'/events')`, `href="/it/..."`, `url('/percorso')` per pagine pubbliche. Nel tema ci sono oltre 70 chiamate a `localizeUrl`; i percorsi sono quelli del contenuto reale (`/events`, `/auth/login`, `/auth/register`, `/profile`).

Operativo (mcamara): con `route:cache` il pacchetto non funziona, in produzione si usa `php artisan route:trans:cache` (e `route:trans:clear`, `route:trans:list {locale}`). Nei test le richieste vanno fatte con il prefisso (`$this->get('/en/')`) e, per cambiare lingua, con `refreshApplicationWithLocale($locale)`; senza, le rotte localizzate possono dare 404 perche' l'app e' avviata prima della richiesta. Gli alias dei middleware di Laravel 11+ stanno in `bootstrap/app.php`. Riferimento completo: `Modules/Lang/docs/laravel-localization-mcamara-reference.md`; routing Folio per lingua: `Modules/Cms/docs/folio-routing-locale.md`.

## Traduzioni: nessun testo fisso nelle Blade

**Regola**: ogni testo visibile (anche `aria-label`, `placeholder`, `title`, `alt`) esce da una chiave di traduzione, in qualunque lingua. Sono violazioni `__('Accedi')`, `<span>Registrati</span>` e ogni fallback italiano "per riparare" una traduzione mancante. Fanno eccezione marchi e nomi propri, sigle, autonimi di lingua, numeri e valori che arrivano dal modello o dal CMS. Il tema non e' il posto dove si ripara una localizzazione mancante.

**Forma della chiave**: `pub_theme::contesto.collezione.chiave.tipo`, dove `contesto` e' il nome del file in `lang/<locale>/` e `tipo` il genere di testo: `label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`. Esempio: `__('pub_theme::navigation.auth.login.label')`. Mai la frase come chiave. La struttura e' sempre annidata ed espansa; le chiavi piatte (`event.date.label` accanto a `event.fields.date.label`) sono vietate perche' duplicano il dato e non possono portare `tooltip` o `description`. Un testo di modulo vive nel modulo e si usa con il suo namespace (`gdpr::register.title`).

La chiave si calcola dal file e dai livelli: `Modules/Gdpr/lang/it/register.php` che ritorna `['title' => ...]` e' `gdpr::register.title`, non `gdpr::register.register.title`.

**File del tema** (`Themes/Meetup/lang/it`): `account`, `assistant`, `auth`, `cards`, `common`, `errors`, `event`, `events`, `footer`, `forms`, `header`, `home`, `layout`, `legal`, `navigation`, `profile`, `services`. `event.php` e' strutturato in `navigation`, `label`/`plural_label`, `fields.*` (data, orario, luogo, partecipanti...), `actions.*` (condividi, iscriviti, annulla...), `status.*`, `messages.*` (posti in esaurimento, nessun evento...), `not_found`. Esempi veri: `pub_theme::event.fields.date.label`, `pub_theme::event.actions.share_event.label`, `pub_theme::event.messages.spots_filling_fast.label`.

**Aggiungere un testo**

1. Scegli il file lingua giusto (`navigation` per nav e footer, `event` per il dettaglio evento, ...).
2. Aggiungi la chiave con le stesse chiavi e gli stessi `:parametri` in `it` e `en` (obbligatori) e in `de`, `es`; `it` e' l'originale, le altre sono traduzioni vere.
3. Usala nella Blade con `__()`. Se la stringa e' dentro un link, la frase si spezza e il markup resta nella Blade.
4. Verifica a mano `/it/...` e una lingua non italiana.

**Copertura attuale**: `it` e `en` 17 file, `de` e `es` 16 (manca `assistant`), `fr` e `ru` 7 (`auth`, `errors`, `event`, `events`, `home`, `navigation`, `profile`), `hi` e `zh` solo `event`. `hi` e `zh` non sono in `supportedLocales`. Il `fallback_locale` e' `it`: una chiave mancante in un'altra lingua non da' errore e mostra l'italiano.

## Guardie automatiche

- `Modules/Meetup/tests/Unit/Architecture/ThemeIntegrityTest.php`: ogni chiave `pub_theme::file.chiave` usata in una Blade del tema deve esistere in `lang/it` e `lang/en`.
- `Modules/Meetup/tests/Feature/HeaderLocalizationTest.php`: l'intestazione segue la lingua dell'URL per `it en de fr es ru`.
- `Modules/Meetup/tests/Unit/Architecture/FolioPagesWithoutSideEffectsTest.php`: nessun `setLocale()` nelle pagine.
- Test minimi per ogni pagina toccata: home in `it`, `en`, `de` con `lang` coerente; almeno un link del layout che resta nella stessa lingua; nessuna `form action` nuda. Storia del lavoro di bonifica: [stories/blade-i18n-no-hardcoded-text.story.md](stories/blade-i18n-no-hardcoded-text.story.md).

## Errori tipici

| Sintomo | Causa | Rimedio |
|---|---|---|
| `/en` mostra `lang="it"` | Il middleware non ha girato (rotta fuori dal gruppo Folio per lingua) o la lingua e' impostata dopo la resa | Verifica la rotta; non toccare la lingua dalla pagina |
| Compare `pub_theme::event.fields.x.label` come testo | Chiave inesistente o file lingua non caricato | Controlla percorso e file; `ThemeIntegrityTest` la segnala per `it`/`en` |
| Testo italiano su pagina `/de` | Chiave mancante in `de` (fallback `it`) o stringa fissa | Aggiungi la chiave in tutte le lingue |
| Dopo il login la pagina e' un GET | `action` del form non localizzata | `localizeUrl()` nell'`action` |
| Link senza prefisso lingua | URL costruito a mano | `localizeUrl()` |

## Da verificare

- La regola di progetto preferisce `getCurrentLocale()`, ma `x-layouts.main` e il selettore lingua leggono `app()->getLocale()` o il primo segmento dell'URL; i due valori coincidono grazie a `SetFolioLocale`.
- La story citata parla di quattro lingue (`it`, `en`, `de`, `es`); `fr` e `ru` sono nel selettore ma i file lingua sono parziali.

## Vedi anche

- [language-switcher.md](language-switcher.md)
- [header-footer-logo.md](header-footer-logo.md)
- [folio-routing.md](folio-routing.md)
- [seo-structured-data.md](seo-structured-data.md)
- [troubleshooting.md](troubleshooting.md)
