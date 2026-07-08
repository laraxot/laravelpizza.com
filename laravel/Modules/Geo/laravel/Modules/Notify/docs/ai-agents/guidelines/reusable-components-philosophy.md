# 🧩 Componenti Riutilizzabili - Filosofia Zen

**Version**: 1.0.0  
**Date**: 2026-03-26  
**Status**: ✅ PHILOSOPHY DEFINED

---

## 🎯 The Zen of Reusable Components

> "Un componente, infiniti usi. Scrivi una volta, usa ovunque."

### Perché Componenti Riutilizzabili?

**1. DRY (Don't Repeat Yourself)**
- ❌ **PRIMA**: 10 blade diversi per outcomes (F1, Politics, Crypto, Sports)
- ✅ **ADESSO**: 1 componente `outcomes-grid` per TUTTI i mercati

**2. KISS (Keep It Simple, Stupid)**
- ❌ **PRIMA**: Logica complessa in ogni blade
- ✅ **ADESSO**: Componente semplice, input espliciti

**3. Scalabilità**
- ❌ **PRIMA**: Refactoring per ogni nuovo tipo di mercato
- ✅ **ADESSO**: 2 → 30+ outcomes senza modifiche

**4. Manutenibilità**
- ❌ **PRIMA**: Fix in 10 file diversi
- ✅ **ADESSO**: Fix in 1 file, funziona ovunque

**5. Consistenza**
- ❌ **PRIMA**: UI diversa per ogni mercato
- ✅ **ADESSO**: Stessa UX per tutti i mercati

---

## 🏗️ Architecture Principles

### Principle 1: Single Responsibility

```blade
{{-- ✅ CORRETTO: Un componente = una responsabilità —}}
<x-predict-view.outcomes-grid :outcomes="$outcomes" />
<x-predict-view.stats-bar :stats="$stats" />
<x-predict-view.order-book :orderBook="$orderBook" />

{{-- ❌ SBAGLIATO: Componente "god" che fa tutto —}}
<x-predict-view.everything :data="$everything" />
```

### Principle 2: Composability

```blade
{{-- Componenti piccoli si combinano —}}
@livewire('view-predict-widget')
    ├── header.blade.php
    ├── stats-bar.blade.php
    ├── outcomes-grid.blade.php
    ├── order-book.blade.php
    └── sidebar-enhanced.blade.php
```

### Principle 3: Agnosticism

```php
// ✅ CORRETTO: Supporta 2-30+ outcomes
foreach ($outcomes as $outcome) {
    // Funziona per F1 (6), Politics (10), Binary (2)
}

// ❌ SBAGLIATO: Assunzione binary
if ($isBinary) {
    // Logica speciale per YES/NO
}
```

### Principle 4: Explicit Inputs

```blade
@php
    // ✅ CORRETTO: Input espliciti con fallback
    $outcomes = $outcomes ?? [];
    $stats = $stats ?? [];
@endphp

{{-- ❌ SBAGLIATO: Variabili globali implicite —}}
{{ $outcomes[0]['title'] }} {{-- Da dove viene? --}}
```

### Principle 5: Minimal Logic

```blade
{{-- ✅ CORRETTO: Logica nelle Action classes —}}
@php
    $orderBook = BuildOrderBookAction::make()->execute($predict);
@endphp
<x-predict-view.order-book :orderBook="$orderBook" />

{{-- ❌ SBAGLIATO: Logica complessa nel blade —}}
@php
    // 100 righe di logica...
@endphp
```

---

## 📊 Component Categories

### Category 1: Display Components

**Purpose**: Show data to user

| Component | File | Reusability |
|-----------|------|-------------|
| Outcomes Grid | `outcomes-grid.blade.php` | 2-30+ outcomes |
| Stats Bar | `stats-bar.blade.php` | All markets |
| Order Book | `order-book.blade.php` | Multi-outcome |
| Price Chart | `price-chart.blade.php` | All markets |
| Recent Trades | `recent-trades.blade.php` | All markets |

### Category 2: Interaction Components

**Purpose**: User input/actions

| Component | File | Reusability |
|-----------|------|-------------|
| Trading Form | `trading-form.blade.php` | All markets |
| Share Buttons | `share-buttons.blade.php` | All pages |
| Comments | `comments.blade.php` | All markets |

### Category 3: Layout Components

**Purpose**: Structure/organization

| Component | File | Reusability |
|-----------|------|-------------|
| Header | `header.blade.php` | All predict pages |
| Sidebar | `sidebar-enhanced.blade.php` | All detail pages |
| Tabs | `tabs.blade.php` | All content types |

---

## 🔧 Component Template

```blade
@php
    /**
     * Component Name - Description
     * 
     * @var array $data Input data
     * @var \Modules\Predict\Models\Predict $predict Model
     */
    
    // Initialize with defaults
    $data = $data ?? [];
    $predict = $predict ?? null;
    
    // Helper function for translations
    $tx = static function (string $key, string $fallback): string {
        $translated = __($key);
        return is_string($translated) && $translated !== $key ? $translated : $fallback;
    };
@endphp

<div class="component-root">
    {{-- Header --}}
    <div class="header">
        <h3>{{ $tx('predict::titles.component', 'Title') }}</h3>
    </div>
    
    {{-- Content --}}
    <div class="content">
        @foreach($data as $item)
            {{-- Render item --}}
        @endforeach
    </div>
    
    {{-- Footer --}}
    @if(count($data) > 0)
        <div class="footer">
            {{ count($data) }} items
        </div>
    @endif
</div>
```

---

## 📈 Performance Guidelines

### 1. Lazy Loading

```blade
{{-- Load heavy components last —}}
<x-predict-view.outcomes-grid :outcomes="$outcomes" />
<x-predict-view.order-book :orderBook="$orderBook" />
@livewire('comments-widget') {{-- Lazy via Livewire —}}
```

### 2. Minimize Queries

```php
// ✅ CORRETTO: Single query with eager loading
$predict = Predict::with(['ratings', 'transactions'])->find($id);

// ❌ SBAGLIATO: N+1 queries
$predict = Predict::find($id);
foreach ($predict->ratings as $rating) {
    $rating->transactions; // Query per outcome!
}
```

### 3. Cache Expensive Computations

```blade
@php
    // Cache order book calculation
    $orderBook = Cache::remember(
        "order_book_{$predict->id}",
        300, // 5 minutes
        fn() => BuildOrderBookAction::make()->execute($predict)
    );
@endphp
```

---

## 🎯 Testing Strategy

### Component Tests

```php
it('renders outcomes grid with 6 outcomes', function () {
    $outcomes = [
        ['title' => 'Verstappen', 'probability' => 28.0],
        // ... 5 more
    ];
    
    $html = Blade::render('<x-predict-view.outcomes-grid :outcomes="$outcomes" />', [
        'outcomes' => $outcomes
    ]);
    
    expect($html)->toContain('Verstappen')
        ->toContain('28.0%');
});
```

### Integration Tests

```php
it('displays F1 predict detail page', function () {
    $predict = Predict::factory()->create(['slug' => 'f1-world-champion-2026']);
    
    $response = $this->get('/it/predicts/f1-world-champion-2026');
    
    $response->assertStatus(200)
        ->assertSee('Verstappen')
        ->assertSee('28.0%');
});
```

---

## 🔗 Related Documentation

### Module Docs
- **[Components Index](laravel/Modules/Predict/resources/views/components/predict-view/00-INDEX.md)** - All components
- **[Reusable Architecture](laravel/Modules/Predict/docs/components/reusable-architecture.md)** - Design principles
- **[Multi-Outcome Fundamental](laravel/Modules/Predict/docs/MULTI-OUTCOME-FUNDAMENTAL.md)** - Core principle

### Theme Docs
- **[Theme Zero Components](laravel/Themes/Zero/docs/components/00-INDEX.md)** - Theme components
- **[TwentyOne Integration](laravel/Themes/TwentyOne/docs/predict-integration.md)** - Theme integration

### AI Agents Docs
- **[Rules Index](.agents/docs/rules/00-INDEX.md)** - Filament Tables rule
- **[Skills Index](.agents/docs/skills/00-INDEX.md)** - Component skills
- **[Guidelines Index](.agents/docs/guidelines/00-INDEX.md)** - Best practices

---

## 📝 Changelog

### 2026-03-26 - Philosophy Defined
- ✅ Created reusable components philosophy
- ✅ Documented 5 design principles
- ✅ Added component categories
- ✅ Performance guidelines
- ✅ Testing strategy

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Status**: ✅ Production Ready
