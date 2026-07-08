# Compila Page Systematization Pattern

## Overview
The `Compila` page is a specialized evaluation interface built with Filament. The goal of systematization is to provide a clean, reactive, and type-safe experience following the "Super Mucca" methodology.

## Key Principles
- **Unified Form**: All record information (header + body + summary) exists within the Filament `$form` schema.
- **Infolist for Metadata**: Use Filament Infolists for read-only metadata (e.g., Worker details) to separate visualization from active form state.
- **Live Reactivity**: Real-time calculations using `live()` on fields and `recalculateReadonlyFields` on state updates.
- **Type Safety**: Full PHPStan Level 10 compliance using explicit type narrowing (`getSpecificRecord()`).

## Architecture Implementation

### 1. Type-Safe Record Access
To satisfy PHPStan Level 10 when using `InteractsWithRecord`, use a helper method:

```php
protected function getSpecificRecord(): IndennitaResponsabilita
{
    if (! $this->record instanceof IndennitaResponsabilita) {
        throw new \LogicException('Record is missing or invalid.');
    }

    return $this->record;
}
```

### 2. Form Schema Structure
Organize the page into logical sections:
- **Infolist Section**: Worker metadata (Read-Only).
- **Valutazioni Section**: Dynamic input fields for ratings.
- **Riepilogo Calcoli Section**: Real-time calculated summary.

### 2. Infolist Implementation
Implement `HasInfolists` and define the schema:

```php
public function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->record($this->getSpecificRecord())
        ->schema([
            Section::make('Informazioni Generali')
                ->columns(4)
                ->schema([
                    TextEntry::make('matr')->label('Matricola'),
                    TextEntry::make('cognome')->label('Cognome'),
                    TextEntry::make('nome')->label('Nome'),
                    TextEntry::make('perc_p_time_year')
                        ->label('P.Time %')
                        ->formatStateUsing(fn ($state) => number_format((float) $state * 100, 2) . ' %'),
                ]),
        ]);
}
```

### 3. Form Schema Structure
The form now only contains the evaluations and summary:

```php
protected function getFormSchema(): array
{
    return [
        Section::make('Valutazioni')->schema($this->getRatingsSchema()),
        Section::make('Riepilogo Calcoli')->columns(4)->schema([...]),
    ];
}
```

### 3. Reactive Logic
Use `recalculateReadonlyFields` to update summary fields whenever a rating changes:

```php
$item->live(onBlur: true)
    ->afterStateUpdated(function (Set $set, Get $get) use (&$readonlyFields): void {
        $this->recalculateReadonlyFields($set, $get, $readonlyFields);
    });
```

## Benefits
- **KISS**: Reduces Blade HTML overhead.
- **DRY**: Logic is centralized in the Livewire component.
- **SOLID**: Clear separation of schema definition and calculation logic.
