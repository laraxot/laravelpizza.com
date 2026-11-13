---
title: "CI, deploy e operazioni pronte per la produzione"
type: story
bmad: true
status: review
created: 2026-11-10
updated: 2026-11-10
owner: Modules/Xot (CI, deploy, ops); file toccati anche in app root, Themes/Sixteen, tests/
related:
  - ../../../Fixcity/docs/audit/QUALITY_CI_OPS_AUDIT.md
  - ../../../Fixcity/docs/stories/production-hardening-p0.story.md
  - ../ops/production-runbook.md
  - ../ci/ci-pipeline.md
---

# CI, deploy e operazioni pronte per la produzione

Finding chiusi o ridotti: QA-01, OPS-01, OPS-02, OPS-03, OPS-08 (solo analisi), OPS-10, OPS-11 e OPS-13 (documentazione), OPS-12.

## Problema

- **CI.** Nessun gate poteva fallire, per via dei `|| true`. Le dipendenze dei moduli non venivano installate, perché il merge-plugin non c'era. `tests.yml` era rotto: PHP 8.3, `key:generate` prima di composer, Postgres. C'erano sei workflow duplicati, alcuni con PHP 8.2 e `upload-artifact@v3`.
- **Test dei moduli.** Erano fuori da ogni testsuite. La funzione `runTicketSeeder()` era dichiarata due volte e i `Pest.php` dei moduli non venivano caricati.
- **deploy.sh.** Eseguiva `composer update -W` in produzione, non faceva backup prima di `migrate --force`, non verificava la firma dell'installer di composer e non riavviava i worker.
- **Log.** `LOG_CHANNEL` era ignorata, perché `logging.default` si autoreferenziava. Lo stack scriveva su `single`, cioè un unico file senza rotazione.
- **CIE.** `Themes/Sixteen/config/cie.php` chiamava `route()` come default di `env()`. Se il provider del tema venisse registrato, il boot fallirebbe.
- **Operazioni.** Non c'era una procedura documentata per worker, cron, backup, restore e rollback.

## Modifiche

| Area | File | Cosa cambia |
|---|---|---|
| CI | `.github/workflows/ci.yml` | Riscritto. Job richiesti: PHPStan su Fixcity/User/Geo, Pest per le suite Unit/Feature/Fixcity/Geo/User, Pint sui file della PR, build Geo. Job informativi, che possono essere rossi: PHPStan su tutti i moduli, Pest per ogni altro modulo, build del tema Sixteen. Nessun `\|\| true` |
| CI | `.github/actions/setup-laravel/action.yml` | Nuovo. PHP 8.4, merge-plugin installato globalmente, `install` se c'è il lock e altrimenti `update` con warning, controllo che `vendor/filament` esista, `.env` e `APP_KEY` effimeri, package discovery |
| CI | `.github/workflows/{tests,comprehensive-quality,ci-cd,phpstan,pint,quality}.yml` | Rimossi, vedi il dettaglio sotto |
| QA-01 | `laravel/tests/Unit/Modules/Fixcity/Seeders/TicketDatabaseSeederTest.php` | Rimosso. Era una copia vecchia (15 ticket, contro i 20 del contratto attuale) di quella del modulo, e dichiarava di nuovo `runTicketSeeder()` |
| QA-01 | `laravel/phpunit.xml` | Nuove testsuite `Fixcity`, `Geo` e `User`, ciascuna con le cartelle Unit e Feature del modulo |
| QA-01 | `laravel/tests/Pest.php` | `require_once` di `Modules/Geo/tests/Pest.php`, che contiene gli helper `geo_mockery_expect()`, `createRegion()` e `createComune()` |
| OPS-10 | `deploy.sh` | Backup del DB a sito fermo e prima di toccare il codice: se fallisce, il sito torna online e il deploy si ferma. Firma SHA-384 dell'installer di composer. `install --no-dev --optimize-autoloader` se il lock è versionato, altrimenti `update -W` con avviso. Aggiunto `queue:restart`. Restano intatti build Geo, `down`, `trap` e `up` finale |
| OPS-12 | `laravel/config/logging.php` | `default` letto da `LOG_CHANNEL`. `LOG_STACK` di default `daily`, per 14 giorni. Nuovo canale `critical_mail`. Slack con un livello proprio (`LOG_SLACK_LEVEL`). Un canale di avviso elencato ma non configurato viene scartato |
| OPS-12 | `laravel/.env.production.example` | Aggiunte `LOG_STACK`, `LOG_DAILY_DAYS`, le variabili degli avvisi, `SHOWCASE_PAGES=false` e `SIXTEEN_SPID_ENABLED=false` |
| CIE | `Themes/Sixteen/config/cie.php`, `Themes/Sixteen/app/Actions/CieAuthAction.php` | `redirect_uris.*` vale null se l'env non è impostata. `CieAuthAction` usa il valore di config se presente, altrimenti `route()` a runtime. Prima `CIE_REDIRECT_URI` era ignorata |
| Docs | `docs/ops/production-runbook.md`, `docs/ci/ci-pipeline.md` | Runbook: env, supervisor, cron, backup e restore, deploy, rollback. Pipeline: job richiesti e informativi |

### QA-01: ragionamento file per file

- `Pest\Bootstrappers\BootFiles` carica `Pest.php` da un solo percorso, `tests/` della root. Vale sia quando si passa un percorso, sia quando si passa una testsuite. Quindi aggiungere una testsuite non cambia il binding dei TestCase rispetto a `vendor/bin/pest Modules/<M>/tests`, che è quello che si esegue oggi.
- Il fatal "Cannot redeclare" nasceva da un solo caso: `runTicketSeeder()`. Una scansione di `tests/`, `Modules/{Fixcity,Geo,User}/tests` non trova altre funzioni o classi duplicate. In `User/tests/Support/helpers-core.php` e `helpers-extended.php` ci sono duplicati di `helpers.php`, ma nessuno li carica.
- I file Pest senza `uses()` sono 4 in Fixcity e 18 in Geo. Girano su `PHPUnit\Framework\TestCase`, come oggi. In User sono 0.
- `Fixcity/tests/Pest.php` è vuoto e `User/tests/Pest.php` contiene solo commenti. Si carica solo quello di Geo, che non usa `uses()->in()` e non può quindi collidere.
- I circa 240 file senza `uses()` del tentativo precedente sono negli altri moduli, che restano fuori dalle suite e sono coperti dai job informativi.
- In CI ogni suite gira in un processo separato. Il TestCase root lavora su MariaDB con `DatabaseTransactions`, quelli di modulo sullo SQLite condiviso: non vanno mescolati nello stesso run. Un `vendor/bin/pest` senza argomenti li esegue tutti insieme. In locale funziona, ma se compaiono interferenze va usato `--testsuite`.

### Workflow rimossi

| Workflow | Motivo |
|---|---|
| `tests.yml` | Rotto per costruzione (OPS-03) e sostituito da `ci.yml` |
| `comprehensive-quality.yml` | Duplicava `ci.yml`, con tutti i gate a `\|\| true` |
| `ci-cd.yml` | PHP 8.2 e Laravel 12, `upload-artifact@v3` che non funziona più, branch `develop` che non esiste, schedule notturno |
| `phpstan.yml`, `pint.yml` | PHP 8.3, composer install sul `composer.json` della radice (non risolvibile), `Modules/$mod` non definito |
| `quality.yml` | Solo Activity, solo su `develop` e `main`, `\|\| true`. Coperto dai job informativi |

## Verifica

- `python3` con il modulo `yaml`: `ci.yml` e `action.yml` validi.
- `bash -n deploy.sh`: ok. Il PHP dentro `deploy.sh` passa `php -l` ed è stato provato con una config finta: deduplica le connessioni, scarta quelle sqlite, raddoppia i backslash nella password.
- `php -l` su `config/logging.php`, `tests/Pest.php`, `Themes/Sixteen/config/cie.php` e `CieAuthAction.php`: ok.
- `config/logging.php` provato con un `env()` finto:
  - senza variabili, il default è `stack` e lo stack è `[daily]`;
  - `LOG_CHANNEL=daily` viene rispettata;
  - `slack` con l'URL `REDACTED_SLACK_WEBHOOK_URL` di `.env.testing` viene scartato;
  - `critical_mail` è attivo solo con `LOG_CRITICAL_MAIL_TO`.
- `phpunit.xml`: XML valido.
- `npm install` e `vite build` di Geo: ok, il manifest è presente.
- **Non eseguiti qui**, perché il sandbox ha PHP 8.3 e non ha `vendor/`: PHPStan, Pest e `composer update`. Il primo run della CI su GitHub è la verifica reale.

## Aperto

- **OPS-01.** `laravel/composer.lock` è in `.gitignore`, quindi la CI e il deploy risolvono versioni non riproducibili. Per versionarlo serve una decisione: eccezione `!laravel/composer.lock` in `.gitignore` e un commit del lock generato in locale. Va decisa anche l'aggiunta di `wikimedia/composer-merge-plugin` al `require`, che è un cambio di dipendenze e richiede approvazione.
- **Branch protection.** Va marcato a mano su GitHub quali job sono richiesti (elenco in `docs/ci/ci-pipeline.md`).
- **Primo run della CI.**
  - Se le suite richieste sono rosse per debito, va corretto il codice o il test. Non si toglie il gate.
  - Va verificato che `.env.testing`, con il DB sovrascritto dalle variabili del job, faccia partire la suite Feature.
- **OPS-08.** Nessun bump in `package.json`: ogni correzione richiede un salto di major, e lo stesso vale per le versioni 0.x. Numeri dell'audit di oggi, su un lock nuovo:
  - `laravel/`: 28 vulnerabilità, 16 alte;
  - radice: 37 vulnerabilità, 24 alte.

  Dipendenze dirette da aggiornare con un major:
  - in `laravel/`: `puppeteer` (25.16) e `markdownlint-cli` (0.50);
  - alla radice: `glob` (14), `minimatch` (11), `sharp` (0.35.5), `puppeteer-core`, `@typescript-eslint/*`, `htmlhint`, `@kilocode/plugin`, `@opencode-ai/plugin`.

  Sono tutti tool di sviluppo. Nessuno è nel bundle Geo, che dipende da `leaflet`, `lit` e `vite`.
- **OPS-04 e OPS-05.** Restano `psalm.yml`, `rector.yaml` e `phpinsights.yml`, che fanno auto-commit, e gli altri workflow di rilascio e marketing. Restano anche `dependabot-auto-merge.yml` (OPS-06) e `module-quality-check.yml`, che filtra su un path sbagliato.
- **deploy.sh.** Restano `vendor:publish --all` e `rm -rf database/migrations/*`, che sono il flusso `composer go` del progetto. Resta anche `chown -R` su tutto il repository. Non c'è ancora un rilascio atomico (`releases/<sha>` più symlink) né un rollback automatico su `/up`.
- **OPS-11.** `DatabaseBackUpCommand` di Xot ha ancora i difetti dell'audit. Il backup notturno è documentato nel runbook, ma il cron va installato sul server.
- **OPS-13.** I check di `spatie/laravel-health` non sono registrati in un provider e `health:check` non è schedulato.
- **Config.** `config/media-library.php` ha lo stesso schema autoreferenziale di `logging.php` (`config('media-library.disk_name', ...)`). Oggi lo maschera `config/local/fixcity/media-library.php`.
