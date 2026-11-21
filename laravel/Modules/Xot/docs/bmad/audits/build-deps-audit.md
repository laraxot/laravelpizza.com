---
title: "Audit build, dipendenze e configurazione — Laraxot PTVX"
type: audit
status: review
updated: 2026-11-16
module: Xot
qmd: "audit composer autoload config env vite tailwind phpstan pint phpmd phpinsights pest phpunit github workflows deploy public_html symlink"
---

# Audit build, dipendenze e configurazione — Laraxot PTVX

Audit **statico e read-only** di build/dependency/config/CI. Scope: `laravel/composer.json`, `/composer.json`, `laravel/Modules/*/composer.json`, `laravel/Themes/*`, `laravel/tools`, `config/**`, `vite.config.js`, `package.json`, `webpack.mix.js`, `phpstan.neon`, `pint.json`, `phpinsights.php`, `phpmd*.xml`, `phpunit*.xml`, `.github/workflows`, `deploy.sh`, `bashscripts/lock`.

**Nessun file applicativo/config è stato modificato**: unico artefatto scritto è questo report. Non sono stati eseguiti `composer install/update`, `npm install/build`, PHPStan, Pest o deploy; dove serve evidenza runtime il finding è marcato **da verificare**.

## Modello di severità

| Sigla | Significato |
|---|---|
| C | Critico: blocca o invalida build/deploy/asset in produzione |
| A | Alto: incoerenza che rompe test/CI/tooling o rende le dipendenze non riproducibili |
| M | Medio: drift, duplicazione, vincoli larghi, configurazioni stale |
| B | Basso: igiene, documentazione, metadati Composer non standard |

## Esito sintetico

| Area | Esito | Finding principali |
|---|---|---|
| Composer/dipendenze | JSON valido; canonicalità e vincoli incoerenti | `/composer.json` overlay senza lock; `minimum-stability: dev`; `*` diffusi; path repositories ambigui; chiavi Composer non standard |
| Autoload PSR-4 | Convenzione `Modules\<M>\` → `app/` corretta; eccezioni mirate | `Sigma` espone `Tests` in autoload di produzione; `Xot` ha `files`/`classmap`/namespace extra da verificare |
| Config/`env()` | Nessun `env()` eseguibile in `app/` o `Modules/*/app`; config tenant versionata di proposito | `config/local` e `config/localhost` duplicano molte connessioni; `env()` in config tenant viene congelato da `config:cache` |
| Frontend/build | Root Vite corretto su `public_html`; moduli/temi incoerenti | Molti `vite.config.js` puntano a `laravel/public` invece di `public_html`; collisioni su `build-user`; input mancanti; Mix/Vite mescolati; symlink tema materializzati come file |
| Quality tooling | Root ha PHPStan/Pint/Insights/PHPMD/PHPUnit; moduli ereditano script senza `require-dev` | `phpstan.neon` ha estensioni commentate; script modulo chiamano binari non dichiarati; PHPUnit root scopre solo Unit/Feature |
| CI/deploy | Un solo workflow attivo utile; deploy robusto ma non builda frontend | `deploy.sh` non esegue `npm build`; `public_html/themes/{One,Zero}` non sono symlink su questo filesystem → deploy si ferma |

## Finding

### 1. Composer e dipendenze

- **F-01 — `/composer.json` è un overlay non canonico** — `M`
  - Percorso: `/composer.json:1-22`
  - Evidenza: esiste un secondo Composer root senza `composer.lock` e senza `vendor/`; duplica `laravel/framework`, `phpstan/phpstan`, `predis/predis` e aggiunge pin diversi (`phpstan/phpstan ^2.1`, `predis/predis ^3.5`) rispetto a `laravel/composer.json` (`*`/`^13.0`). `composer validate` qui passa ma segnala assenza di license.
  - Impatto: rischio di install parallela/errata o di vincoli divergenti se qualcuno esegue Composer dalla root; `deploy.sh` usa correttamente `laravel/`.
  - Rimedio: decidere se il file è solo per tooling/IDE; in tal caso documentarlo ed escluderlo da deploy/CI, oppure renderlo canonico con lock. Non eseguire `composer install` dalla root.

- **F-02 — `minimum-stability: dev` + vincoli `*` nel progetto Laravel** — `A`
  - Percorso: `laravel/composer.json:13,16,18,109-113`
  - Evidenza: `larastan/larastan: *`, `predis/predis: *`, `sentry/sentry-laravel: *`, `phpstan/phpstan: *` in require-dev; `minimum-stability: dev`, `prefer-stable: true`.
  - Impatto: `composer update` può introdurre major/dev non previsti; `composer validate` segnala i tre `*` di produzione.
  - Rimedio: fissare range major (`^3`, `^3.5`, `^4`, ecc.) e ridurre `*`; mantenere `prefer-stable` ma con stability esplicita.

- **F-03 — Drift dei vincoli tra root e moduli** — `M`
  - Percorsi: `laravel/Modules/Xot/composer.json:27` (`filament/filament ^5.11.2` vs `^5.0` altrove), `laravel/Modules/User/composer.json:52` (`jenssegers/agent: *` vs root overlay `^2.0`), `laravel/Modules/IndennitaCondizioniLavoro/composer.json:24` (`cknow/laravel-money ^8.1`) vs `laravel/Modules/Rating/composer.json:44` (`^8.0`), `spatie/laravel-queueable-action: *` in `Xot:48`/`Notify:61` vs root overlay `^2.17`.
  - Impatto: lo stesso pacchetto può risolvere versioni diverse per modulo in install standalone o in merge ambiguo.
  - Rimedio: centralizzare i vincoli nel Composer root o allineare i moduli allo stesso range; evitare `*` per pacchetti condivisi.

- **F-04 — Dipendenze modulo quasi tutte `*`** — `M`
  - Percorsi: `laravel/Modules/Xot/composer.json:21-58`, `laravel/Modules/Notify/composer.json:47-66`, `laravel/Modules/Activity/composer.json:44-48`, `laravel/Modules/Sigma/composer.json:23-26`.
  - Impatto: con merge plugin e `minimum-stability: dev`, i moduli non esprimono compatibilità reale; il lock mitiga ma non documenta i vincoli.
  - Rimedio: sostituire `*` con range major compatibili e validati.

- **F-05 — `repositories` path stale/ambigui nei moduli** — `M` (**da verificare**)
  - Percorsi: `laravel/Modules/Notify/composer.json:68-81`, `laravel/Modules/Xot/composer.json:92-107`, `laravel/Modules/Lang/composer.json:38-75`, `laravel/Modules/Activity/composer.json:50-63`.
  - Evidenza: molti moduli dichiarano path repo `../Xot`, `../Tenant`, `../UI` pur con commenti che dicono che i path package sono stati spostati al root; alcuni sono sotto chiavi non standard (`repositories_comment`, `repositories-comment`) e quindi ignorate da Composer.
  - Impatto: se merge-plugin propaga `repositories`, URL relativi come `./packages/coolsam/panel-modules` o `../Xot` possono risolversi rispetto a `laravel/` invece che al modulo.
  - Verifica eseguita: `composer show coolsam/panel-modules` risolve `Modules/Xot/./packages/coolsam/panel-modules`, quindi oggi funziona; resta fragile.
  - Rimedio: rimuovere path repo non necessari dai moduli o centralizzarli nel Composer root con path assoluti/relativi corretti; eliminare le varianti `*_comment`.

- **F-06 — Chiavi Composer non standard** — `B`
  - Percorsi: `laravel/Modules/Notify/composer.json:83` (`post-autoload-dump1`), `laravel/Modules/Xot/composer.json:60,92,154`, `laravel/Modules/Activity/composer.json:50`, `laravel/Modules/Lang/composer.json:16,28,37,53,65`.
  - Impatto: JSON valido ma Composer ignora `post-autoload-dump1`, `repositories_comment`, `require_comment`, `require-comment`; l’eventuale `testbench package:discover` in `post-autoload-dump1` **non viene eseguito**.
  - Rimedio: rimuovere le chiavi finte o sostituirle con script Composer corretti; spostare le note in commenti/docs.

- **F-07 — Metadati Composer warning** — `B`
  - Percorsi: `laravel/Modules/Incentivi/composer.json`, `laravel/Modules/Pdnd/composer.json` (no license), `laravel/Modules/Lang/composer.json:16-20` (description/license/homepage duplicati), `laravel/tools/phpinsights/composer.json` (no license).
  - Rimedio: normalizzare license/description; rimuovere duplicati in `Lang`.

- **F-08 — Pacchetti abandoned/deprecated** — `M` (**da verificare**)
  - Candidati da controllare con `composer show -a`/audit dedicato: `tightenco/parental` (`Xot:58`), `laravel/folio` (`Xot:30`), `livewire/flux` (`Xot:35`), `lara-zeus/spatie-translatable` (`Lang:31`), `railsware/mailtrap-php` (`laravel/composer.json:17`, `Notify:58`), `jenssegers/agent` (`User:52`), `coolsam/panel-modules` path locale.
  - Rimedio: eseguire `composer audit` e verifica lifecycle dei pacchetti prima di upgrade.

### 2. Autoload PSR-4, classmap e files

- **F-09 — Convenzione PSR-4 corretta con eccezioni** — `M`
  - Percorso: `laravel/Modules/*/composer.json` (es. `Notify:35-46`, `Activity:32-43`, `Sigma:42-49`).
  - Evidenza: la maggior parte mappa `Modules\<M>\` → `app/`, `Database\Factories` → `database/factories/`, `Database\Seeders` → `database/seeders/`, `Tests` → `tests/` in `autoload-dev`.
  - Eccezioni: `Xot` aggiunge `Coolsam\FilamentModules\` → `packages/coolsam/panel-modules/src/` e `files: helpers/Helper.php` (`Xot:108-127`); `coolsam/panel-modules/composer.json:24-28` mappa lo stesso namespace → potenziale doppio autoload da verificare.
  - Rimedio: verificare `composer dump-autoload -o` e collisioni PSR-4; decidere se `Coolsam` deve venire dal path package o dall’autoload di Xot.

- **F-10 — `Modules\Sigma\Tests\` in autoload di produzione** — `M`
  - Percorso: `laravel/Modules/Sigma/composer.json:47` e `:76-79`.
  - Impatto: namespace di test caricato in produzione; duplicato tra `autoload.psr-4` e `autoload-dev.psr-4`.
  - Rimedio: rimuovere `Modules\Sigma\Tests\` da `autoload.psr-4`.

- **F-11 — `classmap`/`files` da verificare** — `B`
  - Percorso: `laravel/Modules/Xot/composer.json:115-126`.
  - Evidenza: `files` carica `helpers/Helper.php` in produzione e `tests/Support/helpers.php` in dev; `autoload-dev.classmap: ["tests/"]` coesiste con PSR-4 `Modules\Xot\Tests\`.
  - Impatto: helper sempre caricati e possibile doppia registrazione classi di test in run dev.
  - Rimedio: verificare con `composer dump-autoload --dry-run`/`--optimize` che non ci siano classi duplicate; limitare `files` a helper realmente necessari.

- **F-12 — Script Composer modulo chiamano tool non dichiarati** — `M` (**da verificare**)
  - Percorsi: `laravel/Modules/Activity/composer.json:49,69-83` (`require-dev: {}` ma script `phpstan`, `pest`, `php-cs-fixer`, `pint`, `testbench`), `Notify:82-92`, `Job:54-58`, `Media:69-73`, `User:77-86`, `Rating:69-72`, `Lang:91-94`, `Sigma:53-56`, `Progressioni:52-55`, `Performance:51-54`, `Tenant:67-70`, `Ptv:65-68`, `Indennita*:51-56`.
  - Impatto: in install standalone o workbench i binari mancano; nel monorepo dipende dal merge plugin e dal cwd.
  - Rimedio: o dichiarare `require-dev`/testbench nei moduli, o documentare che gli script sono solo per repo modulo separati e non per `Modules/*` nel monorepo.

### 3. Configurazione Laravel, `env()` e tenant

- **F-13 — `env()` fuori config: nessuna violazione attiva trovata** — `B` (OK)
  - Percorso: `laravel/app`, `laravel/Modules/*/app`.
  - Evidenza: grep `\benv\(` trova solo commenti/docblock (`Xot/app/Providers/XotServiceProvider.php:327`, `User/app/Models/SocialProvider.php:74-75`, `Media/app/Datas/CloudFrontData.php:19-27`) o `Process::env()` (`Xot/app/Actions/ExecuteComposerDumpAutoloadAction.php:38-54`). `laravel/app` non ha match.
  - Nota: `Modules/Media/docs/**` contiene esempi storici con `env()`; non sono codice attivo.
  - Rimedio: nessuno per codice attivo; eventualmente ripulire doc storiche se generano falsi positivi.

- **F-14 — Config tenant versionata ma con duplicazione estesa** — `M`
  - Percorsi: `laravel/config/localhost/**`, `laravel/config/local/ptvx/**`, `laravel/config/local/ptvx-mono/**`, `laravel/config/local/tv/prov/personale2019/**`, `laravel/config/local/tv/prov/personale2022/**`; caricamento ricorsivo Laravel e merge runtime in `laravel/Modules/Tenant/app/Providers/TenantServiceProvider.php:38-78,154-167,188-203` e `ResolveTenantConfigValueAction.php:31-56`.
  - Evidenza: `config/localhost/database.php` ha 99 occorrenze `env()`, `config/database.php` 85; file come `app.php`, `auth.php`, `database.php`, `filesystems.php`, `metatag.php`, `services.php` si ripetono tra tenant.
  - Impatto: drift tra tenant e default; ogni file duplicato va mantenuto a mano.
  - Rimedio: definire una matrice tenant→override e ridurre i file tenant a sole chiavi effettivamente diverse; documentare che `config/local` è intenzionalmente versionato (vedi `.gitignore:233-235`).

- **F-15 — `env()` dentro config tenant congelato da `config:cache`** — `M`
  - Percorsi: `laravel/config/local/**/database.php`, `laravel/config/localhost/database.php`, `laravel/config/local/**/filesystems.php`.
  - Impatto: i valori `env()` dei file tenant vengono valutati al momento della cache; se `.env` o i file tenant cambiano serve `config:clear`/`config:cache` (deploy lo fa in `deploy.sh:90-94`).
  - Rimedio: evitare segreti/varianti tenant in `env()` dentro config versionate; preferire valori espliciti o riferimenti a config root.

### 4. Frontend, Vite, Mix, Tailwind e temi

- **F-16 — Molti `vite.config.js` puntano a `laravel/public`, non a `public_html`** — `C`
  - Percorsi: `laravel/Modules/{Job,User,Rating,Sigma,Performance,Progressioni,Tenant,Lang,IndennitaCondizioniLavoro,IndennitaResponsabilita,Media,Activity,UI,Pdnd}/vite.config.js` con `publicDirectory: '../../public'` e/o `outDir: '../../public/build-*'`; `laravel/app/Application.php:16-38` imposta `publicPath()` su `public_html`; `laravel/vite.config.js:6-13` usa correttamente `../public_html/build`.
  - Evidenza: `laravel/public` contiene solo `index.php`; `public_html` è la document root reale.
  - Impatto: se questi build sono usati, manifest/asset finiscono in una directory non servita o non prevista.
  - Rimedio: allineare i moduli a `public_html`/`public_path()` o rimuovere config/build non più usati; centralizzare gli asset modulo nel build root.

- **F-17 — Collisioni su `build-user` con `emptyOutDir`** — `C` se usati / `M` se dead code
  - Percorsi: `Job:10`, `User:10`, `Rating:9`, `Sigma:9`, `Performance:9`, `Progressioni:9`, `Tenant:10`, `Lang:9`, `IndennitaCondizioniLavoro:9`, `IndennitaResponsabilita:9` (`vite.config.js`).
  - Impatto: ogni build svuota `build-user` e sovrascrive il manifest degli altri moduli.
  - Rimedio: outDir univoco per modulo (`public_html/build/<module>`) oppure un solo build root.

- **F-18 — Input Vite mancanti o path case-sensitive errati** — `C`
  - Percorsi: `Modules/User/vite.config.js:19-21` e `Modules/Tenant/vite.config.js:19-21` richiedono `resources/assets/sass/app.scss` + `resources/assets/js/app.js`, ma `User/resources` ha `css/app.css`/`js/app.js` e `Tenant/resources` non ha `assets`; `Modules/Lang/vite.config.js:17-19` stessa cosa mentre `Lang/resources` ha `css/app.css`/`js/app.js`; `Modules/Ptv/vite.config.js:35-36` usa `/Resources/css|js` maiuscolo mentre i file reali sono `resources/css/app.css` e `resources/js/app.js` (case-sensitive).
  - Rimedio: correggere i path o eliminare i config obsoleti; verificare `npm run build` per modulo prima di dichiararlo funzionante.

- **F-19 — Mix e Vite mescolati; `webpack.mix.js` assenti dove servirebbe** — `A`
  - Percorsi: package con script Mix: `Notify/package.json:4-10`, `Tenant:4-9`, `Rating:4-8`, `Lang:4-8`, `Xot:4-8`, `Performance/Progressioni/Sigma:4-10`, `IndennitaCondizioniLavoro/IndennitaResponsabilita:4-10`; `webpack.mix.js` esiste solo in `Job`, `Ptv`, `Rating`, `UI` (e una copia doc in `Job/docs/root-code-workspace-files`).
  - Evidenza: `Rating/package.json:18,22-24` ha `laravel-vite-plugin`, `tailwindcss ^4.3.2`, `vite ^8.3.4` insieme a script `mix`; `Performance/Progressioni/Sigma` usano `laravel-mix ^4` + `cross-env ^5.1.4`; `Indennita*` usano `laravel-mix ^5`.
  - Impatto: script `npm run development/production` falliscono dove manca `webpack.mix.js` o dove le dipendenze non includono webpack/laravel-mix coerenti.
  - Rimedio: scegliere uno stack per modulo (Vite raccomandato), rimuovere script Mix morti e allineare Tailwind/Vite.

- **F-20 — Symlink tema materializzati come file normali (NAS)** — `C`
  - Percorsi: `public_html/themes/One`, `public_html/themes/Zero`; `deploy.sh:59-70`; `.gitignore:241-246`; `laravel/Modules/Xot/app/Console/Commands/ThemeLinkCommand.php:76-128`.
  - Evidenza: `git ls-files -s` mostra mode `120000` (symlink), ma `ls -l` mostra file regolari il cui contenuto è il target (`../../laravel/Themes/One/public`). `deploy.sh` vede `-e` e `! -L` → `exit 1`.
  - Impatto: deploy si interrompe alla fase symlink tema su questo filesystem.
  - Rimedio: garantire filesystem con supporto symlink reale oppure rendere `deploy.sh`/`xot:theme-link` tolleranti a file-puntatore; non committare copie.

- **F-21 — Temi: One senza build config, Zero con public quasi vuoto** — `M`
  - Percorsi: `laravel/Themes/One/composer.json:1-21` (solo PHP), `laravel/Themes/One/resources/css/dfa-*.css`/`xotcov-*.css` (artefatti generati in resources), `laravel/Themes/One/public/{assets,manifest.json}`; `laravel/Themes/Zero/vite.config.js:18-28` output `./public`, ma `laravel/Themes/Zero/public` contiene solo `manifest.json`.
  - Evidenza: `Modules/User/resources/views/package.json:1-10` si presenta come `laraxot/theme-one` con build Vite output `resources/dist` (`vite.config.js:4-10`), separato da `Themes/One`.
  - Impatto: tema One/Zero non hanno una pipeline riproducibile chiara; Zero sembra non aver asset compilati.
  - Rimedio: definire un solo tema buildabile (o segnare i temi come statici) e allineare `public/` a ciò che il deploy symlinka.

- **F-22 — Lock npm solo root; moduli/temi senza lock** — `M`
  - Percorso: `laravel/package-lock.json` esiste; nessun `package-lock.json` sotto `Modules/*` o `Themes/*`.
  - Impatto: `npm install` nei moduli non è riproducibile; versioni Vite/Tailwind/Mix divergono (`vite ^5/6/8`, `tailwindcss ^3/4`, `laravel-mix ^4/5/6`).
  - Rimedio: se i moduli non sono più buildati singolarmente, rimuovere i loro `package.json` o renderli documentazione; altrimenti aggiungere lock e CI npm.

- **F-23 — `laravel/package.json` ha dipendenze AI in `dependencies`** — `B`
  - Percorso: `laravel/package.json:22-27` (`@dietrichgebert/ponytail`, `@kilocode/plugin`, `@opencode-ai/plugin`, `@tailwindcss/vite`).
  - Impatto: se `npm ci --omit=dev` viene usato in produzione, i plugin AI entrano nel bundle install; `@tailwindcss/vite` è in dependencies mentre Tailwind è in devDependencies.
  - Rimedio: spostare tool AI in devDependencies o in un package separato; decidere se `@tailwindcss/vite` serve a runtime build.

### 5. Quality tooling

- **F-24 — PHPStan root: estensioni commentate, baseline disabilitata** — `M`
  - Percorso: `laravel/phpstan.neon:1-8,12-15,36-40,51`.
  - Evidenza: `level: max`, `paths: Modules/`, baseline e include Larastan/Carbon/safe-rule/Pest commentati; include attivo solo `bleedingEdge.neon`; `tmpDir: /tmp/phpstan/`; `scanFiles` solo `Modules/Xot/helpers/Helper.php`.
  - Impatto: l’analisi può non caricare le estensioni Laravel/Safe/Pest previste e dipendere da `phpstan/extension-installer`; `excludePaths` con pattern `./*/docs/*` va verificato.
  - Rimedio: verificare `vendor/bin/phpstan analyse --debug` l’elenco estensioni caricate; riattivare gli include necessari o documentare perché sono disabilitati.

- **F-25 — Tool PHP non uniformi root/moduli** — `M`
  - Percorsi: root `laravel/phpstan.neon`, `laravel/pint.json:1-12`, `laravel/phpinsights.php:34-87`, `laravel/tools/phpmd.xml:1-4`, `laravel/phpmd-ruleset.xml`, `laravel/phpunit.xml:8-21`, `laravel/phpunit-user.xml`; moduli con `pint.json` solo in alcuni (`Activity`, `Job`, `Notify`, `Tenant`, `UI`, `User`, `Xot`).
  - Evidenza: `phpinsights.php` rimuove molti check (`:53-79`); `tools/phpmd.xml` referenzia `phpmd-ruleset.xml` che esiste in `laravel/` ma la risoluzione dipende dal cwd; `phpunit.xml` root scopre solo `Modules/*/tests/Unit|Feature` con suffisso `Test.php`.
  - Impatto: suite diverse per modulo/root; test in `Integration`, `Performance`, lowercase o `audit-coverage` non girano nel run root (vedi anche `test-quality-audit.md`).
  - Rimedio: definire un’unica entrypoint (`pest` root) e allineare `phpunit.xml`/Pest bootstrap; verificare PHPMD da `laravel/`.

- **F-26 — PHPUnit modulo incoerenti** — `M`
  - Percorsi: `Modules/Activity/phpunit.xml:4,14-15` (bootstrap `vendor/autoload.php`, source include `./src` inesistente come codice principale), `Modules/User/phpunit.xml:4` (bootstrap `../../vendor/autoload.php`), root `laravel/phpunit.xml:4,8-14`.
  - Impatto: run scoped e run root non equivalenti; `Activity` include una directory `src` non usata.
  - Rimedio: uniformare bootstrap su `../../vendor/autoload.php` o sul root e rimuovere `src` dai template modulo.

### 6. CI e deploy

- **F-27 — CI root minimale; workflow modulo non attivi o datati** — `M`
  - Percorsi: `.github/workflows/no-git-lfs.yml` (unico attivo), `.github/workflows/semantic-release.yml.template` (template), `laravel/Modules/{Notify,UI}/.github/workflows/rector.yaml`, `laravel/Modules/*/.github/workflows/*.test|.yaml`.
  - Evidenza: i workflow sotto `laravel/Modules/*/.github/workflows` non sono visti dalla root GitHub Actions; `rector.yaml` usa PHP `8.1` e `actions/checkout@v2`/`ramsey/composer-install`/`EndBug/add-and-commit`, datati vs PHP `^8.3`/Laravel 13.
  - Impatto: se i moduli sono repo separati, Rector lavora su stack sbagliato; se sono solo cartelle del monorepo, i workflow sono morti.
  - Rimedio: chiarire se i moduli sono repo separati; altrimenti rimuovere/spostare workflow inattivi e aggiornare PHP/actions.

- **F-28 — `deploy.sh` non builda gli asset frontend** — `C`
  - Percorso: `deploy.sh:56-57,90-94`.
  - Evidenza: deploy esegue `composer install --no-dev`, symlink temi, `storage:link`, migrate opzionale, `optimize:clear`, `filament:assets`, `optimize`, `filament:optimize`; **non** esegue `npm ci`, `npm run build` root né build moduli/temi. `public_html/build` è gitignored (`.gitignore:280`) e attualmente assente.
  - Impatto: su checkout fresco il deploy può mancare di `public_html/build/manifest.json` e asset Vite.
  - Rimedio: aggiungere step frontend esplicito oppure documentare che gli asset sono pubblicati fuori Git prima del deploy; verificare `public_html/build/manifest.json` prima di `optimize`.

- **F-29 — `deploy.sh` + symlink tema** — `C` (con F-20)
  - Percorso: `deploy.sh:59-70`.
  - Evidenza: il loop abortisce se `public_html/themes/<Tema>` esiste e non è symlink; su questo checkout i file sono normali.
  - Rimedio: sistemare i symlink sul filesystem target o rendere lo script idempotente verso file-puntatore; mantenere il divieto di copie reali.

- **F-30 — Lock/CI bash coerente** — `B` (OK)
  - Percorso: `bashscripts/lock/lock.sh`, `unlock.sh`; usati per questo report.
  - Evidenza: lock atomico con `set -C`; nessun problema rilevato.

## Cose che risultano coerenti

- `composer validate` OK per `laravel/composer.json` (warning solo `*`) e per `/composer.json` (warning license).
- `laravel/composer.lock` esiste e `composer show coolsam/panel-modules` risolve il path package locale.
- PSR-4 moduli segue `Modules\<M>\` → `app/` nella stragrande maggioranza dei casi.
- Nessun `env()` eseguibile trovato in `laravel/app` o `Modules/*/app`.
- `config/local` e `config/localhost` sono versionati apposta (`.gitignore:233-235`) e caricati ricorsivamente da Laravel.
- Root `laravel/vite.config.js` usa `publicDirectory: '../public_html'` e `outDir: '../public_html/build'`, coerente con `Application::publicPath()`.
- `deploy.sh` usa `composer install --no-dev` dal lock, non `composer update`, e non reintroduce `npm run copy`.
- Nessun script `copy` attivo per i temi; i riferimenti residui sono documentazione/commenti.

## Limitazioni

- Non eseguiti `composer install/update`, `composer audit`, `composer show -a` completo, `npm install`, `vite build`, PHPStan, Pint, PHP Insights, PHPMD, Pest/PHPUnit o deploy reale.
- Verifica abandoned/deprecated **da verificare**; nessun pacchetto è stato dichiarato abbandonato senza evidenza runtime/registry.
- Verifica PSR-4 è spot-check sulle convenzioni Composer + namespace; non è stato fatto un mapping esaustivo classe-per-classe dei ~4.3k file `Modules\...`.
- I workflow sotto `laravel/Modules/*/.github/workflows` potrebbero appartenere a repository modulo separati; nel monorepo root non sono attivi.
- Il comportamento esatto di `wikimedia/composer-merge-plugin` su `repositories`/`scripts` dei moduli va verificato con `composer config`/`composer validate` in contesto reale; i finding F-05/F-12 sono marcati **da verificare** dove serve.
