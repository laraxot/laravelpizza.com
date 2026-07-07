# Regola `getPages()` ridondante su `XotBaseResource`

## Scopo

Le risorse che estendono `XotBaseResource` **non devono** dichiarare `getPages()` quando il metodo ripete solo il CRUD standard (`index`, `create`, `edit`) già fornito dalla classe base.

**Motivazione (DRY + KISS):** la base risolve automaticamente le classi Page dal nome della Resource; duplicare lo stesso array in ogni modulo aumenta rumore, rischio di drift e manutenzione inutile.

## Come funziona la discovery in `XotBaseResource`

Implementazione: `Modules/Xot/app/Filament/Resources/XotBaseResource.php` → `getPages()`.

| Variabile | Derivazione | Esempio `CoeffResource` | Esempio `AssenzeResource` |
| :--- | :--- | :--- | :--- |
| `$name` | basename classe senza suffisso `Resource` | `Coeff` | `Assenze` |
| `$plural` | `Str::plural($name)` | `Coeffs` | `Assenzes` |
| List | `{Namespace}\Pages\List{$plural}` | `ListCoeffs` | `ListAssenzes` |
| Create | `{Namespace}\Pages\Create{$name}` | `CreateCoeff` | `CreateAssenze` |
| Edit | `{Namespace}\Pages\Edit{$name}` | `EditCoeff` | `EditAssenze` |
| View (opz.) | `{Namespace}\Pages\View{$name}` | solo se la classe esiste | idem |

Route registrate:

- `index` → `/`
- `create` → `/create`
- `edit` → `/{record}/edit`
- `view` → `/{record}` (solo se esiste `View{name}`)

## Quando **rimuovere** `getPages()`

Tutte le condizioni devono essere vere:

1. La Resource estende `XotBaseResource`.
2. L'override contiene **solo** le chiavi `index`, `create`, `edit` (nessuna `view`, nessuna pagina custom).
3. Le classi Page nel namespace `{Resource}\Pages\` seguono **esattamente** la convenzione della tabella sopra (nomi file e classi inclusi).

```php
// ✅ CORRETTO — nessun getPages() nella Resource
class CoeffResource extends XotBaseResource
{
    protected static ?string $model = Coeff::class;

    public static function getFormSchema(): array
    {
        return [ /* ... */ ];
    }
}
```

Le Page devono esistere con i nomi attesi, ad esempio:

- `CoeffResource/Pages/ListCoeffs.php`
- `CoeffResource/Pages/CreateCoeff.php`
- `CoeffResource/Pages/EditCoeff.php`

## Quando **mantenere** `getPages()`

| Caso | Motivo |
| :--- | :--- |
| Pagina `view` esplicita nel override | La base aggiunge `view` solo se trova `View{name}`; un override con chiavi diverse va mantenuto finché non si allinea la convenzione |
| Pagine custom (`compila`, `manage-*`, report, ecc.) | Route non generabili dalla convenzione standard |
| Solo `index` (o subset) | La base registra sempre index/create/edit; serve override se mancano Create/Edit |
| **Naming Page non allineato** | Es. Resource `AssenzeResource` ma Page `ListAssenza` / `CreateAssenza` — la base cerca `ListAssenzes`, `CreateAssenze` |

### Esempio Progressioni: `AssenzeResource` (override obbligatorio oggi)

```php
// Necessario finché le Page non seguono ListAssenzes / CreateAssenze / EditAssenze
public static function getPages(): array
{
    return [
        'index' => Pages\ListAssenza::route('/'),
        'create' => Pages\CreateAssenza::route('/create'),
        'edit' => Pages\EditAssenza::route('/{record}/edit'),
    ];
}
```

**Due modi per eliminare l'override:**

1. Rinominare le Page alla convenzione (`ListAssenzes`, `CreateAssenze`, `EditAssenze`), oppure
2. Rinominare la Resource in `AssenzaResource` (plural `Assenzas` → valutare coerenza con modello e traduzioni).

### Esempio Progressioni: `CoeffResource` (override rimovibile)

Analisi: le Page sono `ListCoeffs`, `CreateCoeff`, `EditCoeff` — allineate alla base. Il metodo `getPages()` nella Resource è ridondante.

## Verifica automatica

Script di analisi (non modifica file):

```bash
cd laravel
php ../bashscripts/filament/analyze-redundant-getpages.php
```

Output:

- `SAFE_TO_REMOVE` — override solo index/create/edit e Page con naming corretto
- `MUST_KEEP` — view, pagine extra, naming errato, o chiavi non standard
- `NO_GETPAGES_OVERRIDE` — già conforme (nessun override)

## Anti-pattern

```php
// ❌ Ridondante: copia esatta di ciò che fa già XotBaseResource
public static function getPages(): array
{
    return [
        'index' => Pages\ListCoeffs::route('/'),
        'create' => Pages\CreateCoeff::route('/create'),
        'edit' => Pages\EditCoeff::route('/{record}/edit'),
    ];
}
```

```php
// ❌ Rimuovere getPages() senza allineare le Page — Filament non trova le classi
// Resource: AssenzeResource, Page: ListAssenza (manca ListAssenzes)
```

## Checklist refactor

- [ ] Eseguire lo script di analisi sulla Resource target
- [ ] Se `SAFE_TO_REMOVE`, eliminare `getPages()` e verificare rotte Filament (list/create/edit)
- [ ] Se `MUST_KEEP` per naming, pianificare rename Page o Resource prima di rimuovere l'override
- [ ] Non toccare Resource con `view` o pagine custom senza migrare le route

## Collegamenti

- [xotbaseresource.md](./xotbaseresource.md)
- [resources/architecture/forbidden-methods.md](./resources/architecture/forbidden-methods.md)
- [../filament-resource-rules.md](../filament-resource-rules.md)
- [../../consolidated/filament/resources/xot-base-resource.md](../../consolidated/filament/resources/xot-base-resource.md)
- [Progressioni — getPages e naming](../../../Progressioni/docs/filament-resource-getpages-naming.md)
- [Themes One — schemas/tables](../../../../Themes/One/docs/filament-resource-schemas-tables.md)
- Script: [analyze-redundant-getpages.php](../../../../bashscripts/filament/analyze-redundant-getpages.php)

*Ultimo aggiornamento: giugno 2025*
