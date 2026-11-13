# Story: alzare `require.php` root a ^8.4 per PHPStan corretto

Supersedes: nessuna. Collega: iniziativa "PHPStan Modules zero-error remediation".
Richiesta utente (verbatim): "esegui cd laravel && composer update -W e sistema
tutte le segnalazioni utilizzando bmad + ecc + second brain" + audit completo.

## Stato verificato

- `php artisan about`: PHP 8.4.27, Laravel 13.42.0.
- `composer.lock` platform: `php ^8.4`.
- `composer.json` root: `"php": "^8.2"` — ERRATO: il codice usa gia' typed class
  constants (PHP 8.3+) e gira su 8.4.
- PHPStan 2.3.5 inferisce la versione PHP minima da `require.php` dei composer.json
  e analizza come PHP 8.2 → 252 errori `classConstant.nativeTypeNotSupported`
  (falsi positivi) + il resto del report.
- `phpstan.neon` e' SACRO (solo utente): niente `phpVersion`, niente `-c`/`--level`.
  Il fix corretto e' nel manifest, non nel neon.

## Decisione

Allineare `require.php` root a `^8.4` (reale runtime + lock platform) e
`composer update -W`. Se PHPStan residuo segnalera' feature 8.4-only assenti nel
codice, la versione va rimossa — ma il codice esistente usa gia' 8.3+.

## Piano

1. Edit `composer.json`: `"php": "^8.2"` → `"^8.4"`.
2. `composer update -W` + `composer validate`.
3. Rieseguire PHPStan Modules: i 252 `nativeTypeNotSupported` devono sparire;
   triaggiare i ~155 errori residui reali.

## Dev Agent Record

- 2026-11-10: causa radice identificata (PHPStan legge `require.php`); fix in corso.
