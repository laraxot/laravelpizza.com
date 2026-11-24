---
title: Glossario di dominio Xot
type: glossary
owner: Xot
updated: 2026-11-24
qmd: "xot glossario XotBase Action QueueableAction XotBaseMigration XotBaseResource XotBaseServiceProvider HasXotTable XotData tableUpdate base class"
---

# Glossario di dominio Xot

Xot è il modulo delle classi base: gli altri moduli lo estendono, non lo usano. I termini sono quelli del framework, non del dominio HR/PA (per quelli vedi i glossari dei moduli owner). Ogni riga è stata verificata con `rg` su `laravel/Modules/Xot/app` il 2026-11-24; se glossario e codice divergono vale il codice.

| Termine | Significato | Nel codice |
|---|---|---|
| XotBase* | Famiglia di classi astratte che ogni modulo estende al posto delle classi Filament/Laravel dirette. Cambiarne la firma ha effetto su tutti i moduli consumatori. | [contracts/xotbase-classes.md](contracts/xotbase-classes.md); `Modules\Xot\Filament\...`, `Modules\Xot\Models\...` |
| XotBaseResource | Base delle Resource Filament; estende `Filament\Resources\Resource`. `getFormSchema()` è `final` qui e va dichiarato sulla classe Form. | `app/Filament/Resources/XotBaseResource.php` |
| XotBaseResourceForm | Classe che porta lo schema del form di una Resource; `getFormSchema()` è astratto. | `app/Filament/Resources/Schemas/XotBaseResourceForm.php` |
| XotBaseResourceTable | Classe che porta tabella e colonne di una Resource; compone il trait `HasXotTable`. | `app/Filament/Resources/Tables/XotBaseResourceTable.php` |
| HasXotTable | Trait che costruisce la tabella Filament; il metodo astratto `getTableColumns()` elenca le colonne. | `app/Filament/Traits/HasXotTable.php` |
| XotBaseListRecords | Base delle pagine di elenco di una Resource. | `app/Filament/Resources/Pages/XotBaseListRecords.php` |
| XotBasePage | Base delle pagine Filament dei moduli (esiste anche una variante in `Filament/Resources/Pages`). | `app/Filament/Pages/XotBasePage.php` |
| XotBaseRelationManager | Base dei RelationManager di una Resource. | `app/Filament/Resources/RelationManagers/XotBaseRelationManager.php` |
| XotBaseWidget, XotBaseSchemaWidget | Basi dei Widget Filament; la seconda aggiunge lo schema di form (`getFormSchema()`). Sono l'unica superficie interattiva ammessa al posto di Livewire standalone (ADR 0008). | `app/Filament/Widgets/XotBaseWidget.php`, `app/Filament/Widgets/XotBaseSchemaWidget.php` |
| XotBaseSection, XotBaseSelect | Componenti di form riusabili: estendono `Section` e `Select` di Filament. | `app/Filament/Schemas/Components/XotBaseSection.php`, `app/Filament/Forms/Components/XotBaseSelect.php` |
| XotBaseModel | Base dei modelli Eloquent dei moduli. | `app/Models/XotBaseModel.php` |
| XotBasePolicy | Base delle Policy di autorizzazione. | `app/Models/Policies/XotBasePolicy.php` |
| XotBaseServiceProvider | Base del provider di un modulo: registra traduzioni, config, componenti Blade e comandi del modulo. | `app/Providers/XotBaseServiceProvider.php` |
| XotBaseRouteServiceProvider | Base del provider delle route di un modulo. | `app/Providers/XotBaseRouteServiceProvider.php` |
| Entrypoint route vuoto | File `routes/*.php` dei moduli senza route proprie; delega a un file canonico che restituisce un array vuoto (ADR route-entrypoints-canonical-empty). | `routes/empty.php` |
| XotBaseMigration | Base delle migrazioni: ricava il modello dal nome del file (`getModelClass()`) e offre `tableCreate()` e `tableUpdate()`. Una migrazione per modello, solo avanti. | `app/Database/Migrations/XotBaseMigration.php` |
| Action (QueueableAction) | Unità di business: una classe con `use QueueableAction` e metodo `execute()`, richiamabile in modo sincrono o accodato. Sostituisce i Service per la logica nuova (ADR 0001, 0002). Xot ne ha 238 in `app/Actions`. | `app/Actions/**`, esempio `Actions/Arr/SavePhpArrayAction.php` |
| SavePhpArrayAction | Action che scrive un array PHP su file con una chiave per riga, senza array annidati inline. | `app/Actions/Arr/SavePhpArrayAction.php` |
| XotData | Dati di configurazione dell'applicazione (config tenant `xra`), ottenuti come istanza condivisa con `XotData::make()`. | `app/Datas/XotData.php`, `app/Actions/Config/GetTenantConfigArrayAction.php` |
| XotBaseTestCase | Base dei test Pest dei moduli; il TestCase si lega in ogni file di test (ADR 0007). | `tests/XotBaseTestCase.php` |
