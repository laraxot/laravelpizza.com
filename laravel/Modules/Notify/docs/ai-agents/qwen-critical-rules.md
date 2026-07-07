# QWEN Critical Rules

Regole critiche del progetto Base Predict.

---

## 🔴 REGOLA 1: FILAMENT WIDGETS FOR LISTS

### Principio Core

**OGNI pagina lista DEVE usare Filament Table Widgets - NESSUNA ECCEZIONE**

### ❌ MAI Fare

```blade
{{-- NO foreach in list blades --}}
@foreach($items as $item)
    <div>{{ $item->title }}</div>
@endforeach

{{-- NO Livewire in Themes/Http/Livewire/ --}}
Themes/TwentyOne/Http/Livewire/*.php  ← FORBIDDEN!

{{-- NO Controllers for lists --}}
PredictController@index  ← FORBIDDEN!
```

### ✅ SEMPRE Fare

```blade
{{-- Filament Table Widget --}}
@livewire(\Modules\Predict\Filament\Widgets\PredictTableWidget::class)

{{-- Or via CMS JSON --}}
{
    "type": "widget",
    "data": {
        "view": "pub_theme::filament.widgets.predict-table",
        "widget": "Modules\\Predict\\Filament\\Widgets\\PredictTableWidget"
    }
}
```

### Feature Automatiche

- ✅ Search (debounce 400ms)
- ✅ Sorting (multi-column)
- ✅ Filters
- ✅ Pagination
- ✅ Bulk Actions
- ✅ Export
- ✅ WCAG 2.2 AA
- ✅ Mobile Responsive
- ✅ URL Sync

---

## 🔴 REGOLA 2: COMPOSER DEPENDENCY ARCHITECTURE

### Root composer.json = SOLO Core Infrastructure

```json
{
  "require": {
    "php": "^8.2",
    "filament/filament": "^5.0",
    "laravel/framework": "^12.0",
    "livewire/livewire": "^3.0 || ^4.0",
    "nwidart/laravel-modules": "*",
    "wikimedia/composer-merge-plugin": "^2.1"
  }
}
```

### Best Practices

1. **Versioni Esplicite**: `^13.0`, MAI `*`
2. **Merge Plugin**: Unisce automaticamente i moduli
3. **Service Providers**: Dichiarare in `extra.laravel.providers`
4. **Autoload PSR-4**: Ogni modulo gestisce il proprio

---

## 🔴 REGOLA 3: ROUTING MULTILINGUA

### Homepage & Link

```blade
{{-- ✅ CORRETTO --}}
<x-page side="content" slug="home" />

{{-- ❌ SBAGLIATO --}}
@include('pub_theme::home')
```

### Link Localizzati

```blade
{{-- ✅ CORRETTO --}}
<a href="{{ url(app()->getLocale().'/predicts') }}">Mercati</a>

{{-- ❌ SBAGLIATO --}}
<a href="/predicts">Mercati</a>
```

---

## 🔴 REGOLA 4: NEVER POLLUTE CONTAINER BLADE

**File**: `Themes/TwentyOne/resources/views/pages/[container0]/[slug0]/index.blade.php`

### ❌ MAI Fare

```php
// In generic container blade
public function getMarketData(): array { ... }
public function loadPriceHistory(): array { ... }
public function buildOrderBook(): array { ... }
```

### ✅ CORRETTO

La logica specifica va in:
1. **Filament Widgets**: `Modules/Predict/Filament/Widgets/`
2. **Actions**: `Modules/Predict/Actions/`
3. **CMS Blocks**: `Modules/Predict/resources/views/components/blocks/`

---

## 🔴 REGOLA 5: Translation Structure

**Tutte le traduzioni DEVONO avere 5 elementi**:

```
namespace::context.collection.element.type
```

```blade
✅ __('predict::user.fields.first_name.label')
❌ __('predict::fields.key')  // Missing type!
```

---

## 🔗 Link

- [Indice QWEN](./qwen-split-index.md)
- [critical-rules.md](./critical-rules.md)
- [QWEN.md originale](../../QWEN.md)
- [Index principale](./index.md)
