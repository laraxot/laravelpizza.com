# Runbook di rilascio e operatività — LaravelPizza

Procedura per mettere in produzione `laraxot/laravelpizza.com` e tenerlo in salute. Ogni comando è stato provato sull'ambiente di sviluppo il 10–11 novembre 2026; i punti marcati **da verificare in produzione** dipendono dal server reale.

## 1. Requisiti del server

| Componente | Versione / nota |
|---|---|
| PHP | 8.4 con `pdo_mysql`, `mbstring`, `intl`, `gd`, `zip`, `bcmath`, `opcache` |
| MySQL / MariaDB | MySQL 8.0+ — **due database**: dati (`DB_DATABASE`) e utenti (`DB_DATABASE_USER`) |
| Node | 22 (solo se si ricompila il tema sul server; gli asset compilati sono già nel repository) |
| Web server | document root = **`public_html/`** (non `laravel/public`); deve seguire i symlink (`public_html/themes/<Tema>`, `public_html/assets/<modulo>`) |
| Cron | `* * * * * cd /percorso/laravel && php artisan schedule:run >> /dev/null 2>&1` |
| Coda | un worker permanente (supervisor o systemd), vedi §5 |

## 2. Configurazione (`laravel/.env`)

Partire da `laravel/.env.example`. Valori obbligatori in produzione:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://laravelpizza.com        # determina il tenant: config/local/laravelpizza
APP_KEY=                                # php artisan key:generate --force (una volta sola)

DB_CONNECTION=mysql
DB_DATABASE=...  DB_USERNAME=...  DB_PASSWORD=...
DB_DATABASE_USER=...  DB_USERNAME_USER=...  DB_PASSWORD_USER=...

CACHE_STORE=database          # o redis
SESSION_DRIVER=database
QUEUE_CONNECTION=database     # le email partono in coda: senza worker non arrivano

MAIL_MAILER=smtp              # credenziali del provider reale
MAIL_FROM_ADDRESS=...  MAIL_FROM_NAME="Laravel Pizza Meetups"
CONTACT_EMAIL=...             # riceve i messaggi della pagina Contatti
HEALTH_NOTIFY_EMAIL=...       # riceve gli avvisi dei controlli di salute
```

Mai committare `.env`. I file `.env.*` presenti nel repository sono solo per sviluppo e test: la chiave di `.env.latest` è stata tolta; se in passato è stata usata su un server, **rigenerarla** (`php artisan key:generate --force`) invalida sessioni e dati cifrati con la vecchia.

## 3. Primo rilascio

```bash
git clone git@github.com:laraxot/laravelpizza.com.git && cd laravelpizza.com/laravel
git checkout dev            # o il ramo di rilascio
composer install --no-dev --optimize-autoloader   # esegue anche filament:upgrade (asset Filament in public_html)
cp .env.example .env && php artisan key:generate --force    # poi completare .env (§2)
php artisan migrate --force
php artisan storage:link    # public_html/storage -> storage/app/public (copertine degli eventi)
php artisan optimize        # config, route, view, eventi in cache
```

Poi creare l'utente organizzatore e assegnargli il ruolo `meetup::admin` (pannello `/meetup/admin`); il super-admin entra in `/admin`.

**Da verificare in produzione prima del primo `migrate` su un database esistente** (audit D-10b):
`SHOW COLUMNS FROM profiles;` sui due database. La migrazione `2026_10_16_000001_fix_profiles_id_autoincrement` converte `profiles.id` in auto-increment **solo se la tabella è vuota**; con dati presenti non tocca nulla e va valutata a mano.

## 4. Rilasci successivi

```bash
php artisan down --render="errors::503" --retry=60
git pull --ff-only
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
php artisan queue:restart     # i worker ricaricano il codice nuovo
php artisan up
```

Il tema compilato (`laravel/Themes/Meetup/public`) è nel repository; `public_html/themes/Meetup` è un **symlink** a quella cartella (tracciato da git). Se si modifica CSS/JS: `cd laravel/Themes/Meetup && npm ci && npm run build`, poi commit dei file generati. Non serve alcuna copia.

## 5. Processi in background

**Worker della coda** (email di conferma, promemoria, contatti, avvisi). Esempio supervisor:

```ini
[program:laravelpizza-worker]
command=php /percorso/laravel/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
stopwaitsecs=3600
stdout_logfile=/percorso/laravel/storage/logs/worker.log
```

**Scheduler** (cron del §1). Pianificati in `laravel/routes/console.php`:

| Comando | Frequenza | Scopo |
|---|---|---|
| `meetup:send-reminders` | ogni ora | promemoria agli iscritti degli eventi nelle 24 ore successive (una sola volta per iscrizione) |
| `health:check` | ogni minuto | controlli di salute, mail a `HEALTH_NOTIFY_EMAIL` se qualcosa fallisce (max una ogni ora) |
| `health:schedule-check-heartbeat` | ogni minuto | segnala che lo scheduler gira |

## 6. Monitoraggio

- `GET /up` → 200 se l'applicazione si avvia: per il load balancer o un monitor esterno (UptimeRobot, Better Stack…).
- `php artisan health:list` → ultimo esito di database, cache, spazio disco (avviso all'80%, errore al 90%), scheduler, `APP_DEBUG` spento e ambiente `production`.
- Errori applicativi: `storage/logs/laravel.log`. Consigliato collegare un servizio di error tracking (Sentry, Flare) tramite `LOG_STACK`.

## 7. Backup e ripristino

Ogni notte, conservando almeno 14 giorni, **fuori dal server**:

```bash
mysqldump --single-transaction --routines "$DB_DATABASE"      | gzip > "dati-$(date +%F).sql.gz"
mysqldump --single-transaction --routines "$DB_DATABASE_USER" | gzip > "utenti-$(date +%F).sql.gz"
tar czf "storage-$(date +%F).tgz" -C /percorso/laravel storage/app/public
```

Ripristino (provarlo almeno una volta su uno staging prima di andare in produzione):

```bash
php artisan down
gunzip -c dati-AAAA-MM-GG.sql.gz   | mysql "$DB_DATABASE"
gunzip -c utenti-AAAA-MM-GG.sql.gz | mysql "$DB_DATABASE_USER"
tar xzf storage-AAAA-MM-GG.tgz -C /percorso/laravel
php artisan optimize:clear && php artisan optimize && php artisan up
```

## 8. Rollback

1. `php artisan down`
2. `git checkout <commit precedente>` e `composer install --no-dev --optimize-autoloader`
3. Le migrazioni di questo progetto aggiungono colonne e tabelle senza toglierne: di norma il codice precedente funziona con lo schema nuovo e **non** serve `migrate:rollback`. Se una migrazione ha trasformato dati, ripristinare il backup del §7.
4. `php artisan optimize && php artisan queue:restart && php artisan up`

## 9. Controllo dopo ogni rilascio (5 minuti)

- [ ] `/it` e `/en` si aprono; menu e footer senza link rotti
- [ ] `/it/events` mostra i prossimi eventi, il filtro per città funziona, `/it/events-past` si apre
- [ ] registrazione di un account di prova, iscrizione a un evento, arriva l'email con il file `.ics`
- [ ] `/it/contact`: il messaggio arriva a `CONTACT_EMAIL`
- [ ] `/meetup/admin`: elenco eventi, modifica di un evento, scheda Iscritti con "Scarica CSV"
- [ ] `php artisan health:list` tutto OK; `php artisan schedule:list` mostra i tre comandi
- [ ] DevTools → Rete: nessuna richiesta a domini terzi al primo caricamento (niente Google Fonts)
- [ ] Accessibilità: `cd laravel/Themes/Meetup && BASE_URL=https://laravelpizza.com npm run a11y` → 0 violazioni WCAG 2.1 AA

## 10. Test e CI

- Bloccanti: `vendor/bin/pest --testsuite=Project` (modulo Meetup, che contiene anche i test di app e tema: ogni modulo tiene i suoi test, niente `laravel/tests`), PHPStan livello 10 su `Modules`, Pint, build del tema.
- Informativi: le suite dei moduli Laraxot condivisi (Xot, User, Cms, …), pubblicate nel riepilogo del job CI. Contengono test scritti per altri progetti; vanno sistemate nei rispettivi repository dei moduli.
- Attenzione: in locale alcune suite di Xot eseguono comandi composer sul progetto reale (`storage/framework/composer-home`) e possono riscrivere `vendor/composer/autoload_*`. Lanciarle solo in CI o su una copia; se succede, `composer dump-autoload` ripristina.
