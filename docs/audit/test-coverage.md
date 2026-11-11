# Test coverage e risultati

> Eseguiti il 2026-11-05 in locale: PHP 8.4.27, MySQL 8.0 (conda-forge), `.env.testing`, database ricreati da zero. Coverage non misurata: driver pcov/xdebug non attivo.

## Ciclo 3 (11 novembre 2026)

- **Suite bloccante `Project`** = `laravel/Modules/Meetup/tests` (ogni modulo tiene i suoi test; quelli di `app/` e del tema sono in `Meetup/tests/{Feature,Unit}/App` e `Unit/Architecture`): **395 test verdi, 1 saltato**. Comando: `cd laravel && vendor/bin/pest --testsuite=Project`.
- Prima: 33 test Meetup rossi (rotte POST inesistenti, file che estendeva `Tests\TestCase` senza transazioni sul database utenti e lasciava `test@example.com`, pagina profilo duplicata con lo stesso componente Volt, aspettative superate). Tutti riscritti o corretti, e con loro i bug reali trovati.
- Nuovi test: `Feature/Admin/OrganizerPanelTest`, `Feature/PublicEventsListTest`, `Feature/ContactFormTest`, `Unit/Models/MeetupDataIntegrityTest`, `Unit/Actions/Event/CalendarAndRemindersTest`, `Unit/Architecture/ThemePublicSymlinkTest`.
- **Moduli condivisi** (Xot, User, Cms, Geo, Gdpr, Notify, …): eseguiti modulo per modulo con `php artisan xot:build-test-sqlite` e `DB_SQLITE_FILE=test_data.sqlite`. Da circa 3.500 a circa 1.600 fallimenti, quasi tutti test scritti per Fixcity o altri progetti. In CI girano in un job informativo che pubblica il riepilogo.
- Attenzione: alcune suite di Xot lanciano composer sul progetto reale e possono riscrivere `vendor/composer/autoload_*` (si ripristina con `composer dump-autoload`).

## Come riprodurre

```bash
cd laravel
cp .env.testing .env            # o configurare DB_* e DB_*_USER
php artisan migrate --env=testing --force
vendor/bin/pest Modules/Meetup/tests --no-coverage
```

## Risultati

| Suite | Prima (HEAD `6fbf2141`) | Dopo questo ciclo | Note |
|---|---|---|---|
| Migrazioni da zero su MySQL | ❌ falliscono in 3 punti | ✅ tutte | Vedi [database-audit.md](database-audit.md) D-11 |
| `Modules/Meetup/tests` | 270 ✅ / 57 ❌ | **311 ✅ / 33 ❌** | 0 regressioni (confronto JUnit test per test); 17 test nuovi, tutti verdi |
| `Modules/Meetup` + `Modules/Cms` insieme | 292 ✅ / 612 ❌ | 313 ✅ / 608 ❌ | I 2 "peggioramenti" del confronto sono dovuti a dati residui (`test@example.com` lasciato nel DB da un test che non fa rollback) e passano su un DB pulito |
| PHPStan max su `Modules/Meetup/app` + `LoginWidget` | non eseguibile in CI (fatal) | ✅ 0 errori | |
| Pint sui file modificati | — | ✅ | 1.868 problemi di stile preesistenti nel resto del codice |
| `php -l` su 6.212 file PHP | 8 file con errori di sintassi | 2 test riparati (`Geo/…/CalculateDistanceActionTest.php`, `Tenant/tests/Unit/domaintest.php`) | Restano rotti solo file di `docs/` e config cs-fixer di Tenant |

## Test aggiunti in questo ciclo

| File | Cosa verifica |
|---|---|
| `Meetup/tests/Unit/Actions/Event/RegisterAttendeeToEventActionTest.php` (+3) | Bozza rifiutata, evento iniziato rifiutato, capienza rispettata con modello in memoria stantio |
| `Meetup/tests/Unit/Actions/Event/DeleteEventActionTest.php` (+1) | L'eliminazione rimuove le iscrizioni dell'evento e non tocca gli altri |
| `Meetup/tests/Feature/EventVisibilityPageTest.php` (6) | Bozza/pending → 404, slug inesistente → 404, il proprietario vede la bozza, lista pubblica solo pubblicati e futuri, JSON-LD non iniettabile |
| `Meetup/tests/Feature/Livewire/EventRegistrationTest.php` (5) | Iscrizione con email in coda, nessuna email se rifiutata, guest → login e ritorno all'evento, iscrizione e annullamento, evento pieno |
| `Meetup/tests/Feature/Security/LoginWidgetSecurityTest.php` (2) | Login riuscito senza errore spurio; blocco dopo 5 tentativi |
| `Meetup/tests/Feature/Security/LogoutPageTest.php` (2) | Pagina di logout senza `dd()`; nomi di rotta distinti |

## Fallimenti residui in Meetup (33, tutti preesistenti)

Raggruppati per causa (dettaglio in `docs/audit/` → rieseguire con `--log-junit`):

1. **Test scritti per rotte inesistenti** (`AuthTest`: POST `/it/register`, `/it/login` → 405; il login reale è un widget Livewire). Vanno riscritti come test Livewire, sul modello di `LoginWidgetSecurityTest`.
2. **Stub di analisi statica eseguiti a runtime** (`LoginTest`: `RuntimeException: Stub: This function is meant for static analysis only`).
3. **Aspettative obsolete sull'HTML** (`HeaderLocalizationTest`, `HeaderNavigationTest`, `PagesTest`).
4. **Registrazione a cartella confliggente**: `Feature/Auth/LoginTest.php` fa `pest()->extend(Tests\TestCase::class)->in(__DIR__)`, imponendo un TestCase a tutta la cartella.
5. **Isolamento**: almeno un test lascia un utente nel DB `user` (1 riga dopo ogni run).

## Lacune di test sui percorsi critici

- Nessun test end-to-end nel browser (la cartella `User/tests/Playwright` esiste, ma non è collegata alla CI).
- Nessun test della Resource Filament `EventResource` (capienza obbligatoria, conferma di eliminazione): richiede un utente con ruolo `meetup::admin` nei test.
- Nessun test di concorrenza reale (due processi): il test con modello stantio copre la logica, non il lock MySQL.
- Il test `IndividualFolioRoutesTest` salta invece di fallire sugli errori 500 (R-04).
