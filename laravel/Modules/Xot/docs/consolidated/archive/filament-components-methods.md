# Metodi dei Componenti Filament

## Tabs e Tab Components

### ⚠️ Errore Comune: Metodo `description()`
Il metodo `description()` non esiste per `Filament\Forms\Components\Tabs\Tab`. Questo è un errore comune quando si confonde con altri componenti Filament che supportano descrizioni.

#### ❌ Codice Errato
```php
use Filament\Forms\Components\Tabs;

Tabs\Tab::make('tab_name')
    ->description('Questa descrizione causerà un errore') // Errore: metodo non esiste
```

#### ✅ Codice Corretto
```php
use Filament\Forms\Components\Tabs;

Tabs\Tab::make('tab_name')
    ->icon('heroicon-o-user')
    // Usare Section all'interno del Tab per aggiungere una descrizione
    ->schema([
        Forms\Components\Section::make()
            ->description('Descrizione del tab')
            ->schema([
                // componenti del form
            ])
    ])
```

### Metodi Disponibili per Tab

1. **Metodi Base**
   ```php
   Tab::make('name')
      ->label('Label del Tab')
      ->icon('heroicon-o-user')
      ->badge('1')
      ->schema([])
   ```

2. **Metodi di Stato**
   ```php
   Tab::make('name')
      ->visible(fn() => true)
      ->disabled(fn() => false)
      ->statePath('tab_state')
   ```

3. **Metodi di Validazione**
   ```php
   Tab::make('name')
      ->validate('required')
      ->rules(['min:3'])
   ```

### Best Practices

1. **Struttura Raccomandata**
   ```php
   Tabs::make('group')
       ->tabs([
           Tab::make('tab1')
               ->icon('heroicon-o-user')
               ->schema([
                   Section::make()
                       ->description('Descrizione qui')
                       ->schema([
                           // componenti
                       ])
               ])
       ])
   ```

2. **Gestione Descrizioni**
   - Usare `Section` dentro il tab per descrizioni
   - Mantenere le descrizioni nei file di traduzione
   - Usare `helperText()` per suggerimenti sui campi

3. **Organizzazione**
   - Un tab per area logica
   - Mantenere la consistenza tra tabs simili
   - Usare icone intuitive

## Note Importanti

1. **Documentazione Ufficiale**
   - Consultare sempre la documentazione Filament aggiornata
   - Verificare i metodi disponibili per ogni versione
   - Non assumere che i metodi di un componente siano disponibili per altri

2. **Debugging**
   - Controllare i metodi disponibili nell'IDE
   - Verificare la versione di Filament in uso
   - Testare i componenti prima del deploy

## Collegamenti
- [Filament Forms Documentation](https://filamentphp.com/project_docs/forms)
- [Tabs Component](https://filamentphp.com/project_docs/forms/layout#tabs)
- [Best Practices](filament-best-practices.md) 