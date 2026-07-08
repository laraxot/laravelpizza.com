---
title: "HasMediaForm cannot redeclare (cross-base)"
module: Media
type: troubleshooting
confidence: high
updated: 2026-05-21
tags: [filament, autoload, media, php]
---

# Errore: Cannot redeclare `HasMediaForm`

## Sintomo

```
Cannot redeclare class Modules\Media\app\Filament\Resources\HasMediaResource\Schemas\HasMediaForm
(previously declared in /var/www/_bases/base_ptvx_fila5/laravel/Modules/Media/...)
```

Spesso durante `composer run go` o `php artisan optimize`.

## Causa

1. **Due progetti Laraxot nella stessa sessione PHP** — autoload di `base_ptvx_fila5` e `base_fixcity_fila5` insieme (terminali/IDE multi-root, script che includono entrambi i `vendor/autoload.php`).
2. **Namespace errato** (storico): `namespace Modules\Media\app\Filament\...` nel file PHP. Il namespace corretto è `Modules\Media\Filament\...` (la cartella fisica è `app/`, il segmento `app` non va nel namespace).
3. **Filament discover sbagliato**: `discoverResources(in: base_path('Modules/Media'), for: 'Modules\\Media')` costruisce FQCN con `app` nel mezzo — usare sempre `XotBasePanelProvider` (`.../app/Filament/Resources` + `Modules\\{Module}\\Filament\\Resources`).

## Fix immediato (solo FixCity)

Dalla root **di questo** progetto:

```bash
cd laravel
php8.4 artisan optimize:clear
rm -rf bootstrap/cache/filament
php8.4 "$(command -v composer)" dump-autoload -o
php8.4 artisan optimize
```

Non eseguire `composer`/`artisan` da `base_ptvx_fila5` nella stessa shell se stai lavorando su FixCity.

## Verifica namespace nel file

```bash
head -6 Modules/Media/app/Filament/Resources/HasMediaResource/Schemas/HasMediaForm.php
```

Deve essere:

```php
namespace Modules\Media\Filament\Resources\HasMediaResource\Schemas;
```

## Collegamenti

- [Namespace modulo Xot](../../../Xot/docs/wiki/concepts/module-namespace-path-convention.md)
- [Filament resource structure audit](../../../../../../bashscripts/docs/wiki/concepts/filament-resource-structure-audit.md)
