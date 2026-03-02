# HasXotForm: form() DEVE essere final

## Regola critica

Il metodo `form()` nel trait `HasXotForm` **DEVE** essere `final`. Non è consentito rimuoverlo o renderlo overridabile.

Le classi che usano `HasXotForm` (es. `XotBaseManageRelatedRecords`, widget, pagine) **devono adattarsi** implementando `getFormSchema()` invece di fare override di `form()`.

## Motivazione

1. **Single source of truth**: La logica di costruzione del form (columns, statePath, ecc.) vive in un solo punto
2. **Coerenza**: Tutte le classi seguono lo stesso pattern `getFormSchema()`
3. **Manutenibilità**: Modifiche a columns, statePath o layout si fanno solo in HasXotForm
4. **Prevenzione errori**: Evita override che rompono il binding Livewire o lo statePath

## Pattern corretto

```php
// ✅ CORRETTO: implementare getFormSchema()
class ManageQuestionCharts extends XotBaseManageRelatedRecords
{
    public function getFormSchema(): array
    {
        return [
            'question' => TextInput::make('question'),
            'chart_type' => TextInput::make('chart_type'),
        ];
    }
}
```

## Anti-pattern

```php
// ❌ ERRATO: override di form() — genera "Cannot override final method"
class ManageQuestionCharts extends XotBaseManageRelatedRecords
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([...]);
    }
}
```

## Classi interessate

- `XotBaseManageRelatedRecords` (usa HasXotForm)
- `XotBaseRelationManager` (form() final analogo)
- Widget che usano HasXotForm
- Pagine Filament che usano il trait

## Collegamenti

- [HasXotForm trait](../app/Filament/Traits/HasXotForm.php)
- [filament-relation-managers](../../../.cursor/rules/filament-relation-managers.mdc)
- [final-method-override rule](../../../.cursor/rules/final-method-override.md)
