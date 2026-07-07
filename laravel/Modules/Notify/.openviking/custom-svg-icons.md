# OpenViking: CUSTOM SVG ICONS

**URI**: `viking://icons/custom-svg`  
**Timestamp**: 2026-03-30  
**Status**: ✅ IMPLEMENTED

---

## 🎯 SOLUTION

Create SVG files in `Modules/UI/resources/svg/brands/`

**Auto-registered as**: `ui-brands.<filename>`

---

## 📁 ICONS CREATED

```
Modules/UI/resources/svg/brands/
├── facebook.svg    → ui-brands.facebook
├── twitter.svg     → ui-brands.twitter
├── instagram.svg   → ui-brands.instagram
├── youtube.svg     → ui-brands.youtube
├── linkedin.svg    → ui-brands.linkedin
├── telegram.svg    → ui-brands.telegram
├── whatsapp.svg    → ui-brands.whatsapp
└── rss.svg         → ui-brands.rss
```

---

## ✅ USAGE

```blade
<x-filament::icon icon="ui-brands.facebook" class="w-5 h-5" />
<x-filament::icon icon="ui-brands.twitter" class="w-5 h-5" />
<x-filament::icon icon="ui-brands.instagram" class="w-5 h-5" />
```

---

## 🔨 CREATE NEW ICON

### 1. Create SVG File

`Modules/UI/resources/svg/brands/tiktok.svg`

```svg
<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
  <path d="..."/>
</svg>
```

### 2. Use

```blade
<x-filament::icon icon="ui-brands.tiktok" class="w-5 h-5" />
```

---

## 🧘 ADVANTAGES

> *"No external packages. Custom SVGs. Auto-registered."*

> *"ui-brands.* for brands. Heroicons for UI."*

---

**Status**: ✅ 8 icons created  
**Next**: Add more as needed
