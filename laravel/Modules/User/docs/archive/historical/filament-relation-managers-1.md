# Filament Relation Managers nel Modulo User

## Struttura dei Relation Managers

I Relation Managers nel modulo User devono seguire una struttura specifica che estende le classi base di Xot.

### TeamsRelationManager

Gestisce la relazione tra Users e Teams.

```php
use Modules\Xot\Filament\RelationManagers\XotBaseRelationManager;

class TeamsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'teams';

    // ...
}
```

## Metodi Principali

### Configurazione Tabella

I metodi di configurazione della tabella devono seguire queste regole:

1. Non devono essere statici
2. Non devono usare il metodo `->label()`
3. Devono affidarsi al sistema di traduzione automatico

```php
class TeamsRelationManager extends XotBaseRelationManager
{
    // CORRETTO: senza ->label()
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('personal_team')
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    // ERRATO: non usare ->label() o metodi statici
    public static function getTableColumns(): array // ❌
    {
        return [
            TextColumn::make('name')
                ->label('Nome'), // ❌ Non usare ->label()
        ];
    }
}
```

## Sistema di Traduzione

### Struttura File di Traduzione

Le traduzioni devono essere organizzate nei file di lingua del modulo:

```php
// lang/it/teams.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del team',
            'helper_text' => 'Nome identificativo del team',
        ],
        'personal_team' => [
            'label' => 'Team Personale',
            'helper_text' => 'Indica se questo è un team personale',
        ],
    ],
];
```

### Come Funziona

1. Il LangServiceProvider gestisce automaticamente le traduzioni
2. Le chiavi di traduzione sono generate automaticamente basandosi su:
   - Nome del modulo
   - Nome della risorsa
   - Nome del campo

### Errori Comuni

1. **Uso di ->label()**
   ```php
   // ❌ ERRATO: Non usare ->label()
   TextColumn::make('name')->label('Nome')

   // ✅ CORRETTO: Lasciare che il sistema gestisca la traduzione
   TextColumn::make('name')
   ```

2. **Metodi Statici**
   ```php
   // ❌ ERRATO: Non usare metodi statici
   public static function getTableColumns()

   // ✅ CORRETTO: Usare metodi di istanza
   public function getTableColumns()
   ```

## Best Practices

1. Mai usare il metodo `->label()`
2. Definire tutte le traduzioni nei file di lingua
3. Mantenere una struttura coerente nei file di traduzione
4. Usare i metodi di istanza per la configurazione
5. Seguire le convenzioni di naming per le chiavi di traduzione

## Configurazione Corretta

```php
namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\RelationManagers\XotBaseRelationManager;

class TeamsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'teams';

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('personal_team')
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    public function getTableActions(): array
    {
        return [
            ViewAction::make(),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }
}
```

## Note Aggiuntive

- Non usare mai `->label()` nei componenti Filament
- Tutte le etichette devono essere gestite tramite i file di traduzione
- Il LangServiceProvider gestisce automaticamente le traduzioni
- Mantenere una struttura coerente in tutti i RelationManager

## Riferimenti

- [Documentazione Filament RelationManager](https://filamentphp.com/docs/tables#relation-managers)
- [XotBaseRelationManager](../Xot/docs/filament-relation-managers.md)
- [Sistema di Traduzione](../Xot/docs/translation-system.md)
- [Best Practices Filament](../Xot/docs/filament-best-practices.md)
