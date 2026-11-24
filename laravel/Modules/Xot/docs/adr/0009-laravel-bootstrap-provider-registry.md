---
title: "ADR 0009 — Bootstrap Laravel 13 minimale e discovery dei moduli"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/ADR-0009"
qmd: "0009 laravel bootstrap provider registry minimale"
---

# ADR 0009: Bootstrap Laravel 13 minimale e discovery dei moduli

## Contesto

Laravel 13 introduce il service provider auto-discovery: non è più necessario elencare manualmente tutti i provider del framework in `bootstrap/providers.php`. I provider dei moduli nwidart vengono scoperti automaticamente tramite composer.json (`extra.laravel.providers`) e lo script `post-autoload-dump` che esegue `package:discover`.

Il file `bootstrap/providers.php` precedente elencava manualmente tutti i provider Illuminate (Auth, Cache, Session, ecc.) più i provider dei moduli. Questo è ridondante e fonte di errori.

## Decisione

**`bootstrap/providers.php` contiene solo `AppServiceProvider::class`.** I provider dei moduli sono scoperti automaticamente da Laravel 13. L'application provider registra esplicitamente `App\Providers\Filament\AdminPanelProvider`, che appartiene all'app e non a un package Composer. `VoltServiceProvider` resta disponibile nel codice ma non è registrato perché non monta servizi.

I provider dei moduli sono registrati nei rispettivi `composer.json` tramite la chiave `extra.laravel.providers` e scoperti dal comando `package:discover`.

## Driver della decisione

- Il bootstrap dei provider deve avere un registro unico leggibile da Laravel.
- Un provider non deve essere registrato sia nel bootstrap sia dall'application provider.

## Alternative scartate

- Registrare provider applicativi in file duplicati.
- Registrare `AdminPanelProvider` direttamente nel registro bootstrap insieme ai package provider.

- Elencare manualmente tutti i provider Laravel nel bootstrap: è responsabilità
  del framework e crea una copia divergente del template ufficiale.
- Elencare ogni provider di modulo nel root: introduce coupling e impedisce al
  progetto di caricare i moduli tramite discovery.
- Registrare direttamente i provider dev: fallisce con `composer install --no-dev`.

## Conseguenze

### Positive
- Meno manutenzione: non serve aggiornare il file quando Laravel aggiunge nuovi provider
- Allineamento con il comportamento standard di Laravel 13
- Riduzione della superficie di errore

### Negative
- I provider dei moduli devono essere correttamente registrati nel composer.json
- Il deploy deve eseguire `composer install` (o `composer dump-autoload`) per far funzionare la discovery
- Il provider Filament applicativo deve restare registrato da `AppServiceProvider::register()`.

## Verifica

```bash
# Verifica che i provider siano scoperti
php artisan package:discover --ansi
php artisan about --only=providers
php artisan --version
```

Quando cambia il registro dei provider o un `RouteServiceProvider`, la cache
delle rotte deve essere rigenerata: in sviluppo `php artisan route:clear`, in
deploy `route:trans:cache`. Una cache vecchia può lasciare fuori le rotte API
del modulo e trasformare una richiesta PNG in una pagina HTML 404, causando
anche l'errore MIME del browser.

## Cross-link

- [Laravel 13.x bootstrap/providers.php](https://github.com/laravel/laravel/blob/13.x/bootstrap/providers.php)
- [Laravel Package Discovery](https://laravel.com/docs/13.x/packages#package-discovery)
- [nwidart/laravel-modules](https://github.com/nWidart/laravel-modules)
## Conferma

La decisione è confermata dal registro provider corrente e dai test di bootstrap del modulo Xot.
