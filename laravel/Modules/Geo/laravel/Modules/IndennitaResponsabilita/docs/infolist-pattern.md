# Infolist Pattern per Readonly Fields

## Overview

Per i campi di sola lettura nelle pagine Filament, usare **Infolist** invece di form fields con `disabled()`. Questo garantisce:
- Separazione di responsabilità (Infolist per view, Form per input)
- Migliore performance (nessun form processing per dati readonly)
- Più semantico (distingue tra visualizzazione e input)

## Implementazione in CompilaIndennitaResponsabilita

### 1. Aggiungere i trait e interface

```php
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;

class CompilaIndennitaResponsabilita extends XotBasePage implements HasInfolists
{
    use InteractsWithInfolists;
    // ...
}
```

### 2. Implementare il metodo infolist()

```php
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

public function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->record($this->record)
        ->schema([
            InfolistSection::make('Informazioni Generali')
                ->columns(4)
                ->schema([
                    TextEntry::make('matr'),
                    TextEntry::make('cognome'),
                    TextEntry::make('nome'),
                    TextEntry::make('perc_p_time_year')
                        ->formatStateUsing(fn (?float $state): string => number_format(($state ?? 0) * 100, 2).' %'),
                ]),
        ]);
}
```

### 3. Aggiornare il form schema

Rimuovere i campi readonly dal form e tenere solo i campi editabili:

```php
protected function getFormSchema(): array
{
    return [
        // NON includere più i campi disabled per le info generali
        Section::make('Valutazioni Anno')
            ->schema($this->getRatingsSchema()),
        // ...
    ];
}
```

### 4. Aggiornare la view

```blade
<div class="space-y-6">
    {{ $this->infolist }}
    {{ $this->form }}
    <!-- ... -->
</div>
```

## Vantaggi

1. **Performance**: Infolist è più leggero per dati readonly
2. **Manutenzione**: Codice più pulito e separato
3. **Semantic**: Distingue chiaramente tra view e edit
4. **DRY**: Logica di visualizzazione separata da quella di input

## Regola

> **Per i campi di sola lettura, usare Infolist invece di form disabled**

Questa regola è documentata in `.gemini/GEMINI.md`.
