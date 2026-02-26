# Metodi da NON implementare in classi che estendono XotBaseResource

## Regola fondamentale

Le classi che estendono `XotBaseResource` **NON DEVONO MAI** implementare i seguenti metodi:

### Metodi di tabella
- ❌ `getTableColumns()`
- ❌ `getTableFilters()`
- ❌ `getTableActions()`
- ❌ `getTableBulkActions()`
- ❌ `getNavigationGroup()`

### Metodi di form e navigazione
- ❌ `form(Form $form): Form`
- ❌ `table(Table $table): Table`
- ❌ `getPages()` (se contiene solo route standard)
- ❌ `getRelations()` (se restituisce un array vuoto)

## Motivazione architetturale

Questi metodi sono già implementati in `XotBaseResource` e forniscono funzionalità standard ottimizzate per il progetto. Sovrascriverli:

1. **Rompe l'astrazione**: La classe base fornisce un'implementazione standardizzata
2. **Duplica il codice**: Porta a duplicazione non necessaria e difficoltà di manutenzione
3. **Riduce la coerenza**: Crea incoerenze nell'interfaccia utente e nel comportamento
4. **Complica gli aggiornamenti**: Rende più difficile aggiornare il comportamento a livello di sistema

## Pattern corretto

```php
class ProductResource extends XotBaseResource
{
    protected static ?string $model = Product::class;

    // UNICI metodi che dovrebbero essere implementati
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required(),
            // Altri campi...
        ];
    }

    // Solo se è necessario personalizzare la query
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
```

## Casi eccezionali

L'implementazione di questi metodi è giustificata **SOLO** in casi rari ed eccezionali, quando:

1. È necessario un comportamento radicalmente diverso da quello standard
2. Il comportamento non può essere ottenuto attraverso altre configurazioni
3. Il team di sviluppo ha esplicitamente approvato questa eccezione

## Verifica automatica

Prima di ogni commit, verificare che le risorse Filament non contengano metodi proibiti:

```bash

# Cerca implementazioni non necessarie
grep -r "public static function getTableColumns" --include="*Resource.php" /var/www/html/base_<nome progetto>/laravel/Modules/
grep -r "public static function getTableFilters" --include="*Resource.php" /var/www/html/base_<nome progetto>/laravel/Modules/
grep -r "public static function getTableActions" --include="*Resource.php" /var/www/html/base_<nome progetto>/laravel/Modules/
grep -r "public static function getTableBulkActions" --include="*Resource.php" /var/www/html/base_<nome progetto>/laravel/Modules/
grep -r "public static function getNavigationGroup" --include="*Resource.php" /var/www/html/base_<nome progetto>/laravel/Modules/
```

## Processo di refactoring

Se questi metodi sono trovati in una classe esistente:

1. Rimuovere completamente il metodo se il comportamento è standard
2. Se contiene personalizzazioni critiche, discutere con il team come ottenere lo stesso risultato usando meccanismi standard
3. Documentare qualsiasi eccezione con commenti dettagliati che spiegano perché è necessaria
