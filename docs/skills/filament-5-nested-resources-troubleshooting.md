# Skill: Troubleshooting Nested Resources in Filament 5.x

## Contesto Critico: Filament 5.x NON Supporta Nested Resources

**PRIMA REGOLA**: Non cercare nested resources nella documentazione Filament 5.x - **NON ESISTONO**.

### Versioni Filament e Nested Resources

| Versione | Supporto Nested | Soluzione |
|----------|-----------------|-----------|
| v3.x | ❌ Terze parti | sevendays-digital/filament-nested-resources |
| v4.x | ✅ Nativo | Built-in nested resources |
| **v5.x** | ❌ **NON SUPPORTATO** | Usa XotBaseManageRelatedRecords |

## Pattern Corretto per Filament 5.x

### 1. Usa XotBaseManageRelatedRecords per Gestione Relazioni

```php
class ManageChildRecords extends XotBaseManageRelatedRecords
{
    protected static string $resource = ParentResource::class;
    protected static string $relationship = 'children';

    // CRITICO: Aggiungi EditAction manualmente
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            'edit' => EditAction::make(), // NON automatico in v5
            'view' => ViewAction::make(),
            'dissociate' => DissociateAction::make(),
        ]);
    }
}
```

### 2. Override getFormSchema() in Edit Pages

Poiché nested routing non esiste, le Edit pages devono gestire il context parent:

```php
class EditChildRecord extends XotBaseEditRecord
{
    // CRITICO: Override necessario per form contestuali
    public function getFormSchema(): array
    {
        $parentId = $this->getRecord()->parent_id;
        return ChildResource::getFormSchemaByParentId($parentId);
    }
}
```

### 3. Usa URL Dirette Invece di Nested

```php
// NON USARE: URL nested (non esistono in v5)
// /parent/123/child/456/edit

// USARE: URL dirette della risorsa child
$editUrl = ChildResource::getUrl('edit', ['record' => $childRecord]);
```

## Diagnosi Problemi Comuni

### Sintomo: "Form vuoto in edit"

**Causa**: Edit page non sovrascrive `getFormSchema()`

**Soluzione**:
```php
class EditChild extends XotBaseEditRecord
{
    public function getFormSchema(): array
    {
        $parentId = $this->getRecord()->parent_relationship_id;
        return ChildResource::getFormSchemaByParentId($parentId);
    }
}
```

### Sintomo: "Route not found per /parent/child/edit"

**Causa**: Nested routing non supportato in v5

**Soluzione**: Usa URL dirette o implementa routing custom

### Sintomo: "EditAction non visibile nella tabella"

**Causa**: Classe non aggiunge EditAction a getTableActions()

**Soluzione**: Aggiungi esplicitamente EditAction

## Checklist Implementazione

### Per ManageRelatedRecords
- [ ] Estende XotBaseManageRelatedRecords
- [ ] Ha $resource e $relationship configurati
- [ ] Override getTableActions() con EditAction
- [ ] Testa azioni tabella funzionanti

### Per Edit Pages
- [ ] Override getFormSchema() se form contestuale
- [ ] Gestisce accesso a record parent
- [ ] Usa URL dirette invece di nested

### Per Resources
- [ ] Metodo static getFormSchemaByParentId() se necessario
- [ ] Form schema contestuale funzionante

## Comandi Troubleshooting

```bash
# Verifica versione Filament
composer show filament/filament

# Cerca nested resources nella codebase
grep -r "nested" Modules/*/Filament/

# Verifica EditAction in Manage classes
grep -r "EditAction::make" Modules/*/Filament/Resources/*/Pages/Manage*.php
```

## Errori da Evitare

1. **Cercare nested resources in doc v5**: Non esistono
2. **Aspettarsi EditAction automatico**: Deve essere aggiunto manualmente
3. **Usare URL pattern `/parent/child/edit`**: Non supportato
4. **Form vuoti senza override**: Override getFormSchema() necessario

## Backlinks

- [Stato Nested Resources v5](../../filament-nested-resources-v5-status.md)
- [XotBaseManageRelatedRecords Pattern](../../architecture/xot-base-manage-related-records.md)
- [Errore Form Vuoto](../../Quaeris/docs/manage-charts-edit-form-error.md)
