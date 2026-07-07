# OpenViking: BLADE-ICONS FIX

**URI**: `viking://fixes/blade-icons`  
**Timestamp**: 2026-03-30  
**Status**: ✅ FIXED

---

## ❌ ERROR

```
The options for the "heroicons" set don't have any paths defined.
```

---

## 🎯 FIX

### config/blade-icons.php

**BEFORE**:
```php
'sets' => [
    'heroicons' => [
        'prefix' => 'heroicon',
    ],
],
```

**AFTER**:
```php
'sets' => [
    // 'heroicons' => [...], // Removed - not installed
],
```

---

## ✅ USE CUSTOM ICONS

```blade
<x-filament::icon icon="ui-brands.facebook" class="w-5 h-5" />
<x-filament::icon icon="ui-brands.twitter" class="w-5 h-5" />
```

---

## 📁 ICONS LOCATION

```
Modules/UI/resources/svg/brands/
├── facebook.svg
├── twitter.svg
├── instagram.svg
└── ...
```

---

## 🧹 CACHE

```bash
rm -rf bootstrap/cache/* storage/framework/cache/* storage/framework/views/*
```

---

**Status**: ✅ FIXED  
**Icons**: Use `ui-brands.*`
