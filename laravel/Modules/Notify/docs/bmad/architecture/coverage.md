---
title: "Notify — copertura dei test"
module: notify
type: reference
status: active
tags: [coverage, testing, pest, notify]
created: 2026-08-24
updated: 2026-09-11
qmd: "notify coverage pest unit 6.3 percento misurato xdebug db irraggiungibile; notificationlogresource completato 2026-09-11"
---

# Notify — copertura dei test

## Aggiornamento 2026-09-11 — NotificationLogResource completato

Contesto: `NotificationLogResource` era orfano (solo file `.test`/`.php.test`, mai caricati
dall'autoloader — vedi `docs/stories/xotbaseresourcetable-model-audit-notify-batch.story.md`).
Completato in questo turno: Resource + 4 Pages + Form/Infolist Schema con campi reali
(`channel`, `status`, `notifiable_type`, `notifiable_id`, `status_message`, `data`, `metadata`,
`tenant_id`, `sent_at`/`delivered_at`/`failed_at`/`opened_at`/`clicked_at`), lang IT reali al
posto dei placeholder autogenerati.

`XDEBUG_MODE=coverage vendor/bin/pest Modules/Notify` (l'intera suite, non solo `tests/Unit`)
non produce oggi una tabella di coverage %: **400 test falliscono già sul baseline**, prima di
qualunque modifica di questo turno (verificato spostando temporaneamente i file nuovi fuori e
rilanciando la stessa suite: stesso conteggio, 400 falliti). Causa: errori di bootstrap
pre-esistenti e non correlati (`Call to undefined method Container::basePath()`,
`BindingResolutionException: Target class [config]/[translator] does not exist`, `A facade
root has not been set`), non qualcosa introdotto qui — non in scope per questo item.

Verifica mirata (isolata dal rumore del baseline rotto), in
`tests/Unit/Filament/Resources/NotifyFilamentResourcesCoverageTest.php`:

```bash
cd laravel
XDEBUG_MODE=coverage vendor/bin/pest --filter "notification log" \
    Modules/Notify/tests/Unit/Filament/Resources/NotifyFilamentResourcesCoverageTest.php
```

| Metrica | Valore |
|---|---:|
| Nuovi test (pagine/form/infolist/table di NotificationLogResource) | 4 |
| Passati | 4/4 |
| Assertion | 23 |
| Regressioni introdotte sul resto della suite | 0 (400 falliti prima e dopo, stesso identico numero) |

`vendor/bin/phpstan analyse Modules/Notify --no-progress`: **`[OK] No errors`** (8 file
analizzati per la sola Resource, verificato con `--error-format=json` e contando
`file_errors`, non il testo). PHPMD (`Modules/Notify/phpmd.xml`, `StaticAccess` escluso come
da convenzione del modulo): 0 violazioni sui file nuovi/modificati.

## Misura storica (Unit only, DB irraggiungibile)

```bash
cd laravel
php -d memory_limit=3G -d xdebug.mode=coverage \
    ./vendor/bin/pest Modules/Notify/tests/Unit --coverage --min=0
```

Eseguita il 27 agosto 2026.

| Metrica | Valore |
|---|---:|
| Copertura totale | **6.3%** |
| Test passati | 463 |
| Test saltati | 300 |
| Assertion | 1.851 |
| Durata | 267 s |
| Aree a copertura 0% | 36 |

## Perché il numero è basso, e cosa non dice

**300 test su 763 sono saltati.** Il database di test (`10.100.200.53:3306`, `ptv_lara_test`)
non era raggiungibile al momento della misura: tutto ciò che tocca il DB non gira. Il 6.3%
misura quindi la sola parte Unit eseguibile senza DB, non la copertura reale del modulo.
Prima di rimisurare: `nc -z -w3 10.100.200.53 3306`.

**`xdebug.mode=coverage` è obbligatorio sulla riga di comando.** Senza, Pest esce con
`Unable to get coverage using Xdebug` — xdebug è caricato ma non in modalità coverage.

## Dove la copertura c'è

Interamente coperti (100%): `Http/Controllers/Controller`, `Http/Kernel`, i middleware
(`CheckForMaintenanceMode`, `EncryptCookies`, `PreventRequestsDuringMaintenance`,
`TrimStrings`, `TrustProxies`, `ValidateSignature`, `VerifyCsrfToken`),
`Providers/AppServiceProvider`, `Providers/Filament/AdminPanelProvider`.

Sono le classi di scaffolding: vengono attraversate dal bootstrap, non da test scritti
apposta. Il 100% qui non è un merito.

## Dove manca

36 aree a 0%, fra cui tutti i `View/Components/*` (`GuestLayout`, `Header`, `Input`).
È lì che il coverage va alzato, non nel middleware già al 100%.

## Nota sulla versione precedente di questo file

Fino al 27 agosto 2026 questo documento dichiarava «comprehensive test coverage» e «all
tests are passing» con **tutti i numeri a zero**: files 0, classi 0, metodi 0, coverage 0%.
Un documento che afferma il contrario di ciò che misura è peggio della sua assenza, perché
chiude la domanda invece di aprirla. Gli stessi template vuoti restano in
`Modules/Tenant/docs/coverage.md` e `Modules/Xot/docs/coverage.md`.
