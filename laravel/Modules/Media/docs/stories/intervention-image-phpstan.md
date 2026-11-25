---
title: "PHPStan zero — Intervention Image v4 in Media"
type: story
status: done
module: Media
qmd: "phpstan intervention image media merge strip metadata class.notFound"
related:
  - ./01.media-phpstan-fix.story.md
  - ./media-quality-gate-2026-09-04.story.md
  - ../philosophy.md
  - ../00-index.md
---

# PHPStan zero — Intervention Image v4

## Scopo (perché)

`Merge` e `StripImageMetadataAction` devono unire/watermarkare immagini e
strippare EXIF/GPS dagli upload. Usano **Intervention Image v4** (GD): API
`ImageManager` + `Drivers\Gd\Driver` + encoder con `strip: true`. PHPStan
deve **vedere** le classi via autoload Composer root, non silenziarle.

## Causa radice dei `class.notFound`

Composer dichiarava `intervention/image` **4.4.1** con PSR-4
`Intervention\Image\` → `vendor/intervention/image/src`.

Quando il filesystem vendor espone ancora (o in modo inconsistente su NAS)
il layout **v2** (`src/Intervention/Image/...`) mentre `installed.json`
punta al layout **v4** (`src/ImageManager.php`, `src/Drivers/...`),
`class_exists` e PHPStan falliscono: le classi v4 non esistono al path
atteso → cascata di `method.nonObject` / `assignOp.invalid` / `cast.string`
sui return tipizzati come `mixed` perché il tipo del manager è sconosciuto.

Non è un bug di PHPStan config: **non** toccare `phpstan.neon` / baseline.

## Fix applicato

1. Verificare vendor reale: `composer show intervention/image` = 4.4.1 e
   file `src/ImageManager.php` + `src/Drivers/Gd/Driver.php` presenti.
2. `Merge`: API v4 tipizzata (`decodePath`, `createImage`, `insert` con
   `Alignment`, `save`); `handle()` ripristinato a **merge verticale**
   (non overlay center); manager privato DRY.
3. `StripImageMetadataAction`: `encode(...)->toString()` invece di cast
   `(string)` su risultato potenzialmente `mixed` in analisi degradata.
4. `Modules/Media/composer.json`: vincolo `intervention/image: ^4.4`
   (il codice dipende dall’API v4, non da `*`).

## Gate

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Media --memory-limit=-1 --error-format=raw
php -l Modules/Media/app/Actions/Image/Merge.php
php -l Modules/Media/app/Actions/Image/StripImageMetadataAction.php
```

Target: **0** errori sul modulo Media.

## Non fare

- `@phpstan-ignore` / baseline / abbassare level
- Tornare all’API Intervention v2 (`Image::make`, facade)
- Silenziare con `mixed` ove l’interfaccia v4 espone tipi concreti
