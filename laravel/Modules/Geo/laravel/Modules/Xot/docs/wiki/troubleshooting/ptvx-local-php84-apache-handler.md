---
title: "ptvx.local — errore PHP 8.3 vs dipendenze 8.4"
module: Xot
type: troubleshooting
status: approved
tags: [ptvx.local, php84, apache, htaccess, platform-check]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - "../concepts/php84-upgrade-extension-checklist.md"
  - "../../../../../../public_html/.htaccess"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/147"
---

# ptvx.local — PHP 8.4 su Apache (handler)

## Sintomo

HTTP **500** su `http://ptvx.local/`:

```text
Composer detected issues in your platform: Your Composer dependencies require a PHP version ">= 8.4.0". You are running 8.3.30.
```

in `laravel/vendor/composer/platform_check.php`.

## Causa

- `composer.lock` / moduli richiedono **PHP ^8.4** (CLI locale: 8.4.x).
- Apache globale usa **php8.3-fpm** (`/etc/apache2/conf-enabled/php8.3-fpm.conf` → `php8.3-fpm.sock`).
- In `public_html/.htaccess` il `FilesMatch` per forzare **mod_php 8.4** era **rotto** (`\ >` invece di `$>`), quindi l’override non scattava.

## Fix applicato (repo)

In `public_html/.htaccess`:

```apache
<FilesMatch ".+\.ph(?:ar|p|tml)$">
    SetHandler application/x-httpd-php
</FilesMatch>
```

(`libapache2-mod-php8.4` deve restare abilitato; vedi `apache2ctl -M | grep php`.)

## Verifica

```bash
curl -sS -o /dev/null -w "%{http_code}\n" http://ptvx.local/    # atteso 302 verso /admin
curl -sS -o /dev/null -w "%{http_code}\n" -L http://ptvx.local/admin  # atteso 200
```

## Alternativa (host)

Installare **php8.4-fpm** e puntare il vhost a `php8.4-fpm.sock` (template: `laravel/config/vhost/ptvx.local.conf`). Script: `bashscripts/tools/lamp/upgrade_php84.sh --apache`.

## Collegamenti

- [Checklist PHP 8.4](../concepts/php84-upgrade-extension-checklist.md)
- [Policy MariaDB runtime](../concepts/mariadb-runtime-policy.md)
