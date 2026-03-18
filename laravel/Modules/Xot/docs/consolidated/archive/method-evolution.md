# Evoluzione dei metodi in XotBaseResource

## Metodi deprecati vs attuali

La struttura di `XotBaseResource` è evoluta nel tempo. Alcuni metodi sono stati rinominati o deprecati per allinearsi meglio con le convenzioni di Filament.

### Metodi deprecati vs correnti

| Metodo deprecato | Metodo attuale | Note |
|------------------|---------------|------|
| `getListTableColumns()` | `getTableColumns()` | Il metodo per definire le colonne della tabella è stato rinominato per maggiore coerenza |
| `getListTableFilters()` | `getTableFilters()` | Il metodo per definire i filtri della tabella è stato rinominato |
| `getListTableActions()` | `getTableActions()` | Il metodo per definire le azioni della tabella è stato rinominato |
| `getListTableBulkActions()` | `getTableBulkActions()` | Il metodo per definire le azioni bulk è stato rinominato |

## ⚠️ Importante: Non implementare questi metodi

Le classi che estendono `XotBaseResource` **NON DEVONO MAI** implementare nessuno dei seguenti metodi:

- ❌ `getTableColumns()`
- ❌ `getTableFilters()`
- ❌ `getTableActions()`
- ❌ `getTableBulkActions()`
- ❌ `getNavigationGroup()`

Inoltre, non devono implementare i metodi deprecati:

- ❌ `getListTableColumns()`
- ❌ `getListTableFilters()`
- ❌ `getListTableActions()`
- ❌ `getListTableBulkActions()`

## Motivazione

Questi metodi sono già implementati in `XotBaseResource` e `XotBaseListRecords` con il comportamento ottimale per il progetto. Sovrascriverli:

1. Rompe il pattern di astrazione
2. Duplica inutilmente il codice
3. Introduce potenziali incoerenze
4. Complica la manutenzione e gli aggiornamenti

## Pattern corretto

```php
class ProductResource extends XotBaseResource
{
    protected static ?string $model = Product::class;

    // UNICO metodo che dovrebbe essere implementato
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required(),
            // Altri campi...
        ];
    }
}
```

## Identificazione di codice obsoleto

Se trovi nel progetto implementazioni di `getListTableColumns()` o metodi simili, questi dovrebbero essere aggiornati ai loro equivalenti moderni, o preferibilmente rimossi del tutto se seguono semplicemente il comportamento standard.
