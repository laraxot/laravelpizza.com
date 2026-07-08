# 🎯 Filament Table vs Blade Component - Decision Guide

**Data**: 2026-03-26  
**Status**: ✅ MANDATORY ARCHITECTURE RULE  
**Priority**: 🔴 CRITICAL

---

## 🚨 REGOLA FONDAMENTALE

> **LIST-like public surface** = Filament Table Widget  
> **Detail shell, trading, charts, hero** = Blade Component (custom UI)

---

## 📊 DECISION MATRIX

| Use Case | Component Type | File Pattern | Features |
|----------|---------------|--------------|----------|
| **Lista di Mercati** (`/it/predicts`) | ✅ Filament Table Widget | `Themes/*/resources/views/filament/widgets/predict-table.blade.php` | Search, Filter, Sorting, Pagination |
| **Dettaglio Mercato** (`/it/predicts/{slug}`) | ✅ Mixed shell | `ViewPredictWidget` + Blade shell + widget Filament per sezioni list-like | Trading, charts, hero, list-like outcomes |
| **Lista Articoli** (`/it/articles`) | ✅ Filament Table Widget | `Themes/*/resources/views/filament/widgets/article-table.blade.php` | Search, Filter, Sorting |
| **Dettaglio Articolo** (`/it/articles/{slug}`) | ✅ Mixed shell | Blade narrativa + widget Filament dove la sezione e list-like | Reading, comments, related content |

---

## 🎯 PREDICT LIST PAGE (Filament Table)

### URL: `/it/predicts`

**Componente**: `PredictTableWidget` (Filament)

**Perché Filament**:
- Lista di mercati
- Serve cercare, filtrare, ordinare
- Tanti dati -> pagination

---

## 🎯 PREDICT DETAIL PAGE (Mixed Shell)

### URL: `/it/predicts/f1-world-champion-2026`

**Componente**: Blade shell + widget Filament dove la sezione e list-like

**Struttura corretta**:
```text
Modules/Predict/resources/views/filament/widgets/view-predict.blade.php
├── header / hero / stats / trading-form / order-book / chart = Blade shell
└── OutcomesTableWidget = Filament table per outcomes list-like
```

**Perché mixed**:
- Trading, chart e order book restano custom
- Ma outcomes, partecipanti, trade feed o altre sezioni esplorative con ricerca/filtri/ordinamento sono comunque list-like
- Se una sezione del detail richiede query, search, filter, sort o pagination, il motore corretto resta Filament

**Esempio corretto**:
```blade
@livewire(
    \Modules\Predict\Filament\Widgets\OutcomesTableWidget::class,
    ['predict' => $predict]
)
```

---

## 🚨 ERRORI DA EVITARE

### ❌ SBAGLIATO: Blade custom per superfici list-like nel DETAIL

```blade
@foreach($outcomes as $outcome)
    <div>{{ $outcome['title'] }}</div>
@endforeach
```

Perché è sbagliato:
- reimplementa o perde search/filter/sort
- la sezione outcomes è list-like anche se vive dentro un detail
- duplica il motore query tra widget e template

### ❌ SBAGLIATO: Custom Blade per LIST

```blade
@foreach($predicts as $predict)
    <div>{{ $predict->title }}</div>
@endforeach
```

Perché è sbagliato:
- niente search, filter, sorting
- niente pagination
- reinvenzione inutile del motore tabellare

---

## ✅ CORRETTO: Architettura Attuale

### Predict Detail Page
```text
URL: /it/predicts/f1-world-champion-2026
↓
Folio Route -> [container0]/[slug0]/index.blade.php
↓
Filament Widget: ViewPredictWidget
↓
Blade shell:
  - header
  - market stats
  - trading form
  - order book
  - chart
↓
Widget table Filament:
  - OutcomesTableWidget
```

---

## 🎯 MEMORIZZA

> **LIST-like** = Filament (search, filter, sort)  
> **Shell/detail/trading/chart** = Blade

Domande da farti PRIMA di codare:
- Questa sezione ha bisogno di search/filter/sort/pagination? -> Filament Table Widget
- Questa sezione è shell, hero, chart, trading, order book o contenuto narrativo? -> Blade Component
