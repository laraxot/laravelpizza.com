---
title: "Skill: Crea Filament Page (ListRecords/Create/Edit)"
type: "skill"
tags: [filament, xotbase, page, listrecords, skill]
module: "Xot"
created: 2026-05-12
updated: 2026-05-12
---

# Skill — Crea Filament Page

> Procedura on-demand per creare correttamente una Page Filament in un modulo Laraxot.

## Trigger

Usa questa skill quando: crei una `ListRecords`, `CreateRecord`, `EditRecord`, `ViewRecord` page.

## Step

### 1. Estendi sempre XotBase (MAI Filament direttamente)

```php
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListStoredEvents extends XotBaseListRecords
{
    // $resource è OPZIONALE se il namespace segue la convenzione
    // XotBaseListRecords::getResource() lo risolve automaticamente via:
    // Str::of(static::class)->before('\\Pages\\')
}
```

### 2. `$resource` — `protected static`, non `public static`

```php
// ✅ Solo se serve override esplicito
protected static string $resource = StoredEventResource::class;

// ❌ SBAGLIATO
public static string $resource = StoredEventResource::class;
```

### 3. `getTableColumns()` — `array<string, Column>`

```php
public function getTableColumns(): array
{
    return [
        'id'          => TextColumn::make('id')->sortable(),
        'event_class' => TextColumn::make('event_class')->searchable(),
        'created_at'  => TextColumn::make('created_at')->dateTime(),
    ];
}
```

### 4. NO `->label()` — gestito da LangServiceProvider

```php
// ❌ VIETATO
TextColumn::make('id')->label('ID')

// ✅ CORRETTO
TextColumn::make('id')->sortable()
```

## Mapping completo Pages

| Page type | Estende |
|-----------|---------|
| List | `XotBaseListRecords` |
| Create | `XotBaseCreateRecord` |
| Edit | `XotBaseEditRecord` |
| View | `XotBaseViewRecord` |

## Checklist

- [ ] Estende `XotBase*` non `Filament\*`
- [ ] `$resource` dichiarato `protected static string` (se presente)
- [ ] `getTableColumns()` ritorna `array<string, Column>` con chiavi stringa
- [ ] Nessun `->label()` nei campi
- [ ] `declare(strict_types=1)` in cima al file

## Vedi anche

- [filament-resource-property](../../../../../docs/wiki/rules/filament-resource-property.md)
- [xotbase-critical-rules](../../../../../docs/wiki/rules/xotbase-critical-rules.md)
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md)
