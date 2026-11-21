---
title: "bugfix applayout view path"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "bugfix applayout view path"
issues: []
discussions: []
---

# Bugfix: `AppLayout` puntava a una view inesistente

## 🐛 Errore

**Data:** 2026-08-31
**Comando:** `./vendor/bin/phpstan analyse Modules` (root, `laravel/phpstan.neon`, invariata)

**File:** `Modules/Cms/app/View/Components/AppLayout.php:21`

```
Parameter #1 $view of function view expects view-string|null, string given.
[identifier=argument.type]
```

### Causa

Due difetti sovrapposti, entrambi fuori dal modulo Cms.

**1. Il tema attivo non esisteva.** `AppLayout` risolve `pub_theme::`, che
`CmsServiceProvider` registra su `Themes/{pub_theme}/resources/views`. Il valore
effettivo arrivava da `config/local/techplanner/xra.php` — non da `config/xot.php` — ed
era `Two`, un tema assente da questo repo. Con il namespace puntato a una directory
inesistente, Larastan non riusciva a risolvere **nessuna** view `pub_theme::`, e ogni
chiamata `view()` diventava `argument.type`.

**2. Il nome della view era comunque sbagliato.** Anche con il tema corretto,
`pub_theme::layouts.app` non esiste in `Themes/TwentyOne`: il layout applicativo sta in
`resources/views/components/layouts/app.blade.php`, quindi il nome corretto e'
`pub_theme::components.layouts.app`. Solo `Themes/Zero` ha
`resources/views/layouts/app.blade.php`, il che rendeva il bug invisibile finche' quel
tema era attivo.

L'errore PHPStan era quindi un sintomo di configurazione, non di tipizzazione. Castare
la stringa o annotare `@phpstan-var view-string` lo avrebbe silenziato lasciando il
layout irrisolvibile a runtime.

## ✅ Correzione

`Modules/Cms/app/View/Components/AppLayout.php`:

```php
public function render(): Factory|View
{
    $view_params = [];

    return view('pub_theme::components.layouts.app', $view_params);
}
```

La variabile intermedia `$view` e' stata rimossa: passando il letterale, Larastan verifica
il nome view contro il filesystem invece di vedere un `string` generico.

Fuori dal modulo, deduplicate le chiavi `pub_theme` e corretto il valore a `TwentyOne` in
`config/local/techplanner/xra.php`, `config/localhost/xra.php`,
`config/net/sottana1/xra.php` e nei rispettivi `xot.php`.

## 🔍 Verifica

```bash
php artisan config:clear
php artisan tinker --execute="echo view()->exists('pub_theme::components.layouts.app') ? 'EXISTS' : 'MISSING';"
./vendor/bin/phpstan analyse Modules --no-progress --memory-limit=-1
```

Atteso: `EXISTS`, poi `[OK] No errors`.

## 📌 Regola appresa

Prima di modificare un nome view o la sua tipizzazione, verificare nell'ordine:

1. `config('xra.pub_theme')` — quale valore vince davvero (le chiavi duplicate in PHP non danno errore, vince l'ultima)
2. `app('view')->getFinder()->getHints()['pub_theme']` — quale directory viene risolta
3. `test -d "Themes/$theme"` — la directory esiste
4. `view()->exists('pub_theme::...')` — il nome view esiste dentro quel tema

## 🔗 Correlati

- `docs/wiki/concepts/tenant-config-xra-is-the-source.md`
- `laravel/docs/wiki/concepts/public-theme-resolution-and-vite-assets.md`
- `docs/wiki/troubleshooting/phpstan-bootstrap-vendor-incompleto.md`
