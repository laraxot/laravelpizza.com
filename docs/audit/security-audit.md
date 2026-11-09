# Security audit

> Audit del 2026-11-05, branch `dev`. Verifiche **non distruttive**: lettura del codice, ricerca di pattern, `npm audit` sui lockfile, test automatici in locale. Nessun test contro sistemi esterni o di produzione.
> Stato: ✔ corretto in questo ciclo · ⏳ aperto.

| ID | Gravità | Area | Problema | Evidenza | Stato |
|---|---|---|---|---|---|
| S-01 | **Alta** | Esposizione dati | Bozze ed eventi `pending` raggiungibili da chiunque, nella lista e nel dettaglio | `events.json` senza scope; `[container0]/[slug0]/index.blade.php` e `blocks/events/detail.blade.php` con `Event::where('slug')` | ✔ lista con `scopes: [published, upcoming]`; dettaglio con `Event::visibleTo($user)` e 404 |
| S-02 | **Alta** | Esposizione dati | `Modules/Cms/app/Actions/ResolvePageAction::queryModel()` risolve qualsiasi `/{container}/{slug}` su un modello indovinato dal nome (`Modules\{X}\Models\{Y}`, `App\Models\{Y}`), **ignorando global scope e soft delete** (`newQueryWithoutScopes()` + query raw sulla tabella) e cercando su `id`, `uuid`, `user_id`, `user_name` | Righe ~60-140 | ⏳ parziale: il contenitore `events` non passa più dal resolver. Il resolver va limitato a una whitelist esplicita (`xra.container0_model_map`) e deve rispettare scope e soft delete. Il modulo Cms è condiviso con altri progetti: serve un intervento coordinato |
| S-03 | **Alta** | XSS memorizzato | JSON-LD stampato con `{!! json_encode(...) !!}` senza `JSON_HEX_TAG`: un titolo con `</script><script>…` esce dal blocco script. I titoli arrivano anche dalle proposte utente (`ProposeMeetupAction`) | `detail.blade.php:396`, `Modules/Cms/resources/views/components/metatags.blade.php:51` | ✔ aggiunti `JSON_HEX_TAG / AMP / APOS / QUOT` |
| S-04 | **Alta** | Integrità | Sovra-iscrizione possibile in concorrenza: la verifica di capienza legge il modello in memoria, senza lock, e la transazione gira sulla connessione di **default** mentre i modelli usano la connessione `meetup` (quindi non protegge niente) | `RegisterAttendeeToEventAction`, `BaseModel::$connection = 'meetup'` | ✔ transazione su `$event->getConnection()`, rilettura con `lockForUpdate()`, test con modello stantio. Stesso fix per le altre 7 Action del modulo |
| S-05 | Media | Autenticazione | Login senza limite di tentativi: il widget Livewire non passa dal middleware `throttle`. Dopo un login riuscito, inoltre, la `redirect()` non era restituita e veniva aggiunto comunque l'errore `auth.failed` | `Modules/User/app/Filament/Widgets/Auth/LoginWidget.php` | ✔ `RateLimiter` per email+IP (5 tentativi/60s), `redirectIntended()` e `return` |
| S-06 | Media | Segreti | Nel repository **pubblico** sono committati `APP_KEY` e password DB (`.env.latest`, `.env.testing`, `.env.testing.backup`) | `git ls-files` | ⏳ da ruotare le chiavi se mai usate fuori dallo sviluppo; rimuovere i file dal repo e aggiungerli a `.gitignore`. Va deciso dal maintainer: cambia il setup locale di chi li usa |
| S-07 | Media | Autorizzazione | `BaseUser::canAccessPanel()` restituisce `true` per il pannello `admin` a **qualsiasi utente autenticato**, compresi quelli auto-registrati | `Modules/User/app/Models/BaseUser.php:311-327` | ⏳ da verificare cosa espone `/admin` (MainDashboard, profilo, link ai moduli) e se è voluto come "area utente". I pannelli di modulo (`meetup::admin`) richiedono invece il ruolo omonimo |
| S-08 | Media | Fail-open | `PageSlugMiddleware` intercetta qualsiasi `Throwable` e prosegue **senza** i middleware della pagina: se la lettura della pagina fallisce, una pagina protetta da `auth` (es. `events/my.json`) diventa pubblica | `Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php` | ⏳ deve fallire in modo chiuso (403/500) |
| S-09 | Media | Template injection | `Blade::render($item['value'])` su dati di blocco CMS: chi può modificare il JSON di una pagina può eseguire codice PHP | `T/components/blocks/sidebar/system-info.blade.php:37` | ⏳ oggi i JSON li modifica solo chi ha accesso al repo o al pannello; da rimuovere o limitare |
| S-10 | Bassa | Privacy | La pagina pubblica dell'evento mostra l'**email dell'organizzatore** | `detail.blade.php:66` | ⏳ decisione di prodotto: rendere la visibilità opzionale (opt-in) |
| S-11 | Bassa | Robustezza | `GET /auth/logout` eseguiva `dd('a')` e non disconnetteva; aveva lo stesso nome di rotta (`logout`) della rotta POST | `T/pages/auth/logout.blade.php` | ✔ usa `App\Livewire\Actions\Logout`, rotta rinominata `auth.logout` |
| S-12 | Bassa | Debug in produzione | 77 chiamate attive a `dd`, `dddx` o `dump` nel codice non di test (es. `Media/app/Actions/SaveAttachmentsAction.php:85`, `Rating/app/Models/Traits/HasRatingsTrait.php:211`) | `rg` | ⏳ |
| S-13 | Bassa | Dipendenze npm | Tema: 2 critical, 9 high (vite, rollup, postcss, axios, shell-quote, concurrently…). Root `laravel/`: 2 critical, 10 high | `npm audit` sui lockfile | ⏳ quasi tutte dipendenze di build; da aggiornare insieme al fix della CI |
| S-14 | Info | Mass assignment | `Event::$fillable` include `user_id`, `organizer_id`, `attendees_count`, `status` | `Event.php:155-175` | ⏳ oggi nessun input pubblico crea eventi; diventa rischioso quando `ProposeMeetupAction` sarà esposto in UI |

## Aree verificate senza rilievi bloccanti

- CSRF: i form usano Livewire (token incluso) o `@csrf`; i pannelli Filament hanno `VerifyCsrfToken`.
- SQL injection: nessuna query raw con input utente nel modulo Meetup. Il resolver CMS usa binding.
- Upload: `cover_image` usa `FileUpload::image()` di Filament nel pannello admin.
- Password: hashing standard Laravel e regenerate della sessione al login.

## Non verificato (limiti)

- `composer audit`: non eseguito con successo, il proxy ha interrotto l'advisory DB.
- Header di sicurezza (CSP, HSTS) e cookie `Secure`: dipendono dal web server, non presente nel repo.
- Isolamento multi-tenant: il tenant è determinato da `APP_URL` → `config/local/{tenant}`. Non è un multi-tenant con dati condivisi, quindi non c'è rischio di accesso cross-tenant a livello di riga.
