---
title: "Topic svg-icons"
type: digest
status: active
qmd: "digest ceiling 100 svg-icons"
---

# Topic svg-icons

Sintesi automatica di 3 documenti (chiave `svg-icons`).

## ✅ SVG Icons - Automatic Registration

_Fonte: `svg-icons-automatic-registration-2.md`_

# ✅ SVG Icons - Automatic Registration

**Data**: 2026-03-30  
**Stato**: ✅ **CORRETTO**

## 🎯 Concetto Chiave

**Gli SVG vengono registrati AUTOMATICAMENTE da Laravel!**

Non serve:
- ❌ Service Provider personalizzati
- ❌ Registrazione manuale con FilamentAsset
- ❌ Blade::anonymousComponentPath()

Basta:
- ✅ Mettere i file SVG in `resources/svg/`
- ✅ Usare `<x-svg name="folder.icon-name" />`

## 📁 Directory Structure

```
laravel/Modules/UI/resources/svg/
└── brands/
    ├── facebook.svg    → <x-svg name="brands.facebook" />
    ├── twitter.svg     → <x-svg name="brands.twitter" />
    ├── youtube.svg     → <x-svg name="brands.youtube" />
    ├── telegram.svg    → <x-svg name="brands.telegram" />
    ├── whatsapp.svg    → <x-svg name="brands.whatsapp" />
    └── rss.svg         → <x-svg name="brands.rss" />

## ✅ SVG Icons - Automatic Registration

_Fonte: `svg-icons-automatic-registration.md`_

# ✅ SVG Icons - Automatic Registration

**Data**: 2026-03-30  
**Stato**: ✅ **CORRETTO**

## 🎯 Concetto Chiave

**Gli SVG vengono registrati AUTOMATICAMENTE da Laravel!**

Non serve:
- ❌ Service Provider personalizzati
- ❌ Registrazione manuale con FilamentAsset
- ❌ Blade::anonymousComponentPath()

Basta:
- ✅ Mettere i file SVG in `resources/svg/`
- ✅ Usare `<x-svg name="folder.icon-name" />`

## 📁 Directory Structure

```
laravel/Modules/UI/resources/svg/
└── brands/
    ├── facebook.svg    → <x-svg name="brands.facebook" />
    ├── twitter.svg     → <x-svg name="brands.twitter" />
    ├── youtube.svg     → <x-svg name="brands.youtube" />
    ├── telegram.svg    → <x-svg name="brands.telegram" />
    ├── whatsapp.svg    → <x-svg name="brands.whatsapp" />
    └── rss.svg         → <x-svg name="brands.rss" />

## ✅ SVG Icons - Automatic Registration COMPLETE

_Fonte: `svg-icons-complete.md`_

# ✅ SVG Icons - Automatic Registration COMPLETE

**Data**: 2026-03-30  
**Stato**: ✅ **COMPLETATO**

## 🎯 Concetto Chiave

**Gli SVG vengono registrati AUTOMATICAMENTE da Filament!**

## 📁 SVG Files Created (6)

**Path**: `laravel/Modules/UI/resources/svg/brands/`

| File | Icon Name | Usage |
|------|-----------|-------|
| `facebook.svg` | `ui-brands.facebook` | `<x-filament::icon icon="ui-brands.facebook" />` |
| `twitter.svg` | `ui-brands.twitter` | `<x-filament::icon icon="ui-brands.twitter" />` |
| `youtube.svg` | `ui-brands.youtube` | `<x-filament::icon icon="ui-brands.youtube" />` |
| `telegram.svg` | `ui-brands.telegram` | `<x-filament::icon icon="ui-brands.telegram" />` |
| `whatsapp.svg` | `ui-brands.whatsapp` | `<x-filament::icon icon="ui-brands.whatsapp" />` |
| `rss.svg` | `ui-brands.rss` | `<x-filament::icon icon="ui-brands.rss" />` |

## 🔧 How It Works

### Automatic Registration

```
Modules/UI/resources/svg/brands/facebook.svg
  ↓
