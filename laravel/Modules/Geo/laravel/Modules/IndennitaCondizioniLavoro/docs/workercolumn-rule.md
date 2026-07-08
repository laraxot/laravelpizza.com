# Regola: WorkerColumn in Filament Tables

## Principio Fondamentale

**MAI sostituire colonne custom/generic con colonne specifiche individuali.**

La `WorkerColumn` è una colonna custom che raggruppa informazioni del lavoratore (matricola, cognome, nome, email) in un'unica colonna. Questo pattern è usato in tutto il progetto per mantenere coerenza e DRY.

## ⚠️ IMPORTANTE: WorkerColumn è una GroupColumn, NON una relazione!

**WorkerColumn estende `GroupColumn`** da `Modules\UI\Filament\Tables\Columns\GroupColumn`. Questo significa che:
- Raggruppa campi dello **stesso record** (matr, cognome, nome, email)
- Non è una relazione a un altro modello
- È puramente un pattern UI/UX per DRY e KISS

### Ereditarietà
```
WorkerColumn → GroupColumn → Column
```

## Esempio Corretto

```php
use Modules\Ptv\Filament\Columns\WorkerColumn;

public function getTableColumns(): array
{
    return [
        'lavoratore' => WorkerColumn::make('lavoratore'),
        TextColumn::make('stabi')->searchable(),
        TextColumn::make('repar')->searchable(),
        // ... altre colonne
    ];
}
```

## Esempio ERRATO (NON FARE)

```php
// ❌ SBAGLIATO - Non sostituire WorkerColumn con colonne individuali
public function getTableColumns(): array
{
    return [
        TextColumn::make('matr')->searchable(),      // ❌ Violazione DRY/KISS
        TextColumn::make('cognome')->searchable(),   // ❌
        TextColumn::make('nome')->searchable(),     // ❌
        // ...
    ];
}
```

## Motivazione

1. **DRY (Don't Repeat Yourself)**: La WorkerColumn centralizza la logica di visualizzazione del lavoratore
2. **Coerenza**: Tutte le tabelle mostrano le informazioni del lavoratore nello stesso modo
3. **Manutenibilità**: Se cambia il formato, si modifica solo la WorkerColumn
4. **Performance**: Una sola colonna invece di tre riduce il carico di rendering
5. **User Experience**: Layout consistente per l'utente finale

## Quando usare WorkerColumn

- Sempre quando si deve mostrare informazioni del lavoratore in una tabella
- In tutti i moduli che estendono XotBaseListRecords
- Quando il record ha i campi matr, cognome, nome, email

## Location

- **File**: `Modules/Ptv/app/Filament/Columns/WorkerColumn.php`
- **Namespace**: `Modules\Ptv\Filament\Columns\WorkerColumn`
- **Extends**: `Modules\UI\Filament\Tables\Columns\GroupColumn`

## Collegamenti

- [WorkerColumn Source](../../../../../Ptv/app/Filament/Columns/WorkerColumn.php)
- [Root Documentation](../../../../../../docs/WORKERCOLUMN-RULE.md)
