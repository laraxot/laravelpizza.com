# Pattern Filament v5: Infolist vs Form

## Cambiamenti in Filament v5

In Filament v5, l'architettura Infolist è stata significativamente modificata:

### ❌ Anti-pattern (NON usare più)
```php
// NON fare questo - Pattern Filament v4
use Filament\Infolists\Components\Section; // NON ESISTE PIÙ

public function infolist(Schema $schema): Schema
{
    return $schema
        ->record($this->record)
        ->components([
            Section::make('Titolo') // ERRORE: Class not found
                ->components([...])
        ]);
}
```

### ✅ Pattern Corretto (Filament v5)
```php
<?php

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class CompilaIndennitaResponsabilita extends XotBasePage
{
    /**
     * Get the infolist schema for displaying read-only information.
     * 
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    protected function getInfolistSchema(): array
    {
        return [
            'informazioni_generali' => Section::make('Informazioni Generali')
                ->columns(4)
                ->schema([
                    'matr' => TextEntry::make('matr')
                        ->label('Matricola'),
                    'cognome' => TextEntry::make('cognome')
                        ->label('Cognome'),
                    'nome' => TextEntry::make('nome')
                        ->label('Nome'),
                    'perc_p_time_year' => TextEntry::make('perc_p_time_year')
                        ->label('P.Time %')
                        ->formatStateUsing(fn (float $state): string => number_format($state * 100, 2).' %'),
                ]),
            
            'riepilogo_calcoli' => Section::make('Riepilogo Calcoli')
                ->columns(4)
                ->schema([
                    'tot_score' => TextEntry::make('tot_score')
                        ->label('Punteggio Totale'),
                    'mensile_calcolato' => TextEntry::make('mensile_calcolato')
                        ->label('Mensile Calcolato'),
                ]),
        ];
    }
    
    /**
     * Form SOLO per campi editabili.
     */
    protected function getFormSchema(): array
    {
        return [
            'valutazioni' => Section::make('Valutazioni')
                ->schema($this->getRatingsSchema()),
        ];
    }
}
```

## Differenze Chiave Filament v5

| Aspetto | Filament v4 | Filament v5 |
|---------|-------------|-------------|
| **Metodo infolist** | `infolist(Infolist $infolist)` | `getInfolistSchema(): array` |
| **Section class** | `Filament\Infolists\Components\Section` | `Filament\Schemas\Components\Section` |
| **Struttura** | `->schema([...])` con entries | Array associativo con string keys |
| **Entries** | `TextEntry`, `ImageEntry`, etc. | `TextEntry`, `ImageEntry`, etc. (stessi nomi) |
| **Import Section** | Da Infolists | Da Schemas |

## Regola DRY+KISS

> **Infolist per visualizzazione, Form per modifica**

### Vantaggi:
1. **DRY**: Ogni componente fa ciò per cui è progettato
2. **KISS**: Codice semplice e semantico
3. **Separazione responsabilità**: Infolist per view, Form per input
4. **Performance**: Meno overhead di validazione

## Componenti Infolist Disponibili

- `TextEntry` - Visualizza testo
- `ImageEntry` - Visualizza immagini
- `IconEntry` - Visualizza icone
- `ColorEntry` - Visualizza colori
- `KeyValueEntry` - Visualizza array chiave-valore
- `RepeatableEntry` - Visualizza liste ripetibili
- `Actions` - Azioni inline

## Checklist Implementazione

- [ ] Usare `getInfolistSchema()` invece di `infolist()`
- [ ] Importare `Section` da `Filament\Schemas\Components`
- [ ] Importare entries da `Filament\Infolists\Components`
- [ ] Usare array associativo con string keys
- [ ] Rimuovere campi read-only dal Form
- [ ] Verificare con PHPStan Level 10

## Collegamenti

- [docs/DRY-KISS-PATTERNS.md](./DRY-KISS-PATTERNS.md)
- [docs/PHPSTAN-LEVEL10.md](./PHPSTAN-LEVEL10.md)
- [Filament v5 Docs](https://filamentphp.com/docs/5.x/infolists/overview)
