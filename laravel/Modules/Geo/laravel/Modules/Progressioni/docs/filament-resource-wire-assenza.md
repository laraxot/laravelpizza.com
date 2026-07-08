# Wire manuale — AssenzaResource (pilota fase 3, **non ancora applicato**)

## Scopo

Collegare `AssenzaResource` e `ListAssenzas` alle classi `AssenzaForm` / `AssenzasTable` create in fase 2, **senza** cambiare il comportamento runtime finché la delega non è verificata.

**Regola durante la conversione:** finché la fase 3 non è esplicitamente completata per una risorsa, **`AssenzaResource.php` e `ListAssenzas.php` restano la sorgente operativa** (schema inline). Le classi `AssenzaForm` / `AssenzasTable` contengono solo la **copia** prodotta in fase 2 e non sostituiscono il runtime.

**Resource:** `AssenzaResource`  
**List page:** `ListAssenzas` (estende `PtvBaseYearListRecords`)

## Prerequisiti

- Fase 2 completata: `AssenzaForm`, `AssenzaInfolist`, `AssenzasTable` presenti e allineate al codice inline
- Smoke test su list/create/edit della risorsa

## Passi (da applicare manualmente)

### 1. Verifica equivalenza

Confrontare `AssenzaForm::getFormSchema()` con `AssenzaResource::getFormSchema()` e `AssenzasTable::getTableColumns()` con `ListAssenzas::getTableColumns()`. Devono essere equivalenti prima di delegare.

### 2. Delega form su AssenzaResource

```php
use Modules\Progressioni\Filament\Resources\AssenzaResource\Schemas\AssenzaForm;

public static function getFormSchema(): array
{
    return app(AssenzaForm::class)->getFormSchema();
}
```

### 3. Delega colonne su ListAssenzas

```php
use Modules\Progressioni\Filament\Resources\AssenzaResource\Tables\AssenzasTable;

public function getTableColumns(): array
{
    return app(AssenzasTable::class)->getTableColumns();
}
```

### 4. Pulizia AssenzasTable — solo colonne

Non aggiungere `getTableFilters()` in `AssenzasTable` se il filtro anno è già su `PtvBaseYearListRecords`. `getTableFilters()` nella Table non deve referenziare `$this->yearFieldName` (proprietà della List page).

## Stato file (pilota)

| File | Stato |
| :--- | :--- |
| `AssenzaResource.php` | ❌ schema inline (sorgente attiva) |
| `ListAssenzas.php` | ❌ colonne inline (sorgente attiva) |
| `Schemas/AssenzaForm.php` | ✅ copia fase 2 |
| `Tables/AssenzasTable.php` | ✅ copia fase 2 (solo colonne) |

## Collegamenti

- [filament-resource-schemas-tables.md](./filament-resource-schemas-tables.md)
- [filament-resource-getpages-naming.md](./filament-resource-getpages-naming.md)
