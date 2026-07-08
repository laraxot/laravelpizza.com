# Pattern DRY+KISS: Infolist vs Form

## Regola Fondamentale

> **Infolist per visualizzazione, Form per modifica**

## Il Problema (Anti-pattern)

Usare `Form` con campi `->disabled()` o `->readOnly()` per visualizzare dati in sola lettura:

```php
// ❌ ERRATO - Anti-pattern
protected function getFormSchema(): array
{
    return [
        Section::make('Informazioni Generali')
            ->schema([
                TextInput::make('matr')
                    ->label('Matricola')
                    ->disabled(), // Anti-pattern!
                TextInput::make('cognome')
                    ->label('Cognome')
                    ->disabled(), // Anti-pattern!
            ]),
    ];
}
```

**Perché è sbagliato:**
1. Aggiunge overhead di validazione/form non necessario
2. Non semantico (componenti input usati per sola visualizzazione)
3. Più codice da mantenere
4. Complessità inutile

## La Soluzione (Pattern corretto)

Usare `Infolist` per visualizzazione read-only e `Form` solo per campi modificabili:

```php
<?php

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;

class CompilaIndennitaResponsabilita extends XotBasePage
{
    // ...

    /**
     * Infolist per visualizzare dati in sola lettura.
     * Separazione di responsabilità: Infolist per view, Form per input.
     */
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->getSpecificRecord())
            ->schema([
                InfolistSection::make('Informazioni Generali')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('matr')
                            ->label('Matricola'),
                        TextEntry::make('cognome')
                            ->label('Cognome'),
                        TextEntry::make('nome')
                            ->label('Nome'),
                        TextEntry::make('perc_p_time_year')
                            ->label('P.Time %')
                            ->formatStateUsing(fn (float $state): string => number_format($state * 100, 2).' %'),
                    ]),
            ]);
    }

    /**
     * Form SOLO per campi modificabili.
     * Rimuovere le 'Informazioni Generali' da qui.
     */
    protected function getFormSchema(): array
    {
        return [
            Section::make('Valutazioni Anno '.($this->record->anno ?? 2025))
                ->schema($this->getRatingsSchema()),

            Section::make('Riepilogo Calcoli')
                ->columns(4)
                ->schema([
                    TextInput::make('tot_score')
                        ->label('Punteggio Totale')
                        ->readOnly()
                        ->extraInputAttributes(['class' => 'bg-gray-100 font-bold text-lg']),
                    // ... altri campi calcolati
                ]),
        ];
    }
}
```

## Vantaggi del Pattern

1. **DRY**: Ogni componente fa ciò per cui è progettato
2. **KISS**: Codice più semplice e semantico
3. **Separazione di Responsabilità**: Infolist per view, Form per input
4. **Performance**: Meno overhead di validazione
5. **Manutenibilità**: Cambiamenti isolati

## Checklist Implementazione

- [ ] Identificare campi read-only nel Form
- [ ] Creare metodo `infolist()` con schema appropriato
- [ ] Rimuovere campi read-only dal `getFormSchema()`
- [ ] Usare `TextEntry` invece di `TextInput::make()->disabled()`
- [ ] Verificare layout con `->columns()`

## Componenti Infolist Comuni

| Infolist | Form Equivalente |
|----------|------------------|
| `TextEntry` | `TextInput::make()` |
| `ImageEntry` | `FileUpload::make()` |
| `IconEntry` | `Toggle::make()` |
| `ColorEntry` | `ColorPicker::make()` |
| `ListEntry` | `Repeater::make()` |

## Collegamenti

- [docs/DRY-KISS-PATTERNS.md](./DRY-KISS-PATTERNS.md)
- [docs/PHPSTAN-LEVEL10.md](./PHPSTAN-LEVEL10.md)
- [Filament Infolist Docs](https://filamentphp.com/docs/5.x/infolists/overview)
