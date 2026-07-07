---
title: "Folio — routing filesystem, mai web.php FO"
type: concept
tags: [cms, folio, routing, frontoffice, religion]
created: 2026-06-10
updated: 2026-06-10
qmd: "folio filesystem routing no web.php pages name middleware folio:list FolioVoltServiceProvider route helper mental model index bracket model binding"
issues:
  - https://github.com/laraxot/base_fixcity_fila5/issues/289
related:
  - ../../../folio-routing-locale.md
  - laravel-folio-module-dependency.md
  - folio-volt-static-mount-contract.md
  - ../troubleshooting/folio-route-not-found.md
  - ../../../../Themes/Sixteen/docs/wiki/concepts/fo-folio-routing-zen.md
  - ../../../../../../docs/wiki/memories/folio-no-web-routes-religion.md
---

# Folio — routing filesystem, mai web.php FO

## Religione (una frase)

**Nel front office la rotta è il file Blade in `pages/` — non si aggiunge mai `Route::get()` in `web.php`.**

## Come funziona Folio (Laravel 13.x)

Folio è un **page-based router**: creare una pagina = creare una rotta.

| Azione nel file `pages/` | Effetto |
|--------------------------|---------|
| `greeting.blade.php` | URL `/{locale}/greeting` |
| `notifications/index.blade.php` | URL `/{locale}/notifications` |
| `name('notifications')` | named route → `route('notifications')` |
| `middleware(['auth'])` | middleware sulla pagina |
| `php artisan folio:list` | audit rotte montate |

Riferimento: [Laravel Folio 13.x](https://laravel.com/docs/13.x/folio)

## Modello mentale (confusione tipica)

| Concetto | Verità Folio | Errore comune |
|----------|--------------|---------------|
| Dove **nasce** la rotta | File in `pages/` montato da `Folio::path()` | `Route::get()` in `web.php` |
| Cosa fa `route('notifications')` | **Genera URL** verso pagina con `name('notifications')` | «Registra» la rotta |
| Cosa fa `name('notifications')` | **Registra** il nome Folio sul file | Opzionale ma obbligatorio per `route()` |
| Chi monta le cartelle | `FolioVoltServiceProvider` (Cms) | Ogni modulo con `web.php` |
| Nome route | Inglese, allineato al path file | Italiano (`area-personale.*`) |

**Zen:** il filesystem è il router. `web.php` è un secondo router — nel FO crea doppia verità, nomi fantasma e `RouteNotFoundException`.

## Mappatura file → URL (Laraxot + locale)

Con `Folio::path($path)->uri('it')` ogni file sotto `$path` riceve prefisso `/it/`:

| Pattern file in `pages/` | URL esempio | Note |
|--------------------------|-------------|------|
| `home.blade.php` | `/it/home` | segmento = basename |
| `notifications/index.blade.php` | `/it/notifications` | cartella + `index` = index route |
| `auth/login.blade.php` | `/it/auth/login` | nested route |
| `pages/[slug].blade.php` | `/it/pages/foo` | `$slug` iniettato nel Blade |
| `api/ticket-details/[Ticket].blade.php` | `/it/api/ticket-details/{uuid}` | route model binding Eloquent |
| `users/[...ids].blade.php` | `/it/users/1/2/3` | catch-all → array `$ids` |

Parametri: [Route Parameters](https://laravel.com/docs/13.x/folio#route-parameters), [Model Binding](https://laravel.com/docs/13.x/folio#route-model-binding).

## Blocco PHP pagina (contratto minimo)

```php
<?php
use function Laravel\Folio\{middleware, name};

name('notifications');
middleware(['web', 'auth']);
?>
```

Middleware globale mount: `Folio::path(...)->middleware(['*' => [SetFolioLocale, ...]])`.

## Perché mai `web.php` nel FO (politica Laraxot)

1. **Co-location** — vista, `name()`, `middleware`, Volt nello stesso file.
2. **Modularità** — owner = modulo dominio; Cms monta.
3. **Audit** — `folio:list` fonte unica.
4. **No controller** — regola FO.
5. **i18n** — `uri($locale)` per ogni lingua.


## Mount Laraxot (`FolioVoltServiceProvider`)

Owner **Cms** — `Modules/Cms/app/Providers/FolioVoltServiceProvider.php`

```php
Folio::path($themePagesPath)->uri($locale)->middleware([...]);
Folio::path($modulePath)->uri($locale)->middleware([...]);
```

| Sorgente | Esempio file | URL |
|----------|--------------|-----|
| Tema Sixteen | `Themes/Sixteen/resources/views/pages/lista-categorie.blade.php` | `/it/lista-categorie` |
| Modulo User | `Modules/User/resources/views/pages/notifications/index.blade.php` | `/it/notifications` |
| Modulo Fixcity API | `Modules/Fixcity/resources/views/pages/api/...` | uri dedicata nel provider |

## Tre superfici link FO (non confonderle)

| Contesto | Come linkare | Verifica |
|----------|--------------|----------|
| Menu header utente (dropdown) | `route('<folio-name>')` | `folio:list` |
| Nav da `header.json` / CMS | `FrontofficeUrl::fromStoredUrl($url)` | path relativo nel JSON |
| Path senza `name()` Folio | `FrontofficeUrl::path('/segmento')` | locale applicato da mcamara |

`route()` nel Blade **non definisce** la rotta: risolve l'URL di un file Folio che ha già `name()`.

## Vietato vs consentito

| Vietato | Consentito |
|---------|------------|
| `Route::get('/notifiche', ...)` in `web.php` | file `pages/notifications/index.blade.php` |
| `route('area-personale.notifiche')` (nome inventato, italiano) | `route('notifications')` se in `folio:list` |
| `route('user.services')` (modulo Laravel classico) | pagina Folio owner nel modulo giusto |
| `FrontofficeUrl::personalArea*` nel menu | `route()` o `fromStoredUrl()` come sopra |

## Workflow nuova pagina FO

1. Identificare **owner** (modulo dominio o tema vestito).
2. `php artisan folio:page <path>` nella cartella `resources/views/pages/` dell'owner.
3. Blocco PHP: `name()` in **inglese**, `middleware()`, eventuale Volt `mount()`.
4. `php artisan folio:list` — nome e path devono comparire.
5. Link nel tema: `route('<name>')` verificato.

## `web.php` — eccezioni documentate

`laravel/routes/web.php` non è il registro FO. Eccezione attuale: `POST /livewire/form-create-ticket` (workaround Livewire). Ogni altra riga va motivata in wiki.

## Cache e produzione

```bash
cd laravel && php artisan folio:list
php artisan route:cache   # Folio registra named route (doc Laravel)
```

Se `RouteNotFoundException` persiste con sorgente già corretto → [folio-route-not-found.md](../troubleshooting/folio-route-not-found.md).


## Audit: `folio:list` ≠ `route:list`

`route:list` non sostituisce `folio:list` per il FO. Dettaglio: [folio-list-vs-route-list.md](folio-list-vs-route-list.md).

## Flusso header autenticato (caso reale)

1. `v1.blade.php` conta notifiche (`NotificationSchema::isReadable()`).
2. Include `user-dropdown` con `route('notifications')` ecc.
3. Se query DB notifiche **ok** ma `RouteNotFoundException` → quasi sempre **cache Blade stale** o server non riavviato ([route-not-found-view-cache.md](../../../../Themes/Sixteen/docs/wiki/troubleshooting/route-not-found-view-cache.md)).

## Partial canonici header (Sixteen)

| Partial | Ruolo |
|---------|--------|
| `partials/user-dropdown.blade.php` | Menu utente loggato — `route()` Folio |
| `partials/personal-area-guest-cta.blade.php` | Guest — `route('login')` |
| `components/header/user-dropdown.blade.php` | Legacy — stesse named route, preferire partials/ |


## Collegamenti

- [Folio e locale](../../../folio-routing-locale.md)
- [Zen routing Sixteen](../../../../Themes/Sixteen/docs/wiki/concepts/fo-folio-routing-zen.md)
- [Header named routes](../../../../Themes/Sixteen/docs/wiki/concepts/fo-folio-named-routes-header.md)
- [Notifiche User](../../../../User/docs/wiki/concepts/notifications-folio-page.md)
