# OpenViking Update: Filament Icon Convention

**URI**: `viking://themes/sixteen/filament-icon-convention`  
**Timestamp**: 2026-03-30  
**Status**: ✅ COMPLETE

---

## 🎯 Icon Convention

**NEVER use**: `<x-icon>` or raw `<svg>`  
**ALWAYS use**: `<x-filament::icon>`

---

## 📖 Syntax

```blade
<x-filament::icon 
    icon="heroicon-o-check-circle" 
    class="w-8 h-8 text-green-600" 
    aria-hidden="true" 
/>
```

---

## 🎨 Icon Sets

### Heroicons (Default in Filament)

#### Outline Icons (`heroicon-o-*`)
- `heroicon-o-check-circle` - Success
- `heroicon-o-information-circle` - Info
- `heroicon-o-exclamation-triangle` - Warning
- `heroicon-o-x-circle` - Error
- `heroicon-o-arrow-right` - Navigation
- `heroicon-o-plus` - Add
- `heroicon-o-pencil` - Edit
- `heroicon-o-trash` - Delete
- `heroicon-o-search` - Search
- `heroicon-o-user` - User
- `heroicon-o-lock-closed` - Lock
- `heroicon-o-envelope` - Email

#### Solid Icons (`heroicon-s-*`)
- `heroicon-s-check-circle` - Success (filled)
- `heroicon-s-information-circle` - Info (filled)
- `heroicon-s-exclamation-triangle` - Warning (filled)
- `heroicon-s-x-circle` - Error (filled)
- `heroicon-s-star` - Star (filled)
- `heroicon-s-heart` - Heart (filled)

---

## 📋 Common Use Cases

### 1. Alert Icons

```blade
{{-- Success --}}
<x-filament::icon icon="heroicon-o-check-circle" class="w-5 h-5 text-green-600" />

{{-- Info --}}
<x-filament::icon icon="heroicon-o-information-circle" class="w-5 h-5 text-blue-600" />

{{-- Warning --}}
<x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-5 h-5 text-yellow-600" />

{{-- Error --}}
<x-filament::icon icon="heroicon-o-x-circle" class="w-5 h-5 text-red-600" />
```

### 2. Button Icons

```blade
<button class="btn btn-primary flex items-center gap-2">
    <x-filament::icon icon="heroicon-o-plus" class="w-5 h-5" />
    Aggiungi
</button>

<button class="btn btn-outline flex items-center gap-2">
    <x-filament::icon icon="heroicon-o-pencil" class="w-5 h-5" />
    Modifica
</button>
```

### 3. Navigation Icons

```blade
<x-filament::icon icon="heroicon-o-chevron-right" class="w-4 h-4 text-gray-400" />
<x-filament::icon icon="heroicon-o-arrow-right" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-arrow-left" class="w-5 h-5" />
```

### 4. Status Icons

```blade
<span class="inline-flex items-center gap-1">
    <x-filament::icon icon="heroicon-s-check-circle" class="w-4 h-4" />
    Completato
</span>
```

---

## 🎨 Size Classes

```blade
{{-- Small --}}
<x-filament::icon icon="heroicon-o-check" class="w-4 h-4" />
<x-filament::icon icon="heroicon-o-check" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-check" class="w-6 h-6" />

{{-- Medium --}}
<x-filament::icon icon="heroicon-o-check-circle" class="w-8 h-8" />

{{-- Large --}}
<x-filament::icon icon="heroicon-o-check-circle" class="w-10 h-10" />
<x-filament::icon icon="heroicon-o-check-circle" class="w-12 h-12" />
```

---

## 🎨 Color Classes

```blade
{{-- Green (Success) --}}
<x-filament::icon icon="heroicon-o-check-circle" class="w-6 h-6 text-green-600" />

{{-- Blue (Info) --}}
<x-filament::icon icon="heroicon-o-information-circle" class="w-6 h-6 text-blue-600" />

{{-- Yellow (Warning) --}}
<x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-6 h-6 text-yellow-600" />

{{-- Red (Error) --}}
<x-filament::icon icon="heroicon-o-x-circle" class="w-6 h-6 text-red-600" />

{{-- Gray (Neutral) --}}
<x-filament::icon icon="heroicon-o-check" class="w-6 h-6 text-gray-600" />

{{-- White --}}
<x-filament::icon icon="heroicon-o-check" class="w-6 h-6 text-white" />
```

---

## ✅ Files Updated

### Blade Components
- [x] `components/blocks/confirmation/simple.blade.php` - Updated to use `<x-filament::icon>`
- [x] `components/blocks/confirmation/with-details.blade.php` - Updated to use `<x-filament::icon>`

### Documentation
- [x] `docs/FILAMENT_ICON_GUIDE.md` - Complete icon guide created
- [x] `docs/blocks/BLOCKS_STRUCTURE_CONVENTION.md` - Updated with icon convention section

---

## 🔗 References

### Documentation
- `viking://themes/sixteen/docs/filament-icon-guide` - Full icon guide (Filament 5)
- `viking://themes/sixteen/docs/blocks-structure-convention` - Blocks convention

### External
- [Filament 5 Icons](https://filamentphp.com/docs/5.x/forms/icon-picker)
- [Heroicons](https://heroicons.com/)

---

## 🧘 Developer Mantra

> *"NEVER `<x-icon>`. ALWAYS `<x-filament::icon>`."*

> *"Outline for UI. Solid for status."*

> *"Consistent sizes. Semantic colors."*

---

**Maintainer**: AI Agent Collective  
**Last Updated**: 2026-03-30  
**Status**: ✅ ENFORCED - Use `<x-filament::icon>` in all new components
