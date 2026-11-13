---
title: "Deploy di produzione"
type: guide
module: Xot
status: active
created: 2026-11-11
updated: 2026-11-11
tags: [deploy, produzione, release, artisan, composer]
qmd: "deploy produzione deploy.sh composer install no-dev migrate additivo manutenzione optimize filament assets queue restart health check up"
related:
  - ./wiki/rules/theme-public-symlink.md
  - ./bmad/stories/5.302-release-readiness-asset-temi-document-root.story.md
---
# Deploy di produzione

Script: `deploy.sh` alla root del repo. Si lancia sul server, dalla root:

```bash
./deploy.sh                 # pull ff-only + install + migrate + cache + up
./deploy.sh --no-pull       # codice già aggiornato
./deploy.sh --skip-migrate  # non tocca il database
```

## Cosa fa, in ordine

1. Verifica `laravel/.env` e rifiuta `APP_DEBUG=true`.
2. `php artisan down --retry=60`.
3. `git pull --ff-only` (forward-only, mai rewrite).
4. `composer install --no-dev --optimize-autoloader` **dal lock**: mai `update`
   in produzione, le versioni sono quelle testate.
5. Symlink relativi `public_html/themes/<Tema>` → `../../laravel/Themes/<Tema>/public`;
   rimuove un eventuale `public_html/hot`.
6. `storage:link --relative` se manca.
7. Migrazioni **solo additive**: se ce ne sono di pendenti esegue
   `php artisan migrate`, che in produzione chiede conferma (serve un TTY).
   Mai `--force`, `migrate:fresh`, wipe.
8. `optimize:clear` → `filament:assets` → `optimize` → `filament:optimize`.
9. `queue:restart`, poi `php artisan up`.
10. Health check su `APP_URL/up`.

Se un passo fallisce lo script si ferma e lascia l'app in manutenzione:
corretto il problema, `cd laravel && php artisan up`.

## Differenze con il vecchio script

Il vecchio `deploy.sh` era uno script di setup locale: scaricava composer,
faceva `composer update -W`, `vendor:publish --all`, cancellava
`database/migrations/*`, generava gli ide-helper e chiudeva con
`php artisan serve`. In produzione rendeva le versioni non riproducibili e
bloccava il terminale. Per l'ambiente di sviluppo si usa `composer go` in
`laravel/`.

## Checklist `.env` di produzione

- `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` corretto.
- `LOG_LEVEL` almeno `warning`; nessun log shipping fuori UE (ADR-010).
- `SESSION_SECURE_COOKIE=true` dietro HTTPS.
- Worker code attivi (supervisor/systemd) e `schedule:run` nel cron.
