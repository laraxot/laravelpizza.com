# TeamsRelationManager in User Module

## Panoramica

Il `TeamsRelationManager` gestisce la relazione many-to-many tra utenti e team all'interno del modulo User, fornendo funzionalità per l'associazione, la visualizzazione e la gestione dei team associati a un utente.

## REGOLA FONDAMENTALE

**MAI usare ->label(), ->placeholder(), ->helperText() nei componenti Filament.**
La traduzione è automatica tramite la struttura espansa dei file di traduzione. Ogni override nel codice è un errore grave e va corretto subito.

### Esempio corretto

```php
TextInput::make('role'), // NESSUN ->label(), ->placeholder(), ->helperText()
```

### Anti-pattern (da evitare)

```php
// ❌ ERRATO
TextInput::make('role')->label('Ruolo')->helperText('Testo di aiuto');
TextColumn::make('name')->label('Nome');
```

## Checklist
- [x] Nessun uso di ->label(), ->placeholder(), ->helperText() nei componenti
- [x] Traduzioni solo tramite file di traduzione espansa
- [x] Documentazione aggiornata
- [x] Esempi di anti-pattern

## WARNING

> Qualsiasi uso di ->label(), ->placeholder(), ->helperText() nei componenti Filament è VIETATO. La traduzione è automatica tramite la struttura espansa dei file di traduzione. Se trovi override, correggi immediatamente e aggiorna la doc.

## Collegamenti
- [../teams.php](../../lang/it/teams.php)
- [../../../../.cursor/rules/xotbaserelationmanager.mdc](../../../../.cursor/rules/xotbaserelationmanager.mdc)
- [../../../../.windsurf/rules/xotbaserelationmanager.mdc](../../../../.windsurf/rules/xotbaserelationmanager.mdc)

## Regole Fondamentali per Laraxot PTVX

### IMPORTANTE: Non usare mai ->label(), ->placeholder(), ->helperText()

In Laraxot PTVX, **NON utilizzare** i metodi `->label()`, `->placeholder()` e `->helperText()`. Le traduzioni vengono gestite automaticamente dal LangServiceProvider usando il file di traduzione del modulo.

### Struttura Standard

Il RelationManager deve:
1. Estendere `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager`
2. Non implementare il metodo `form()` che è `final` in XotBaseRelationManager
3. Non implementare il metodo `table()` direttamente (usare invece `getTableColumns()`, ecc.)
4. Implementare correttamente i metodi richiesti con tipizzazione rigorosa
5. Non usare metodi di localizzazione espliciti (`->label()`, `->placeholder()`, `->helperText()`)

### File di Traduzione

Tutte le label e i messaggi devono essere definiti nel file di traduzione `Modules/User/lang/{locale}/teams.php`.

Esempio:
```php
// Modules/User/lang/it/teams.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome Team',
        ],
        'personal_team' => [
            'label' => 'Team Personale',
        ],
        'role' => [
            'label' => 'Ruolo',
            'help' => 'Ruolo dell\'utente nel team',
        ],
    ],
    'actions' => [
        'attach' => [
            'label' => 'Associa Team',
        ],
        'detach' => [
            'label' => 'Rimuovi Team',
        ],
    ],
];
```

## Esempi di Implementazione Corretta

### getTableColumns()

```php
/**
 * Definisce le colonne della tabella.
 *
 * @return array<int, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        TextColumn::make('name')
            ->searchable()
            ->sortable(),
        IconColumn::make('personal_team')
            ->boolean()
            ->getStateUsing(function (Model $record, $livewire): bool {
                /** @var \Modules\User\Models\User $user */
                $user = $livewire->getOwnerRecord();
                return $user->current_team_id === $record->getKey();
            }),
    ];
}
```

### getFormSchema()

```php
/**
 * Definisce lo schema del form.
 *
 * @return array<int, \Filament\Forms\Components\Component>
 */
public function getFormSchema(): array
{
    return [
        TextInput::make('role')
            ->default('editor')
            ->required(),
    ];
}
```

### getTableHeaderActions()

```php
/**
 * Definisce le azioni dell'header della tabella.
 *
 * @return array<string, \Filament\Tables\Actions\Action>
 */
public function getTableHeaderActions(): array
{
    return [
        'attach' => AttachAction::make()
            ->modalHeading(__('user::teams.actions.attach.modal.heading'))
            ->form(fn (AttachAction $action): array => [
                $action->getRecordSelect(),
                TextInput::make('role')
                    ->default('member')
                    ->required(),
            ]),
    ];
}
```

### getTableActions()

```php
/**
 * Definisce le azioni per ogni riga della tabella.
 *
 * @return array<string, \Filament\Tables\Actions\Action>
 */
public function getTableActions(): array
{
    return [
        'edit' => EditAction::make()
            ->modalHeading(__('user::teams.actions.edit.modal.heading')),
        'detach' => DetachAction::make()
            ->modalHeading(__('user::teams.actions.detach.modal.heading'))
            ->after(function (Model $record, $livewire): void {
                /** @var \Modules\User\Models\User $user */
                $user = $livewire->getOwnerRecord();
                if ($user->current_team_id === $record->getKey()) {
                    $user->update(['current_team_id' => null]);
                }
            }),
    ];
}
```

## Link a Documentazione Correlata

- [XotBaseRelationManager](/laravel/Modules/Xot/docs/filament/relation_managers.md)
- [HasXotTable Trait](/laravel/Modules/Xot/docs/filament/xot_table.md)
- [Regole di Traduzione per Filament](/laravel/Modules/Xot/docs/translation_rules.md)

*Ultimo aggiornamento: 3 Giugno 2025*