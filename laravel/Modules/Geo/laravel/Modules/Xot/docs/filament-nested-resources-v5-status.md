# Filament Nested Resources: Stato in v5.x

## Scoperta Critica: Filament 5.x NON Supporta Nested Resources

Dopo analisi approfondita della documentazione ufficiale di Filament 5.x, **NON ESISTE supporto nativo per nested resources in Filament v5**.

### Cronologia delle Versioni

| Versione | Supporto Nested Resources |
|----------|---------------------------|
| Filament 3.x | ✅ Terze parti (sevendays-digital/filament-nested-resources) |
| Filament 4.x | ✅ Nativo (built-in) |
| **Filament 5.x** | ❌ **NON SUPPORTATO** |

### Terze Parti Disponibili (NON Compatibili con v5)

- **Guava Nested Resources**: "Not compatible with v5"
- **darmshot/filament-nested-resources**: Solo per v3.x
- **sevendays-digital/filament-nested-resources**: Solo per v3.x

### Soluzione Attuale del Progetto: XotBaseManageRelatedRecords

Il progetto utilizza **XotBaseManageRelatedRecords** come soluzione custom per gestire record correlati:

```php
class ManageCharts extends XotBaseManageRelatedRecords
{
    protected static string $resource = SurveyPdfResource::class;
    protected static string $relationship = 'chart';

    // Implementazione custom per survey context
}
```

### Pattern Architetturale: Manage vs Edit

| Contesto | Classe Base | Accesso Parent | Form Schema |
|----------|-------------|----------------|-------------|
| **Manage** (lista con azioni) | `XotBaseManageRelatedRecords` | `$this->getRecord()` | `getFormSchema()` istanza |
| **Edit** (pagina singola) | `XotBaseEditRecord` | `$this->record->parentRelationship` | `getFormSchema()` istanza |

### Problemi Identificati

1. **Form Vuoto in Edit Pages**: Le pagine Edit nested non sovrascrivono `getFormSchema()`, causando form vuoti
2. **Routing Non Standard**: URL tipo `/parent/16/child/230/edit` non sono gestite nativamente
3. **Context Parent Mancante**: Pagine Edit standalone non hanno accesso diretto al record parent

### Soluzioni Implementate

#### 1. Override getFormSchema() in Edit Pages

```php
class EditQuestionChart extends XotBaseEditRecord
{
    public function getFormSchema(): array
    {
        $surveyId = $this->getRecord()->survey_pdf_id;
        return QuestionChartResource::getFormSchemaBySurveyId($surveyId);
    }
}
```

#### 2. URL Dirette per Edit

```php
// Invece di URL nested, usa URL dirette
QuestionChartResource::getUrl('edit', ['record' => $chart]);
```

### Implicazioni per il Progetto

1. **XotBaseManageRelatedRecords è Essenziale**: Senza supporto nativo, questa classe custom è critica
2. **Edit Pages Richiedono Override**: Ogni pagina Edit nested deve sovrascrivere `getFormSchema()`
3. **Routing Limitato**: Non usare pattern URL `/parent/child/edit` - preferire URL dirette
4. **Context Management**: Gestire esplicitamente il passaggio del context parent

### Best Practices per Nested Resources in v5

1. **Usa XotBaseManageRelatedRecords** per gestione lista con azioni
2. **Override getFormSchema()** in tutte le pagine Edit nested
3. **Passa Context Parent** tramite metodi helper o stati
4. **Usa URL Dirette** invece di nested routing
5. **Documenta Dipendenze** tra risorse parent/child

### Documenti Correlati

- [XotBaseManageRelatedRecords Pattern](../../Xot/docs/architecture/xot-base-manage-related-records.md)
- [Errore Form Vuoto in Edit](../../<nome progetto>/docs/manage-charts-edit-form-error.md)
- [Filament v5 Migration Guide](../../Xot/docs/packages/laravel-12-filament-5-migration.md)
