# 🎨 Filament Forms & Tables Philosophy

**Part of**: [00-INDEX.md](00-INDEX.md) — AI Agents Coordination  
**Related**: [03-ARCHITECTURE-ZEN.md](03-ARCHITECTURE-ZEN.md) — Architecture

---

## 🔴 Fundamental Rule

**NEVER create custom forms or tables in blade.**

**ALWAYS use Filament Widgets:**
- ✅ Form → Filament Form Widget
- ✅ Table/Grid → Filament Table Widget

---

## 🧠 Philosophy (The WHY)

### 1. **Don't Repeat Yourself (DRY)**

**❌ WRONG**:
```blade
{{-- Custom form in blade --}}
<form action="/submit" method="POST">
    <input type="text" name="title">
    <button>Submit</button>
</form>

{{-- Custom table in blade --}}
<table>
    @foreach($items as $item)
    <tr>
        <td>{{ $item->title }}</td>
    </tr>
    @endforeach
</table>
```

**✅ CORRECT**:
```php
// Filament Widget
class ContactFormWidget extends Widget
{
    use InteractsWithForms;
    
    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')->required(),
        ]);
    }
}

class ItemsTableWidget extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Item::query())
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
            ])
            ->filters([...])
            ->paginated([12, 24, 48]);
    }
}
```

**Why**:
- Form Filament handles: validation, sanitization, errors automatically
- Table Filament handles: search, filters, sorting, pagination automatically
- **One definition** → used everywhere (back office, front office)

---

### 2. **Convention Over Configuration**

Filament knows what to do by default:

```php
// ✅ Filament already knows
TextColumn::make('title')
    ->sortable()      // Adds sorting
    ->searchable()    // Adds search with 400ms debounce
    ->toggleable();   // Allows show/hide

// No need to write:
// - SQL for sorting
// - WHERE for search
// - JavaScript for toggle
// - HTML for UI
```

**Why**:
- Less code to write
- Fewer bugs to fix
- Consistency across project
- Automatic updates (Filament improves, you do nothing)

---

### 3. **Eloquent-First Design**

Filament is designed to **work with Eloquent**.

**❌ WRONG**:
```blade
{{-- Manual query in blade --}}
@php
    $items = DB::table('predicts')
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
@endphp

@foreach($items as $item)
    <div>{{ $item->title }}</div>
@endforeach
```

**✅ CORRECT**:
```php
// Filament Table Widget
public function table(Table $table): Table
{
    return $table
        ->query(Predict::query()->where('status', 'active'))
        ->columns([
            TextColumn::make('title')->sortable()->searchable(),
        ])
        ->filters([
            SelectFilter::make('status')
                ->options(['active' => 'Active', 'closed' => 'Closed']),
        ]);
}
```

**Why**:
- Eloquent handles relationships, mutators, accessors automatically
- Filament uses Eloquent for optimized queries (eager loading)
- Less manual SQL → less SQL injection risk

---

### 4. **Livewire-Powered (Reactive)**

Filament uses **Livewire** for reactivity without JavaScript.

```php
// ✅ Real-time search (no manual AJAX)
TextColumn::make('title')->searchable()

// ✅ Sorting with click (no JavaScript)
TextColumn::make('created_at')->sortable()

// ✅ Reactive filters (no form submit)
SelectFilter::make('category')
    ->options(Category::all()->pluck('name', 'id'))
```

**Why**:
- Better UX (no page reload)
- Less JavaScript code
- Everything in PHP (same language)

---

### 5. **Feature-Rich Out of the Box**

Filament includes **by default** features you'd implement manually:

| Feature | Custom Blade | Filament |
|---------|--------------|----------|
| Search | ❌ Implement | ✅ `searchable()` |
| Sorting | ❌ Implement | ✅ `sortable()` |
| Filters | ❌ Implement | ✅ `filters()` |
| Pagination | ❌ Implement | ✅ `paginated()` |
| Bulk Actions | ❌ Implement | ✅ `bulkActions()` |
| Export | ❌ Implement | ✅ `ExportAction::make()` |
| Reordering | ❌ Implement | ✅ `reorderable()` |
| Polling | ❌ Implement | ✅ `poll('10s')` |

**Why**:
- Save weeks of development
- Tested and optimized features
- Automatically updated

---

## 📋 WHEN TO USE

### ✅ USE Filament Widget When:

1. **Forms**:
   - ✅ Contact forms
   - ✅ Registration forms
   - ✅ Data edit forms
   - ✅ Advanced search forms
   - ✅ Multi-step wizards

2. **Tables/Grids**:
   - ✅ Eloquent record lists
   - ✅ Dashboard with data
   - ✅ Admin panel CRUD
   - ✅ Lists with search/filters
   - ✅ Tables with actions

3. **Dashboard**:
   - ✅ Stats cards (`StatsOverviewWidget`)
   - ✅ Charts (`ChartWidget`)
   - ✅ Recent activity (`TableWidget`)
   - ✅ KPI overview

### ❌ DON'T USE Filament When:

1. **Custom Layout**:
   - ❌ Landing page with unique design
   - ❌ Masonry grid (Pinterest-style)
   - ❌ Cards with complex layout
   - ❌ Non-tabular visualizations

2. **Public-Facing Pages**:
   - ❌ Public homepage (use blade components)
   - ❌ Marketing pages
   - ❌ Blog post layout

3. **Non-Eloquent Data**:
   - ❌ API responses
   - ❌ Aggregated stats (use Stats Widget)
   - ❌ Third-party data

---

## 🚨 Common Mistakes

### 1. ❌ Custom Form in Blade

```blade
{{-- WRONG --}}
<form wire:submit="save">
    <input wire:model="title">
    <button>Save</button>
</form>
```

**✅ CORRECT**:
```php
use InteractsWithForms;

public function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('title')->required(),
    ]);
}
```

---

### 2. ❌ Custom Table in Blade

```blade
{{-- WRONG --}}
<div class="grid grid-cols-3">
    @foreach($items as $item)
    <div>{{ $item->title }}</div>
    @endforeach
</div>
```

**✅ CORRECT**:
```php
public function table(Table $table): Table
{
    return $table->columns([
        TextColumn::make('title'),
    ]);
}
```

---

### 3. ❌ Manual Search/Filters

```blade
{{-- WRONG --}}
<form method="GET">
    <input name="search">
    <select name="category">...</select>
    <button>Filter</button>
</form>
```

**✅ CORRECT**:
```php
->filters([
    SelectFilter::make('category')
        ->relationship('category', 'title'),
])
```

---

## ✅ Code Review Checklist

Before approving a PR:

### Forms
- [ ] ✅ Used Filament Form Widget (NOT custom blade)
- [ ] ✅ Used `InteractsWithForms` trait
- [ ] ✅ Implemented `HasForms` interface
- [ ] ✅ Schema defined in `form()` method
- [ ] ✅ Validation with Filament validators
- [ ] ✅ `getState()` to get validated data
- [ ] ✅ `mount()` to initialize form
- [ ] ✅ Notifications with `Filament\Notifications`

### Tables
- [ ] ✅ Extended `TableWidget`
- [ ] ✅ Eloquent query (NOT `DB::table`)
- [ ] ✅ Columns with `sortable()` and `searchable()`
- [ ] ✅ Filters with `filters()`
- [ ] ✅ Actions with `actions()`
- [ ] ✅ Pagination with `paginated()`
- [ ] ✅ Labels for columns (i18n)

### Dashboard
- [ ] ✅ Stats with `StatsOverviewWidget`
- [ ] ✅ Charts with `ChartWidget`
- [ ] ✅ Tables with `TableWidget`
- [ ] ✅ Shared filters (dashboard-wide)
- [ ] ✅ Responsive (grid columns)

---

## 🔗 Related Documentation

- **Architecture Zen**: [03-ARCHITECTURE-ZEN.md](03-ARCHITECTURE-ZEN.md)
- **Front Office Audit**: [05-FRONT-OFFICE-AUDIT.md](05-FRONT-OFFICE-AUDIT.md)
- **External**: https://filamentphp.com/docs/5.x/tables/overview

---

**Last Updated**: 2026-03-20  
**Status**: ✅ Mandatory  
**Enforcement**: PHPStan + Code Review
