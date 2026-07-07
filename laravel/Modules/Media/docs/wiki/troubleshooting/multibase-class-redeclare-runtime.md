---
title: "Ri-dichiarazione classe PHP con due basi _bases contemporanee"
type: troubleshooting
confidence: high
created: "2026-05-21"
updated: "2026-05-21"
tags: [php, composer, opcache, multibase, filament]
related:
  - ../concepts/second-brain-local-discipline.md
  - ../concepts/context-overflow-prevention.md
  - ../../README.md
---

# FatalError: Cannot redeclare class (path mix `base_*_fila5`)

## Sintomo

Messaggio tipo:

`Cannot redeclare class Modules\Media\Filament\Resources\HasMediaResource\Schemas\HasMediaForm (previously declared in /var/www/_bases/base_ptvx_fila5/laravel/Modules/Media/...)`

 mentre la seconda segnatura punta a un altro albero sotto `_bases/` o a un path relativo del progetto «corrente». Spesso compare durante `@php artisan optimize` o `composer run go`.

## Causa radice

Un solo processo PHP carica **due file fisici diversi** che definiscono la **stessa classe** (`namespace` + `class` uguali). Non è tipicamente un conflitto PSR-4 nella stessa installazione Composer: Composer non può registrare due file per lo stesso FQCN nella stessa mappa.

Scenari comuni:

- `composer` o `php` eseguiti dalla **directory sbagliata** (vendor/bootstrap di un’app e sorgenti moduli di un’altra base).
- **OPcache preload** / `auto_prepend_file` in `php.ini` che include file sotto un’altra base.
- **Symlink condiviso** errato (`vendor`, `bootstrap/cache`, o intero `laravel`).
- Workers (Octane/RoadRunner/queue) riavviati senza perdere bytecode vecchio dopo aver cambiato tree.

Mitigazione opzionale in codice (`class_exists(..., false)` attorno alla dichiarazione) **non** sostituisce la correzione dell’ambiente: maschera il sintomo quando due tree restano combinati nel processo.

## Verifica rapida

1. Esegui comandi sempre da `laravel/` del progetto voluto (`pwd`).
2. `php -r 'print_r(require "vendor/composer/autoload_psr4.php");'` e verifica che `Modules\Media\` punti **solo** a `.../<questa-base>/laravel/Modules/Media/app`.
3. Controlla `php.ini` (CLI e FPM): `zend_extension=opcache`, `opcache.preload`, `auto_prepend_file`.
4. Nessun symlink che unisca `vendor` tra due `_bases`.

## Correzione

1. Da `laravel/` del progetto corretto: `php artisan optimize:clear` (eventuale `rm -f bootstrap/cache/*.php` solo se compatibile col deploy).
2. Riavvio PHP-FPM / pool che servono l’istanza dopo cambio tree (`opcache_reset` dove applicabile).
3. Allinea le due basi solo se davvero devono contenere copie parallele della stessa classe; altrimenti **non** caricare mai autoload/vendor di due app nello stesso processo.

## Riferimento codice modulo

Implementazione canonica della form nel modulo Media: [`HasMediaForm.php`](../../../app/Filament/Resources/HasMediaResource/Schemas/HasMediaForm.php).

## Vedi anche

- [Second brain discipline locale](../concepts/second-brain-local-discipline.md)
- Documentazione modulo [README](../../README.md)
- Wiki modulo: [context-overflow-prevention](../concepts/context-overflow-prevention.md)
