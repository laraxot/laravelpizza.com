# Pattern XotBaseManageRelatedRecords - Laraxot PTVX

Questa guida definisce come implementare correttamente le pagine di gestione dei record correlati (ManageRelatedRecords) evitando ridondanze e sfruttando l'architettura XotBase.

## 1. Architettura
`XotBaseManageRelatedRecords` estende la classe base di Filament e utilizza il trait `HasXotTable`. Questo significa che la configurazione della tabella è automatizzata tramite i vari hook `getTable*`.

## 2. Evitare Funzioni Ridondanti

### A. Non sovrascrivere `table()`
Il trait `HasXotTable` implementa già il metodo `table(Table $table)`. Salvo casi eccezionali, non deve essere sovrascritto. La personalizzazione deve avvenire tramite gli hook specifici.

### B. Riutilizzo delle Colonne
Se la tabella dei record correlati deve mostrare le stesse colonne della pagina List principale della risorsa correlata, è consigliabile esporre un metodo statico nella pagina List (es. `get[Model]TableColumns`) e chiamarlo in `getTableColumns()`.

### C. Azioni di Intestazione (Header Actions)
Invece di creare manualmente `CreateAction` o `AssociateAction` in `getTableHeaderActions()`, utilizzare i flag di controllo:
- `shouldShowAssociateAction()`: ritornare `true` per abilitare l'associazione.
- `shouldShowAttachAction()`: ritornare `true` per abilitare l'attacco (N:M).

### D. Azioni di Riga (Table Actions)
`HasXotTable` aggiunge automaticamente `ViewAction`, `EditAction` e `DeleteAction` basandosi sui permessi della risorsa. Sovrascrivere `getTableActions()` solo per aggiungere azioni non standard (es. `DissociateAction`, `RestoreAction`).

## 3. Esempio Corretto (ManageCharts)
```php
class ManageCharts extends XotBaseManageRelatedRecords {
    protected static string $resource = SurveyPdfResource::class;
    protected static string $relationship = 'charts';

    public function getTableColumns(): array {
        // Riutilizzo colonne definite nella pagina List principale
        return ListCharts::getChartTableColumns();
    }

    protected function shouldShowAssociateAction(): bool {
        return true; // Abilita AssociateAction automaticamente
    }

    public function getTableActions(): array {
        return array_merge(parent::getTableActions(), [
            'dissociate' => DissociateAction::make(),
            'restore' => RestoreAction::make(),
        ]);
    }
}
```
