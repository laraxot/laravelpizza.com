---
title: "PHP 8.4 upgrade extension checklist"
module: "Xot"
type: concept
confidence: high
created: 2026-05-21
updated: 2026-05-21
tags: [php, runtime, model-states, xot]
related:
  - laravel13-modular-package-compatibility-matrix.md
  - phpstan-fixes-log.md
sources:
  - https://github.com/spatie/laravel-model-states/blob/main/composer.json
  - ../../lamp/install.txt
---

# PHP 8.4 upgrade extension checklist

## Scopo

Prerequisito per installare `spatie/laravel-model-states` ^2.14 e allineare Laravel 13 nel lock condiviso. Tracker: [#87](https://github.com/laraxot/base_fixcity_fila5/issues/87).

Installazione distro (Sury / Apache / MariaDB): [`docs/lamp/install.txt`](../../lamp/install.txt). Script: [`upgrade_php84.sh`](../../../../../../bashscripts/tools/lamp/upgrade_php84.sh), [`migrate_mysql_to_mariadb.sh`](../../../../../../bashscripts/tools/lamp/migrate_mysql_to_mariadb.sh). Policy DB: [mariadb-runtime-policy.md](mariadb-runtime-policy.md).

## Runtime attuale (baseline 8.3.30)

Estensioni rilevate su ambiente dev (`php -m`):

- bcmath, bz2, calendar, ctype, curl, dom, exif, fileinfo, filter, ftp, gd, gettext, hash, iconv, igbinary, imap, intl, json, libxml, mbstring, memcached, msgpack, mysqli, mysqlnd, odbc, openssl, pcntl, pcov, pcre, pdo_dblib, pdo_mysql, pdo_pgsql, pdo_sqlite, pgsql, posix, random, readline, redis, session, shmop, sockets, sodium, sqlite3, standard, sysvmsg, sysvsem, sysvshm, tokenizer, xml, xmlreader, xmlwriter, xsl, zip, zlib
- opzionali dev: xdebug, FFI

## Dopo install PHP 8.4

1. Verificare `php8.4 -v` → 8.4.x (su WSL2 FixCity: **8.4.17** già presente; `php` default può restare 8.3 senza `sudo`).
2. Estensioni: su questo host **nessuna mancante** rispetto a 8.3 (`comm` moduli vuoto).
3. **Composer/artisan/PHPStan:** prefissare con `php8.4` oppure `sudo update-alternatives --set php /usr/bin/php8.4`.
4. Workflow Composer in [#87](https://github.com/laraxot/base_fixcity_fila5/issues/87) — **completato** 2026-05-21.

## Comandi post-upgrade (modulo Xot)

Preferire **`php8.4`** davanti a `composer` perché `/usr/local/bin/composer` ha shebang `/usr/bin/env php` — se `php` resta **8.3**, Composer applicherebbe i vincoli sbagliati.

```bash
# cwd = root del repo
rm -f laravel/Modules/Xot/composer.lock
cd laravel
php8.4 "$(command -v composer)" update -W
php8.4 ./vendor/bin/phpstan clear-result-cache
php8.4 ./vendor/bin/phpstan analyse Modules/Xot/app/States --memory-limit=1G --no-progress
```

⚠️ **`composer run go`** (script in `composer.json` root Laravel) ripete `composer update`, fa `vendor:publish --all`, **cancella `database/migrations/*`**, rilancia `migrate` ecc. Va usato solo in ambienti dove questa chirurgia è voluta; per il solo fix **`model-states`** basta **`composer update -W`** con PHP **8.4**.

Nota progetto: in questo repo **`*.lock` è in `.gitignore`** — il nuovo `laravel/composer.lock` locale non entra in Git finché la policy non cambia.

## Riferimenti

- [Installazione LAMP / PHP 8.4 su host](../../lamp/install.txt)
- [Laravel 13 modular package compatibility matrix](laravel13-modular-package-compatibility-matrix.md)
- [PHPStan fixes log — model-states](phpstan-fixes-log.md)
