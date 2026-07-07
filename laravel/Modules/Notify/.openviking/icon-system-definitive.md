# OpenViking: ICON SYSTEM - DEFINITIVE

**URI**: `viking://icon-system/definitive`  
**Timestamp**: 2026-03-30  
**Priority**: CRITICAL - NEVER AGAIN!

---

## ❌ ERROR WE KEEP MAKING

```blade
<x-heroicon-o-facebook class="w-5 h-5" />  <!-- ❌ WRONG! 356 times in codebase! -->
```

**Problem**: Blade Heroicons NOT installed!

---

## ✅ DEFINITIVE SOLUTION

### Use: `<x-filament::icon>`

```blade
<x-filament::icon icon="heroicon-o-facebook" class="w-5 h-5" />
```

**WHY**:
- ✅ Filament 5 already installed (v5.4.3)
- ✅ No extra dependencies
- ✅ Works with all Heroicons

---

## 📋 SYNTAX

### Correct

```blade
{{-- Static icon --}}
<x-filament::icon icon="heroicon-o-facebook" class="w-5 h-5" />

{{-- Dynamic icon --}}
<x-filament::icon :icon="$iconName" class="w-5 h-5" />

{{-- Solid icons --}}
<x-filament::icon icon="heroicon-s-star" class="w-4 h-4 text-yellow-400" />
```

### Wrong

```blade
<x-heroicon-o-facebook />           <!-- ❌ Requires blade-heroicons -->
<x-heroicon name="facebook" />      <!-- ❌ Deprecated -->
<x-filament::icon name="facebook" /> <!-- ❌ Wrong attribute! -->
<svg>...</svg>                      <!-- ❌ Verbose -->
```

---

## 🔧 COMMON ICONS

```blade
{{-- Social --}}
<x-filament::icon icon="heroicon-o-facebook" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-twitter" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-instagram" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-youtube" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-linkedin" class="w-5 h-5" />

{{-- Navigation --}}
<x-filament::icon icon="heroicon-o-arrow-right" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-chevron-down" class="w-4 h-4" />

{{-- UI --}}
<x-filament::icon icon="heroicon-o-menu" class="w-6 h-6" />
<x-filament::icon icon="heroicon-o-x-mark" class="w-6 h-6" />
<x-filament::icon icon="heroicon-o-bell" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-user-circle" class="w-8 h-8" />
```

---

## 🧘 MANTRAS

> *"SEMPRE `<x-filament::icon icon=\"...\">`. MAI `<x-heroicon-o-*>`."*

> *"Filament è già installato. Non aggiungere dipendenze."*

> *"Icon attribute = `icon`, NON `name`!"*

---

## 📖 REFERENCES

- [Filament 5 Icons](https://filamentphp.com/docs/5.x/forms/icon-picker)
- `.planning/ICON_SYSTEM_DEFINITIVE.md` - Full rule

---

**Status**: ✅ **DEFINITIVE**  
**Effective**: Immediately  
**Enforcement**: MANDATORY - NEVER AGAIN THIS ERROR!
