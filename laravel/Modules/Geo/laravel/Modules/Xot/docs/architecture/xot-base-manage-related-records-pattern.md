# Pattern XotBaseManageRelatedRecords - Laraxot PTVX

Questa guida definisce come implementare correttamente le pagine di gestione dei record correlati (ManageRelatedRecords) evitando ridondanze e sfruttando l'architettura XotBase.

## 1. Architettura
`XotBaseManageRelatedRecords` estende la classe base di Filament e utilizza il trait `HasXotTable`. Questo significa che la configurazione della tabella è automatizzata tramite i vari hook `getTable*`.

## 2. Evitare Funzioni Ridondanti

### A. Non sovrascrivere `table()`
Il trait `HasXotTable` implementa già il metodo `table(Table $table)`. Salvo casi eccezionali, non deve essere sovrascritto. La personalizzazione deve avvenire tramite gli hook specifici.

### B. Riutilizzo delle Colonne
Se la tabella dei record correlati deve mostrare le stesse colonne della pagina List principale della risorsa correlata, **non** creare wrapper statici aggiuntivi.

Utilizzare invece direttamente l'istanza della pagina List tramite il container:

```php
public function getTableColumns(): array {
    /** @var ListCharts $page */
    $page = app(ListCharts::class);

    return $page->getTableColumns();
}
```

### C. Azioni di Intestazione (Header Actions)
Invece di creare manualmente `CreateAction` o `AssociateAction` in `getTableHeaderActions()`, utilizzare i flag di controllo:
- `shouldShowAssociateAction()`: ritornare `true` per abilitare l'associazione.
- `shouldShowAttachAction()`: ritornare `true` per abilitare l'attacco (N:M).

### D. Azioni di Riga (Table Actions)
`HasXotTable` aggiunge automaticamente `ViewAction`, `EditAction` e `DeleteAction` basandosi sui permessi della risorsa. Sovrascrivere `getTableActions()` solo per aggiungere azioni non standard (es. `DissociateAction`, `RestoreAction`).

## 4. Sexy UI & Advanced Patterns

### A. Infolist per Metadati dell'Owner
Spesso è utile mostrare informazioni sul record "padre" (es. i dettagli del Progetto mentre si gestiscono i suoi Dipendenti). Utilizzare `getInfolistSchema()`:

```php
public function getInfolistSchema(): array {
    return [
        Section::make('Dettagli Progetto')
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('budget')->money('EUR'),
            ])
            ->columns(2),
    ];
}
```

### B. Icone e Colori Standard
Le colonne ID e Date dovrebbero sempre avere icone e colori coerenti:
- `id`: `heroicon-o-hashtag` (gray)
- `created_at`: `since()` (gray)

### C. Badge di Navigazione
Sebbene `getNavigationBadge()` sia statico, è possibile implementare logiche di conteggio globali se necessario, o lasciarlo come hook per implementazioni specifiche.

## 5. Esempio "Sexy" Completo

```php
class ManageProjectPhases extends XotBaseManageRelatedRecords {
    protected static string $resource = ProjectResource::class;
    protected static string $relationship = 'phases';

    public function getTableColumns(): array {
        return [
            'id' => TextColumn::make('id')
                ->label(static::trans('fields.id'))
                ->icon('heroicon-o-hashtag')
                ->sortable(),
            'name' => TextColumn::make('name')
                ->label(static::trans('fields.name'))
                ->searchable(),
            'status' => BadgeColumn::make('status')
                ->colors([
                    'danger' => 'draft',
                    'warning' => 'pending',
                    'success' => 'active',
                ]),
        ];
    }

    protected function shouldShowAttachAction(): bool {
        return true;
    }
}
```
