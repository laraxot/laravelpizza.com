# XotBaseRelationManager per Laraxot PTVX

## Panoramica

Il componente `XotBaseRelationManager` è un'estensione della classe `RelationManager` di Filament che fornisce funzionalità aggiuntive specifiche per il framework Laraxot PTVX. Questa classe base deve essere estesa da tutti i RelationManager nei moduli Laraxot PTVX anziché estendere direttamente la classe di base Filament.

## Vantaggi di XotBaseRelationManager

- Integrazione con il trait `HasXotTable` per gestione avanzata delle tabelle
- Metodo `getModuleName()` per rilevare automaticamente il nome del modulo
- Gestione unificata dei form attraverso `getFormSchema()`
- Impostazione coerente delle azioni di tabella
- Forte tipizzazione per compatibilità con PHPStan livello 9

## Utilizzo Corretto

### Estensione della Classe

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Resources\NomeResource\RelationManagers;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class EsempioRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'nomeRelazione';
    
    protected static ?string $recordTitleAttribute = 'nome_attributo';
    
    // Resto dell'implementazione...
}
```

### Definizione dello Schema della Form

```php
/**
 * Definisce lo schema del form per la relazione.
 *
 * @return array<int, \Filament\Forms\Components\Component>
 */
public function getFormSchema(): array
{
    return [
        TextInput::make('nome_campo')
            ->label(trans('nomemodulo::relation.fields.nome_campo.label'))
            ->required(),
        // Altri campi...
    ];
}
```

### Definizione delle Colonne della Tabella

```php
/**
 * Definisce le colonne della tabella per la relazione.
 *
 * @return array<int, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        TextColumn::make('id'),
        TextColumn::make('nome_campo')
            ->label(trans('nomemodulo::relation.fields.nome_campo.label'))
            ->searchable(),
        // Altre colonne...
    ];
}
```

### Personalizzazione delle Azioni

```php
/**
 * Definisce le azioni disponibili per ogni record nella tabella.
 *
 * @return array<\Filament\Tables\Actions\Action>
 */
public function getTableActions(): array
{
    return [
        Tables\Actions\EditAction::make()
            ->label(trans('nomemodulo::relation.actions.edit.label')),
        Tables\Actions\DeleteAction::make()
            ->label(trans('nomemodulo::relation.actions.delete.label')),
        // Altre azioni...
    ];
}
```

## Metodi Principali

| Metodo | Tipo di Ritorno | Descrizione |
|--------|-----------------|-------------|
| `getModuleName()` | `string` | Determina automaticamente il nome del modulo in base al namespace |
| `form(Form $form)` | `Form` | Configura il form utilizzando getFormSchema() (final, non sovrascrivibile) |
| `getFormSchema()` | `array` | Definisce lo schema del form con componenti di input |
| `getTableActions()` | `array` | Definisce le azioni per ogni record nella tabella |
| `getTableBulkActions()` | `array` | Definisce le azioni bulk sulla tabella |
| `getTableHeaderActions()` | `array` | Definisce le azioni nell'header della tabella |
| `getTableFilters()` | `array` | Definisce i filtri disponibili nella tabella |
| `getResource()` | `string` | Restituisce la classe della risorsa collegata |

## Trait HasXotTable

Il trait `HasXotTable` fornisce funzionalità aggiuntive per la gestione delle tabelle, inclusi:

- Gestione standardizzata delle colonne
- Gestione degli stati delle colonne
- Formattazione uniforme dei dati
- Gestione avanzata dei filtri e delle ricerche

## Best Practices

1. **Sempre estendere XotBaseRelationManager**:
   ```php
   // ✅ CORRETTO
   class MioRelationManager extends XotBaseRelationManager
   
   // ❌ ERRATO
   class MioRelationManager extends RelationManager
   ```

2. **Dichiarare sempre la relazione**:
   ```php
   protected static string $relationship = 'nomeRelazione';
   ```

3. **Utilizzare le traduzioni per tutte le label**:
   ```php
   TextColumn::make('nome')
       ->label(trans('nomemodulo::relation.fields.nome.label'))
       
   // ❌ ERRATO
   TextColumn::make('nome')
       ->label('Nome')
   ```

4. **Definire esplicitamente i tipi di ritorno**:
   ```php
   /**
    * @return array<int, \Filament\Tables\Columns\Column>
    */
   public function getTableColumns(): array
   ```

5. **Utilizzare getTableColumns() anziché table()** per rispettare l'architettura di XotBaseRelationManager

6. **Non sovrascrivere mai il metodo form()** poiché è dichiarato come final

## File di Traduzione

Creare un file di traduzione dedicato per i RelationManager:

```php
// /Modules/NomeModulo/lang/it/relation.php
return [
    'fields' => [
        'nome_campo' => [
            'label' => 'Nome Campo',
            'help' => 'Descrizione del campo',
        ],
    ],
    'actions' => [
        'edit' => [
            'label' => 'Modifica',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
    ],
];
```

## Compatibilità PHPStan

Per garantire la compatibilità con PHPStan livello 9, assicurarsi di:

1. Utilizzare `declare(strict_types=1);` in tutti i file
2. Definire i tipi di ritorno per tutti i metodi
3. Documentare proprietà e metodi con PHPDoc completi
4. Utilizzare annotazioni di tipo generiche per gli array
5. Evitare l'uso del tipo `mixed` quando possibile

## Collegamenti alla Documentazione Correlata

- [Filament Resources](/laravel/Modules/Xot/docs/filament/resources.md)
- [HasXotTable Trait](/laravel/Modules/Xot/docs/filament/xot_table.md)
- [Regole di Traduzione](/laravel/Modules/Xot/docs/translation_rules.md)

*Ultimo aggiornamento: 3 Giugno 2025*