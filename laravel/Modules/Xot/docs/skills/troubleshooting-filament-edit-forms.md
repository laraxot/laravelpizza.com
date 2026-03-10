# Skill: Troubleshooting Filament Edit Forms in XotBaseManageRelatedRecords

## Contesto del Problema

Quando una pagina che estende `XotBaseManageRelatedRecords` non mostra il form di modifica, l'errore è quasi sempre dovuto alla **mancanza di `EditAction`** nel metodo `getTableActions()`.

## Sintomi Comuni

- URL tipo `/parent/{id}/relationship/{record_id}/edit` restituisce pagina vuota o errore
- Nessun pulsante "Modifica" nella tabella dei record correlati
- Form di modifica accessibile solo tramite URL diretto, non dalla pagina manage

## Diagnosi Rapida

1. **Verificare getTableActions()**: Controllare se include `EditAction::make()`
2. **Controllare Override**: Se la classe sovrascrive `getTableActions()`, verificare che includa tutte le azioni necessarie
3. **Routing Filament**: Assicurarsi che il `RelatedResource` abbia una pagina `edit`

## Pattern di Risoluzione

### ❌ Pattern Errato (Causa del Problema)

```php
class ManageRelatedRecords extends XotBaseManageRelatedRecords
{
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            // ❌ EditAction MANCANTE!
            'dissociate' => DissociateAction::make(),
            'delete' => DeleteAction::make(),
        ]);
    }
}
```

### ✅ Pattern Corretto

```php
use Filament\Actions\EditAction;
// ... altri use

class ManageRelatedRecords extends XotBaseManageRelatedRecords
{
    public function getTableActions(): array
    {
        return array_merge(parent::getTableActions(), [
            'edit' => EditAction::make(),  // ✅ OBBLIGATORIO
            'dissociate' => DissociateAction::make(),
            'delete' => DeleteAction::make(),
        ]);
    }
}
```

## Checklist di Troubleshooting

- [ ] `EditAction` presente in `getTableActions()`?
- [ ] Metodo `getTableActions()` sovrascritto correttamente?
- [ ] `RelatedResource` ha pagina `edit` abilitata?
- [ ] Autorizzazioni (policies) configurate correttamente?
- [ ] Form schema definito nel `RelatedResource`?

## Comandi di Verifica

```bash
# Verificare presenza EditAction
grep -r "EditAction::make()" Modules/*/Filament/Resources/*/Pages/Manage*.php

# Controllare pagine edit nel RelatedResource
grep -r "hasPage.*edit" Modules/*/Filament/Resources/*Resource.php
```

## Prevenzione

- **Checklist Pre-Commit**: Verificare presenza `EditAction` in tutte le classi `XotBaseManageRelatedRecords`
- **Test Automatici**: Aggiungere test che controllano presenza azioni richieste
- **Documentazione**: Aggiornare pattern documentati con esempi completi

## Errori Correlati Comuni

- `ViewAction` mancante per visualizzazione record
- `CreateAction` non funzionante per creazione record correlati
- Routing Filament non configurato correttamente

## Form vuoto sulla pagina Edit (nested resource)

Se la pagina Edit si apre (URL tipo `.../survey-pdfs/16/question-charts/230/edit`) ma **il form è vuoto** (nessun campo), la causa non è la mancanza di EditAction ma lo **schema del form**.

- La Edit usa sempre `Resource::form()` → `Resource::getFormSchema()`.
- Se la nested resource definisce i campi solo in un metodo “secondario” (es. `getFormSchemaBySurveyId($survey_id)`) e lascia `getFormSchema()` vuoto o con placeholder, Filament/Xot renderizzano uno schema vuoto → form vuoto in pagina.
- **Regola**: per le nested resource il form deve essere fornito da `getFormSchema()` della Resource (o dalla Page che override lo schema). Se lo schema dipende dal parent (es. survey_id), va recuperato il parent e usato nel flusso che costruisce lo schema (es. in getFormSchema() o nella pagina).

Vedi: [<nome progetto> – Perché il form Edit QuestionCharts è vuoto](../../<nome progetto>/docs/edit-question-chart-form-empty-cause.md).

## Backlinks

- [XotBaseManageRelatedRecords Pattern](../architecture/xot-base-manage-related-records-pattern.md)
- [<nome progetto> – Form Edit QuestionCharts vuoto](../../<nome progetto>/docs/edit-question-chart-form-empty-cause.md)
