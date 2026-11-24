---
title: "ADR — Configurazione Notify centralizzata"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
issues: []
module: Notify
---

# ADR — Configurazione Notify centralizzata

## Contesto

Provider e canali di notifica usano configurazioni sensibili e variabili per ambiente.

## Driver della decisione

- Evitare `env()` sparsi e configurazioni divergenti.

## Decisione

Notify carica la configurazione tramite il suo adapter centralizzato e lascia ai provider solo il comportamento di consegna.

## Alternative scartate

- Leggere segreti direttamente da provider o view.

## Conseguenze

La configurazione è cacheabile e verificabile; ogni nuovo canale deve passare dal contratto Notify.

## Conferma

Verificare configurazione compilata, adapter e test del canale.
<<<<<<< .merge_file_gRHRq1
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_I6tDcy

## Verifica

- `vendor/bin/pest Modules/Notify/tests/Unit/Datas/NotifyConfigDataTest.php` (`Modules/Notify/tests/Unit/Datas/NotifyConfigDataTest.php`): fallisce se i valori di `NotifyConfigData` non
  arrivano dal file di configurazione del tenant o se i default cambiano.
- Revisione ripetibile: `rg -n 'env\(' laravel/Modules/Notify/app laravel/Modules/Notify/config --glob '*.php'` deve trovare solo commenti;
  le letture da ambiente stanno in `Modules/Notify/config/notify.php` (`Env::get`) e nel merge di
  `Modules/Notify/app/Providers/Concerns/MergesNotifyConfigFromEnv.php`.
- PHPStan: la regola `larastan.noEnvCallsOutsideOfConfig` e' attiva in `laravel/phpstan-strict.neon`.
<<<<<<< .merge_file_gRHRq1
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_I6tDcy
