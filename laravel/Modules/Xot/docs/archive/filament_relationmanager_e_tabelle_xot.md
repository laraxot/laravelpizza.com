# Linee Guida per RelationManager e Tabelle Personalizzate Xot in Filament

Questa documentazione descrive come implementare e configurare i `RelationManager` e le loro tabelle all'interno dell'ecosistema PTVX/Laraxot, utilizzando le classi base e i trait forniti dal modulo `Xot`.

## `XotBaseRelationManager`: La Base per i Tuoi Relation Manager

Tutti i `RelationManager` personalizzati **devono** estendere `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager`. Questa classe base fornisce fondamenta robuste e integrazioni specifiche di Xot.

### Caratteristiche Principali di `XotBaseRelationManager`

1.  **Estensione Standard**: Deriva da `Filament\Resources\RelationManagers\RelationManager`.
2.  **Proprietà Obbligatoria `static::$resourceClass`**:
    -   Ogni `RelationManager` deve specificare a quale `XotBaseResource` è collegato.
    -   Esempio: `protected static string $resourceClass = MioResource::class;`
    -   Questa proprietà è validata per assicurare che la classe esista e sia un'istanza di `XotBaseResource`.
3.  **Definizione dello Schema del Form con `getFormSchema()`**:
    -   Il metodo `form()` è `final`. Per definire i campi del form (utilizzato per creare/modificare record relazionati), devi implementare il metodo `getFormSchema(): array`.
    -   Esempio:
        ```php
        public function getFormSchema(): array
        {
            return [
                Forms\Components\TextInput::make('nome_campo')
                    ->label(__('path.to.translation.nome_campo'))
                    ->required(),
                // ... altri campi
            ];
        }
        ```
4.  **Integrazione con `HasXotTable` Trait**: La maggior parte delle funzionalità della tabella è fornita da questo trait (vedi sezione dedicata sotto).

## `HasXotTable` Trait: Potenziare le Tabelle Filament

Il trait `Modules\Xot\Filament\Traits\HasXotTable` è utilizzato da `XotBaseRelationManager` (e anche da `XotBaseResource`) per fornire una configurazione di tabella arricchita e standardizzata.

### Funzionalità Chiave di `HasXotTable`

1.  **Traduzioni (`TransTrait`)**: Supporto integrato per la traduzione di etichette, titoli, notifiche, ecc. Fare sempre riferimento ai file di lingua.
2.  **Layout Tabella Configurabile (`TableLayoutEnum`)**:
    -   Proprietà `$layoutView` (default `TableLayoutEnum::LIST`).
    -   Azione `TableLayoutToggleTableAction` aggiunta automaticamente per permettere all'utente di cambiare layout (es. da lista a griglia, se configurato).
3.  **Azioni Predefinite e Personalizzabili**:
    -   **Header Actions (`getTableHeaderActions`)**:
        -   `CreateAction` di default.
        -   `AssociateAction` e `AttachAction` condizionali (controllate da `shouldShowAssociateAction()` e `shouldShowAttachAction()` che puoi sovrascrivere).
        -   `TableLayoutToggleTableAction`.
    -   **Row Actions (`getTableActions`)**:
        -   Raggruppate in `ActionGroup`.
        -   Include `ViewAction` (se `static::$canView` è true), `EditAction` (se `static::$canEdit` è true), `DetachAction`, `DissociateAction`, `DeleteAction`.
        -   `ReplicateAction` (se `static::$canReplicate` è true).
    -   **Bulk Actions (`getTableBulkActions`)**:
        -   `DeleteBulkAction`.
        -   `ForceDeleteBulkAction` e `RestoreBulkAction` se il modello usa `SoftDeletes`.
    -   Puoi sovrascrivere questi metodi per aggiungere o modificare azioni. Ricorda di usare `->label(__('...'))` per le traduzioni.
4.  **Gestione Colonne Flessibile**:
    -   Implementa `getCustomColumns(): array` nella tua classe `XotBaseRelationManager` per definire le colonne specifiche della tua relazione.
        ```php
        // In XotBaseRelationManager
        protected function getCustomColumns(): array
        {
            return [
                Tables\Columns\TextColumn::make('nome_attributo_relazione')
                    ->label(__('path.to.translation.nome_attributo_relazione'))
                    ->searchable()
                    ->sortable(),
                // ... altre colonne custom
            ];
        }
        ```
    -   **Colonne di Default**: `HasXotTable` aggiunge automaticamente:
        -   `id` (configurabile tramite `getIdColumn()`).
        -   `created_at`, `updated_at` (configurabili, vedi `getTimestampColumns()`).
        -   Colonne `pivot` per relazioni `BelongsToMany` (configurabili tramite `getPivotColumns()`).
5.  **Filtri Standard e Personalizzati**:
    -   `TrashedFilter` aggiunto automaticamente se il modello usa `SoftDeletes`.
    -   Implementa `getCustomFilters(): array` per aggiungere i tuoi filtri.
        ```php
        // In XotBaseRelationManager
        protected function getCustomFilters(): array
        {
            return [
                // Tables\Filters\SelectFilter::make('status')
                //    ->options(...)
                //    ->label(__('...'))
            ];
        }
        ```
6.  **Ricerca Preconfigurata**:
    -   Abilitata di default (`hasSearch()` restituisce `true`).
    -   Colonne ricercabili di default: `id`, `name`. Puoi sovrascrivere `getSearchableColumns(): array`.
7.  **Controllo Esistenza Tabella Database**:
    -   Se la tabella associata al modello non esiste, viene mostrata una notifica persistente e una tabella vuota per prevenire errori.
8.  **Ordinamento di Default**: Per `id` discendente (configurabile tramite `getDefaultSort()`).

### Esempio di Implementazione Base di un `XotBaseRelationManager`

```php
<?php

namespace Modules\MioModulo\Filament\Resources\MioResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Modules\MioModulo\Filament\Resources\MioResource; // Assicurati sia un XotBaseResource
use Modules\MioModulo\Models\RelatedModel; // Il modello della relazione

class MioRelatedRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'nomeDellaRelazioneDefinitiaNelModelloPadre';

    // Obbligatorio: specifica la classe XotBaseResource a cui questo RelationManager è associato
    protected static string $resourceClass = MioResource::class; 

    // (Opzionale) Titolo del Relation Manager (verrà tradotto)
    // protected static ?string $title = 'mia_relazione_manager.title'; 

    // (Opzionale) Etichetta per il record (verrà tradotto)
    // protected static ?string $recordTitleAttribute = 'nome_attributo_del_related_model';

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make(static::trans('related_model.field.name')) // Esempio di traduzione
                ->label(static::trans('related_model.field.name.label'))
                ->required()
                ->maxLength(255),
        ];
    }

    protected function getCustomColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make(static::trans('related_model.field.name'))
                 ->label(static::trans('related_model.field.name.label'))
                ->searchable()
                ->sortable(),
            // Aggiungi qui altre colonne specifiche per RelatedModel
        ];
    }

    // (Opzionale) Per personalizzare le azioni di riga
    // protected function getTableActions(): array
    // {
    //     return array_merge(parent::getTableActions(), [
    //         // Aggiungi azioni custom o modifica quelle esistenti
    //     ]);
    // }

    // (Opzionale) Per personalizzare le azioni nell'header
    // protected function getTableHeaderActions(): array
    // {
    //    return array_merge(parent::getTableHeaderActions(), [
    //        // Tables\Actions\CreateAction::make()->label(static::trans('actions.create')),
    //    ]);
    // }
}
```

## Buone Pratiche

-   **Traduzioni**: Utilizza sempre `static::trans('...')` o `__('...')` per tutte le stringhe visibili all'utente (label, titoli, notifiche, ecc.) come definito in `TransTrait`.
-   **Specificità**: Definisci `getCustomColumns()` e `getCustomFilters()` per adattare la tabella alle esigenze specifiche della relazione.
-   **Minimale ma Completo**: Sovrascrivi solo ciò che è necessario. Molte funzionalità sono già fornite dalla classe base e dal trait.
-   **Coerenza**: Mantieni la coerenza con le altre implementazioni di Filament nel progetto.

---
*Vedi anche: [Regole Generali Filament nel Modulo Xot](./filament_best_practices.md)* (Assumendo che esista o verrà creato un file del genere)
*Vedi anche: [Documentazione Ufficiale Filament](https://filamentphp.com/docs/3.x/relations/overview)* (Per concetti base di Filament)
