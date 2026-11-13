---
title: "Runbook di produzione FixCity"
type: runbook
created: 2026-11-10
updated: 2026-11-12
related:
  - ../stories/ci-deploy-ops-hardening.story.md
  - ../ci/ci-pipeline.md
  - ../../../Fixcity/docs/audit/QUALITY_CI_OPS_AUDIT.md
---

# Runbook di produzione FixCity

Per chi gestisce il server. I comandi si possono copiare, ma prima vanno sostituiti i valori di esempio:

- `/var/www/fixcity` è la cartella del repository;
- `www-data` è l'utente del web server;
- `fixcity_data` e `fixcity_user` sono i due database.

Copre i finding OPS-10, OPS-11, OPS-12 e OPS-13 dell'audit.


> **`public_html` è la document root del sito.** Non va mai cancellata né svuotata: né a mano, né da uno script, né da
> una build. Nessuna build scrive più lì: temi e moduli compilano nella propria cartella `public` e la document root ci
> punta con symlink (`themes/<Tema>`, `assets/<modulo>`; vedi `../theme-assets-workflow.md`). `deploy.sh` si ferma se
> manca `public_html/index.php`.

## 1. Variabili d'ambiente obbligatorie

Il file `laravel/.env` deve partire da `laravel/.env.production.example`. Non si committa mai.

| Variabile | Valore in produzione | Perché |
|---|---|---|
| `APP_ENV` | `production` | Spegne i default pensati per lo sviluppo (pagine demo, bypass CIE). |
| `APP_DEBUG` | `false` | Con `true` gli errori mostrano stack trace e valori del `.env`. |
| `APP_KEY` | chiave nuova (`php artisan key:generate --show`) | Non riusare le chiavi presenti nei `.env.*` versionati (OPS-14). |
| `APP_URL` | `https://<host>` | Usata per i link nelle mail e nelle sitemap. |
| `TRUSTED_HOSTS` | host del sito, separati da virgola | Se è vuota l'header Host non viene controllato. |
| `TRUSTED_PROXIES` | IP del proxy o del load balancer | Se è sbagliata l'app non vede HTTPS. |
| `SHOWCASE_PAGES` | `false` | Toglie le pagine demo con dati finti. |
| `SIXTEEN_SPID_ENABLED` | `false` | SPID/CIE restano spenti finché la validazione SAML non è completa. |
| `LOG_CHANNEL` | `stack` | Ora viene letta davvero (`config/logging.php`). |
| `LOG_STACK` | `daily`, oppure `daily,slack` o `daily,critical_mail` | Un file di log al giorno, più gli avvisi critici. Prima il default era `single`: i log ora sono in `storage/logs/laravel-AAAA-MM-GG.log`, non più in `laravel.log` (aggiornare chi fa `tail`). |
| `LOG_DAILY_DAYS` | `14` | Per quanti giorni si tengono i log. |
| `LOG_LEVEL` | `warning` | |
| `LOG_SLACK_WEBHOOK_URL` | URL del webhook | Serve solo se `slack` è in `LOG_STACK`. Se manca o non è un URL, il canale viene ignorato. |
| `LOG_CRITICAL_MAIL_TO` | indirizzi separati da virgola | Serve solo se `critical_mail` è in `LOG_STACK`. Usa `mail()` di PHP, quindi il server deve avere sendmail o postfix. |
| `QUEUE_CONNECTION` | `redis` | Le notifiche Fixcity passano dalla coda. |
| `SESSION_SECURE_COOKIE` | `true` | |

Controllo rapido dopo aver modificato il `.env`:

```bash
cd /var/www/fixcity/laravel
php artisan config:show app.debug          # false
php artisan config:show logging.default    # stack
php artisan config:show logging.channels.stack.channels
php artisan about --only=environment
```

### Error tracking

Oggi nessun servizio esterno (Sentry, Flare, Bugsnag) è tra le dipendenze. Restano due possibilità:

- usare gli avvisi critici via Slack o mail descritti sopra;
- installare `sentry/sentry-laravel`. Questo è un cambio di dipendenze e va approvato. Poi si aggiunge il canale `sentry` a `LOG_STACK` e si imposta `SENTRY_LARAVEL_DSN` nel `.env`.

## 2. Worker delle code (supervisor)

Senza worker le notifiche ai cittadini restano in coda.

Creare il file `/etc/supervisor/conf.d/fixcity-worker.conf`:

```ini
[program:fixcity-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/fixcity/laravel/artisan queue:work redis --queue=default,notifications --sleep=3 --tries=3 --backoff=30 --max-time=3600
directory=/var/www/fixcity/laravel
user=www-data
numprocs=2
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
stopwaitsecs=3600
redirect_stderr=true
stdout_logfile=/var/www/fixcity/laravel/storage/logs/worker.log
stdout_logfile_maxbytes=20MB
stdout_logfile_backups=5
```

Attivarlo e controllare che giri:

```bash
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl status 'fixcity-worker:*'
```

A ogni deploy `deploy.sh` esegue `php artisan queue:restart`. I worker finiscono il job in corso e ripartono con il codice nuovo.

## 3. Scheduler (cron)

Lo scheduler esegue la retention GDPR promessa nell'informativa: `activitylog:clean`, `model:prune` e `purge-deleted-accounts`. Si attiva con una riga nel crontab di `www-data` (`sudo crontab -u www-data -e`):

```cron
* * * * * cd /var/www/fixcity/laravel && php artisan schedule:run >> /dev/null 2>&1
```

Per controllare: `php artisan schedule:list` mostra i job e la prossima esecuzione.

## 4. Backup

### Database

`deploy.sh` fa un dump **prima di ogni deploy**:

- a sito in manutenzione e prima di toccare codice e dipendenze;
- di tutti i database MySQL/MariaDB configurati nell'app, senza duplicati;
- nella cartella `$DEPLOY_BACKUP_DIR` (default `~/fixcity-backups/db`), con file chiamati `<db>-<data UTC>-<commit>.sql.gz`;
- tenendo gli ultimi `DEPLOY_BACKUP_KEEP` dump (default 10).

Se il dump fallisce, il deploy si ferma e il sito torna online invariato. Serve `mariadb-dump` oppure `mysqldump` (`sudo apt install mariadb-client`).

Limite noto: una password del DB che contiene `"` non funziona nel file di opzioni temporaneo. In quel caso va cambiata.

Il backup del deploy non basta: serve anche un backup notturno, in un file come `/etc/cron.d/fixcity-backup`:

```cron
# Dump notturno dei due database. Credenziali in /root/.fixcity-backup.cnf (chmod 600, sezione [client]).
30 2 * * * root for db in fixcity_data fixcity_user; do mariadb-dump --defaults-extra-file=/root/.fixcity-backup.cnf --single-transaction --quick --triggers --hex-blob --no-tablespaces "$db" | gzip > /var/backups/fixcity/db/"$db"-$(date -u +\%Y\%m\%dT\%H\%MZ).sql.gz; done
# Media e upload dei cittadini (dischi public e local di Laravel).
45 2 * * * root rsync -a --delete /var/www/fixcity/laravel/storage/app/ /var/backups/fixcity/storage-app/
# Retention: 30 giorni.
15 3 * * * root find /var/backups/fixcity/db -name '*.sql.gz' -mtime +30 -delete
```

Il file `/root/.fixcity-backup.cnf` ha questa forma:

```ini
[client]
user="backup_user"
password="..."
host="127.0.0.1"
```

**La copia deve uscire dalla macchina.** Va sincronizzata almeno ogni notte su un altro server o su storage a oggetti, per esempio con `rclone sync /var/backups/fixcity remote:fixcity-backups`. Un backup che resta sullo stesso disco non protegge da un guasto del disco.

### Media

Le foto delle segnalazioni stanno sul disco `MEDIA_DISK` (default `public`, cioè `laravel/storage/app/public`). Le copre l'`rsync` di `storage/app` che si vede sopra. Se `MEDIA_DISK` punta a S3, i media si salvano con il versioning del bucket.

### Prova di restore (ogni trimestre, su staging)

1. Prendere l'ultimo dump notturno e la copia di `storage/app`.
2. Su staging:

   ```bash
   cd /var/www/fixcity/laravel
   php artisan down
   gunzip -c fixcity_data-<data>.sql.gz | mariadb --defaults-extra-file=/root/.fixcity-backup.cnf fixcity_data
   gunzip -c fixcity_user-<data>.sql.gz | mariadb --defaults-extra-file=/root/.fixcity-backup.cnf fixcity_user
   rsync -a /percorso/copia/storage-app/ storage/app/
   php artisan migrate:status | tail -5
   php artisan optimize:clear && php artisan up
   ```

3. Verificare:
   - login nel back office;
   - apertura di una segnalazione con foto;
   - `curl -fsS https://<staging>/up`.
4. Annotare data, dump usato ed esito nella story ops del modulo Xot. Il restore si considera riuscito solo se tutti e tre i controlli passano.

## 5. Deploy

Dalla radice del repository:

```bash
cd /var/www/fixcity
git pull                      # deploy.sh non fa il pull (righe commentate)
bash deploy.sh
```

Cosa fa `deploy.sh`, in ordine:

1. Crea o corregge i symlink degli asset di temi e moduli (una cartella vera al loro posto finisce in
   `$HOME/fixcity-backups/assets`) e si ferma se mancano i manifest di Sixteen o Geo. Niente build sul server: l'output
   delle build è versionato nei temi e nei moduli.
2. Mette il sito in manutenzione con `artisan down`.
3. Fa il **backup del DB**. Se fallisce rimette il sito online e si ferma.
4. Scarica composer e ne verifica la firma SHA-384.
5. Installa le dipendenze:
   - se `laravel/composer.lock` è versionato in git, o se `DEPLOY_TRUST_LOCK=1`: `composer install --no-dev --optimize-autoloader`;
   - altrimenti `composer update -W`, con un avviso ben visibile, perché le versioni installate non sono mai passate dalla CI.
6. Esegue `vendor:publish`, `migrate --force`, `filament:upgrade`, `optimize`, `queue:restart` e infine `artisan up`.

Lo script non elimina mai `database/migrations`: le migration sono parte del checkout
versionato e devono restare disponibili per `migrate`, audit e rollback forward-only.

Se uno step dopo il backup fallisce, il sito resta in manutenzione. Rimetterlo online con codice nuovo e schema vecchio farebbe più danni.

Controlli dopo il deploy:

```bash
curl -fsS https://<host>/up && echo OK
sudo supervisorctl status 'fixcity-worker:*'
tail -n 50 laravel/storage/logs/laravel-$(date +%F).log
```

Per chiudere anche il gate front office Sixteen, dalla checkout locale con Chromium
installato eseguire il controllo guest contro il dominio appena pubblicato:

```bash
cd laravel/Themes/Sixteen
FIXCITY_BASE_URL=https://fixcity.eu A11Y_STRICT=1 \
  npx playwright test tests/browser/a11y-axe.spec.mjs --reporter=list --workers=1
```

Il deploy non si considera verificato se una pagina guest fallisce per
`label-content-name-mismatch`, se il manifest non viene servito dalla document root o
se una pagina restituisce una schermata di eccezione. Le pagine protette vanno poi
verificate con uno storage state isolato, mai con cookie o credenziali inseriti nei
report.

Variabili del deploy: `DEPLOY_BACKUP_DIR`, `DEPLOY_BACKUP_KEEP`, `DEPLOY_SKIP_DB_BACKUP=1` (sconsigliata: stampa un avviso) e `DEPLOY_TRUST_LOCK=1`.

## 6. Rollback

La regola del repository è git forward-only: niente reset né force push. Un rollback si fa con un **nuovo commit** che annulla quello difettoso, seguito da un nuovo deploy.

**Caso A: codice rotto, schema DB compatibile.** È il caso più comune.

```bash
# sulla macchina di sviluppo, branch dev
git revert <sha-difettoso>
git push
# sul server
cd /var/www/fixcity && git pull && bash deploy.sh
```

**Caso B: una migrazione ha rovinato i dati.** Si ripristina il dump fatto da `deploy.sh` subito prima.

```bash
cd /var/www/fixcity/laravel
php artisan down
ls -t ~/fixcity-backups/db/ | head       # il dump con il commit precedente nel nome
gunzip -c ~/fixcity-backups/db/fixcity_data-<data>-<sha>.sql.gz | mariadb --defaults-extra-file=/root/.fixcity-backup.cnf fixcity_data
gunzip -c ~/fixcity-backups/db/fixcity_user-<data>-<sha>.sql.gz | mariadb --defaults-extra-file=/root/.fixcity-backup.cnf fixcity_user
```

Poi si porta il codice alla versione compatibile con quello schema, con un `git revert` e un nuovo deploy come nel caso A. Il backup del nuovo deploy fotografa lo stato ripristinato.

Prima di ripristinare, va valutato quali dati si perdono: tutto quello scritto dopo il dump. Il dump viene fatto a sito in manutenzione, quindi la perdita si limita a quello che è stato scritto dopo il ritorno online.

**Caso C: deploy fermo a metà, sito in manutenzione.** Si legge l'errore nell'output di `deploy.sh`, si corregge e si rilancia `bash deploy.sh`. Gli step sono ripetibili. Si usa `php artisan up` a mano solo dopo aver verificato che codice e schema sono coerenti (`php artisan migrate:status`).

## Note dalla revisione del 2026-11-10

- `FIXCITY_TICKET_MEDIA_DISK` si legge da `config/filesystems.php` (chiave `fixcity_ticket_media_disk`), che entra nella
  config cache. Vuoto = allegati nuovi sul disco di default (pubblico): da usare solo per emergenza.
- Dal 2026-11-11 `laravel/composer.lock` è versionato (OPS-07), quindi `deploy.sh` esegue `composer install --no-dev`: niente
  debugbar, boost, ide-helper, faker in produzione. Verificato che il codice di runtime non li usa (Boost/Mcp registrati solo
  se la classe esiste; Faker solo in `GenerateTicketsAction`, usata da seeder e test). **Primo deploy con il lock: provarlo
  su staging.** Per aggiornare le dipendenze: `composer update` in sviluppo, test, commit del lock.
