---
title: "artisan serve — Redis connection refused (WSL)"
module: Xot
type: troubleshooting
status: approved
tags: [artisan-serve, redis, wsl, predis, opcache]
created: 2026-06-15
updated: 2026-06-15
qmd: "artisan serve redis connection refused 6379 predis opcache WSL"
related:
  - ../../../../../../bashscripts/tools/start-local-redis.sh
  - ../concepts/php84-upgrade-extension-checklist.md
  - ptvx-local-php84-apache-handler.md
---

# artisan serve — Redis connection refused

## Sintomo

```bash
cd laravel && php artisan serve
```

```text
Predis\Connection\Resource\Exception\StreamInitException
Connection refused [tcp://127.0.0.1:6379]
```

Stack tipico: boot applicazione → cache/session Redis → `GetComponentsAction` / Spatie Data.

## Causa

`.env` locale (`CACHE_DRIVER=redis`, `SESSION_DRIVER=redis`, `REDIS_CLIENT=predis`) richiede un server Redis in ascolto su `127.0.0.1:6379`. Su WSL **redis-server non era installato** né in esecuzione.

## Non è OPcache

`php -i` → `opcache.enable => On` (web). OPcache **non** blocca `artisan serve`.  
Warning JIT + estensioni terze parti: innocuo in dev.

## Fix (installare e avviare Redis)

### Opzione A — pacchetto sistema (preferita, richiede sudo)

```bash
sudo apt install redis-server redis-tools
sudo service redis-server start
redis-cli ping   # PONG
```

### Opzione B — build utente (senza sudo)

Già usata su questa macchina:

```bash
bashscripts/tools/start-local-redis.sh
```

Prima build (una tantum): vedi commenti nello script (`~/.local/redis`).

## Verifica

```bash
redis-cli ping          # PONG
cd laravel && php artisan serve
# Server running on http://127.0.0.1:8000
```

Se `:8000` occupata, Laravel usa `:8001`.

## Config rilevante

| Variabile | Valore tipico `.env` |
|-----------|---------------------|
| `CACHE_DRIVER` | `redis` |
| `SESSION_DRIVER` | `redis` |
| `REDIS_HOST` | `127.0.0.1` |
| `REDIS_PORT` | `6379` |
| `REDIS_CLIENT` | `predis` (non richiede estensione `phpredis`) |

`config/cache.php` usa `CACHE_STORE` (default `database` se assente); sessione resta su Redis se `SESSION_DRIVER=redis`.

## Note HTTP 500 post-avvio

Server avviato ≠ homepage OK. Errori successivi (memoria, DB, route) sono **distinti** da Redis refused. Controllare `storage/logs/laravel.log`.
