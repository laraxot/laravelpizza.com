# Regola Critica: getTableColumns e getTableFilters — chiavi stringhe obbligatorie

## Regola Fondamentale

I metodi `getTableColumns()` e `getTableFilters()` **DEVONO SEMPRE** restituire array con chiavi di tipo **stringa**, mai con indici numerici.

**MAI usare `table()`** nelle classi concrete — solo in `HasXotTable` (final).

## Tipo di Ritorno Corretto

```php
/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        'name' => TextColumn::make('name'),
        'email' => TextColumn::make('email'),
        'created_at' => TextColumn::make('created_at'),
    ];
}
```

## Tipo di Ritorno ERRATO

```php
/**
 * @return array<int, Column>  // ❌ ERRATO: chiavi numeriche
 */
public function getTableColumns(): array
{
    return [
        TextColumn::make('name'),    // ❌ ERRATO: nessuna chiave stringa
        TextColumn::make('email'),   // ❌ ERRATO: nessuna chiave stringa
    ];
}
```

## Motivazione

1. **Filament Schema Processing**: Filament si aspetta colonne con chiavi stringhe per identificazione e gestione del ciclo di vita
2. **XotBase Architecture**: L'architettura Laraxot impone questo pattern per coerenza
3. **PHPStan Compliance**: La tipizzazione corretta è necessaria per PHPStan livello 10
4. **Component Identification**: L'identificazione delle colonne dipende dalle chiavi stringhe

## getTableFilters — stessa regola

```php
/**
 * @return array<string, \Filament\Tables\Filters\Filter>
 */
public function getTableFilters(): array
{
    return [
        'search_contacts' => Filter::make('search_contacts')->query(...),
    ];
}
```

## Applicazione

Questa regola si applica a:
- `XotBaseRelationManager::getTableColumns()`
- `XotBaseTableWidget::getTableColumns()`
- `XotBaseListRecords::getTableColumns()`
- `XotBaseManageRelatedRecords::getTableColumns()`
- Tutte le implementazioni concrete di `getTableColumns()` in RelationManager, Widget Table, Resource Pages

## Collegamenti

- [filament-array-keys-rule](../filament-array-keys-rule.md)
- [array-keys-filament-methods](../array-keys-filament-methods.md)
- [no-table-override](no-table-override.md)
- [.cursor/rules/gettablecolumns-string-keys.mdc](../../../../.cursor/rules/gettablecolumns-string-keys.mdc)

---

*
