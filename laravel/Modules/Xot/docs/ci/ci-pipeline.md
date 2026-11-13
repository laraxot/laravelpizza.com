---
title: "Pipeline CI (GitHub Actions)"
type: reference
created: 2026-11-10
updated: 2026-11-10
related:
  - ../stories/ci-deploy-ops-hardening.story.md
  - ../ops/production-runbook.md
---

# Pipeline CI

La CI è definita in un solo workflow, `.github/workflows/ci.yml`. Il setup comune a tutti i job sta nella composite action `.github/actions/setup-laravel`.

## Come vengono installate le dipendenze

- Si usa PHP 8.4, perché `laravel/composer.json` richiede `^8.4`.
- `wikimedia/composer-merge-plugin` viene installato **globalmente** (`composer global require`), come sulle macchine di sviluppo e sul server. Il plugin non è nel `require` di nessun `composer.json` e la CI non cambia le dipendenze.
- Il plugin unisce i `Modules/*/composer.json`. Se dopo l'install manca `vendor/filament`, il job fallisce.
- Se `laravel/composer.lock` esiste si usa `composer install`, altrimenti `composer update`, con un warning. Oggi il lock è in `.gitignore`.
- `.env` è una copia di `.env.example`. `APP_KEY` viene generata per ogni run. Poi `composer dump-autoload` esegue package discovery e gli script.

## Job

Nessun job usa `|| true` o `continue-on-error`. Se un controllo fallisce, il job è rosso.

| Job | Richiesto | Cosa controlla |
|---|---|---|
| PHPStan (Fixcity, User, Geo) | sì | `phpstan analyse Modules/Fixcity Modules/User Modules/Geo` con `laravel/phpstan.neon`, senza `--level` |
| Pest (Fixcity) / (Geo) / (User) | sì | testsuite di modulo (QA-01), sullo SQLite costruito da `xot:build-test-sqlite` |
| Pint (file cambiati) | sì, solo PR | `pint --test --diff=origin/<base>` |
| Build asset Geo | sì | stessa build di `deploy.sh` e presenza di `public_html/assets/geo/manifest.json` |
| — | — | Niente suite Unit/Feature della radice dal 2026-11-11: i loro test sono stati spostati nei moduli (Fixcity, Blog) e nel tema Sixteen; copie doppie e test di funzioni rimosse (Breeze, Chart, GeocodeTicketAddressJob) eliminati. Togliere `Pest (Unit)` e `Pest (Feature)` dai required della branch protection |
| PHPStan tutti i moduli (informativo) | no | `phpstan analyse Modules`: debito noto negli altri moduli |
| Pest modulo X (informativo) | no | `pest Modules/<X>/tests`, per ogni altro modulo e per il tema Sixteen |
| Build tema Sixteen (informativo) | no | `npm install` del tema dipende da un tarball GitHub non fissato (`mauve`, OPS-08) |

I job informativi possono essere rossi, ma non bloccano. Quando uno diventa stabilmente verde, il modulo va spostato tra i richiesti: si aggiunge una testsuite in `phpunit.xml` e la si mette nella matrice `tests`.

## Branch protection (da fare a mano su GitHub)

In Settings → Branches, per `dev` e `main`, vanno marcati come required i job della tabella con "sì". I nomi da selezionare sono quelli mostrati nella colonna Job, per esempio `Pest (Fixcity)`.

## Eseguire gli stessi controlli in locale

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Fixcity Modules/User Modules/Geo
php artisan xot:build-test-sqlite --fresh
./vendor/bin/pest --testsuite=Fixcity
./vendor/bin/pest Themes/Sixteen/tests   # i test vivono solo in Modules/<M>/tests e Themes/<T>/tests
```

## Workflow rimossi il 2026-11-10

Fallivano a ogni push da giorni e non controllavano nulla che `ci.yml` non controlli già:

| Workflow | Perché fallivano |
| --- | --- |
| `psalm.yml`, `phpinsights.yml`, `rector.yaml` | Dipendenze installate dal `composer.json` della radice, che non si risolve; PHP 8.1. `rector` inoltre committava da solo su ogni push |
| `semantic-release-advanced.yml` | `npm ci` senza `package-lock.json` (escluso da `.gitignore`) |
| `stargazer-welcome.yml`, `virality-and-monetization.yml`, `social-monetization.yml` | Copiati dal modello del modulo Notify, falliti in 0 secondi; non pertinenti a un servizio per i Comuni |

Tolti anche i file `*.old` e `*_test`, che GitHub non esegue. PHPStan (configurazione unica `laravel/phpstan.neon`) resta
l'unico analizzatore statico; se si vuole Rector, va eseguito in locale e il risultato rivisto in una PR, mai con commit
automatici su `dev`.
