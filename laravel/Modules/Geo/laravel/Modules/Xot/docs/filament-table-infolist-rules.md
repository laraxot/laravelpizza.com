# Filament Table & Infolist Rules

## Regole per Table e Infolist in Laraxot

### 1. Array Non Vuoto Obbligatorio

**Regola**: I metodi `getTableColumns()` e `getInfolistSchema()` NON devono mai ritornare un array vuoto.

**Motivo**: Un array vuoto non ha senso in un contesto UI - non mostra nessun dato all'utente.

**Errore Comune**:
```php
// SBAGLIATO - genera InvalidArgumentException
public static function getTableColumns(): array
{
    return [];
}
```

**Corretto**:
```php
// CORRETTO - basato sui campi reali del Model
public static function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')->sortable(),
        'name' => TextColumn::make('name')->searchable(),
    ];
}
```

### 2. Validazione Automatica

La classe base `XotBaseResourceTable` lancia un'eccezione se le columns sono vuote:

```php
if (empty($columns)) {
    throw new \InvalidArgumentException(
        '['.static::class.'::getTableColumns()] cannot return an empty array. '
        .'Study the related Model and Migration to determine the real columns.'
    );
}
```

### 3. Studiare Model e Migration

Prima di implementare Table o Infolist:
1. Leggere il **Model** per conoscere `$fillable`, `$casts`, e relazioni
2. Leggere la **Migration** per conoscere le colonne reali del database
3. NON inventare mai campi - usare solo campi esistenti

**Esempio - Model Log**:
```php
// modules/Xot/app/Models/Log.php
protected $fillable = ['id', 'name', 'size'];
```

**Table Corretta**:
```php
public static function getTableColumns(): array
{
    return [
        'name' => TextColumn::make('name')->searchable()->sortable(),
        'size' => TextColumn::make('size')->sortable(),
    ];
}
```

### 4. Sintassi Array - Virgole Non Puntini

**ERRORE COMUNE**: Usare punto e virgola (`;`) invece di virgola (`,`) dopo i metodi encadenati.

```php
// SBAGLIATO - syntax error
'started_at' => TextEntry::make('started_at')
    ->dateTime();
'finished_at' => TextEntry::make('finished_at')
    ->dateTime();
```

```php
// CORRETTO - virgola come separatore
'started_at' => TextEntry::make('started_at')
    ->dateTime(),
'finished_at' => TextEntry::make('finished_at')
    ->dateTime(),
```

### 5. Chiavi Array Stringhe

Le chiavi degli array devono essere stringhe:

```php
// CORRETTO
return [
    'id' => TextColumn::make('id')->sortable(),
    'name' => TextColumn::make('name')->searchable(),
];

// SBAGLIATO - chiavi intere
return [
    0 => TextColumn::make('id'),
    1 => TextColumn::make('name'),
];
```

### 6. Struttura Directory

```
Modules/[Module]/app/Filament/Resources/[Resource]/
├── [Resource]Resource.php       # Resource principale
├── Schemas/
│   ├── [Resource]Form.php       # Schema del form
│   └── [Resource]Infolist.php  # Schema dell'infolist
└── Tables/
    └── [Resource]Table.php     # Table configuration
```

### 7. Metodi Opzionali

I seguenti metodi possono ritornare array vuoti (sono opzionali):
- `getTableFilters()` - filtri della tabella
- `getTableActions()` - azioni sulla riga
- `getTableBulkActions()` - azioni bulk

Solo `getTableColumns()` e `getInfolistSchema()` sono obbligatori.

## File Corretti di Esempio

### LogsTable (Xot Module)
```php
class LogsTable extends XotBaseResourceTable
{
    public static function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'size' => TextColumn::make('size')
                ->sortable()
                ->formatStateUsing(fn (int $state): string => number_format($state) . ' bytes'),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
```

### NotificationsTable (Notify Module)
```php
class NotificationsTable extends XotBaseResourceTable
{
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'type' => TextColumn::make('type')->sortable(),
            'status' => TextColumn::make('status')->sortable(),
            'read_at' => TextColumn::make('read_at')->dateTime()->sortable(),
            'sent_at' => TextColumn::make('sent_at')->dateTime()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
```

## Errori Corretti

- `ImportInfolist.php` - punto e virgola dopo `->dateTime()`
- `JobManagerInfolist.php` - 2 punti e virgola dopo `->dateTime()`
- `JobsWaitingInfolist.php` - 2 punti e virgola dopo `->dateTime()`
- `LogsTable.php` - array vuoto popolato con campi reali del model Log
- `TeamUsersTable.php` - array vuoto popolato con campi reali del model TeamUser