# Sistema Traduzioni - Documentazione Consolidata DRY + KISS

> **🎯 Single Source of Truth**: Questo documento centralizza TUTTE le regole di traduzione del progetto
> 
> **🔗 Riferimenti**: [coding-standards.md](coding-standards.md) | [best-practices.md](best-practices.md)

## 🚨 STOP DUPLICAZIONE!

**Prima di creare nuovi file di traduzione, LEGGI QUESTO DOCUMENTO!**

Questo documento sostituisce e consolida **50+ file di traduzione duplicati** trovati in tutti i moduli.

### ❌ File da NON Creare Più
- `translations.md` in qualsiasi modulo
- `translation-rules.md` duplicati
- `translation-standards.md` sparsi
- Qualsiasi documentazione traduzioni specifica di modulo

### ✅ Unica Fonte di Verità
- **Questo file**: `/laravel/Modules/Xot/project_docs/translation-system.md`
- **Implementazione**: File di traduzione nei singoli moduli (solo traduzioni, non docs)

## Principi Fondamentali

### Struttura Espansa Obbligatoria
```php
// ✅ CORRETTO - Struttura espansa completa
'fields' => [
    'nome_campo' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'help' => 'Testo di aiuto specifico'
    ]
]

// ❌ ERRATO - Struttura semplificata
'fields' => [
    'nome_campo' => 'Etichetta Campo'
]
```

### Regola Critica: Helper Text
- **SE** `helper_text` è uguale alla chiave dell'array → impostare `'helper_text' => ''`
- **SE** ci sono `label` e `placeholder` → **DEVE** esserci `helper_text`

## Struttura dei File di Traduzione

### Pattern Corretto per Campi
```php
<?php

// Modules/ModuleName/lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Inserisci il nome completo',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci l\'indirizzo email',
        'help' => 'L\'email verrà utilizzata per accedere al sistema',
        'validation' => [
            'required' => 'L\'email è obbligatoria',
            'email' => 'L\'email deve essere valida',
            'unique' => 'Questa email è già in uso',
        ],
    ],
    'date_of_birth' => [
        'label' => 'Data di nascita',
        'placeholder' => 'Seleziona la data di nascita',
        'help' => 'Formato: gg/mm/aaaa',
    ],
    'role' => [
        'label' => 'Ruolo',
        'placeholder' => 'Seleziona un ruolo',
        'help' => 'Il ruolo determina i permessi dell\'utente',
        'options' => [
            'admin' => 'Amministratore',
            'user' => 'Utente',
            'guest' => 'Ospite',
        ],
    ],
];
```

### Pattern Corretto per Azioni
```php
<?php

// Modules/ModuleName/lang/it/actions.php
return [
    'create' => [
        'label' => 'Crea nuovo',
        'modal_heading' => 'Crea nuovo elemento',
        'modal_description' => 'Inserisci i dati per creare un nuovo elemento',
        'success' => 'Elemento creato con successo',
        'error' => 'Si è verificato un errore durante la creazione',
        'confirmation' => 'Sei sicuro di voler creare questo elemento?',
        'buttons' => [
            'confirm' => 'Conferma',
            'cancel' => 'Annulla',
        ],
    ],
    'edit' => [
        'label' => 'Modifica',
        'modal_heading' => 'Modifica elemento',
        'modal_description' => 'Modifica i dati dell\'elemento selezionato',
        'success' => 'Elemento modificato con successo',
        'error' => 'Si è verificato un errore durante la modifica',
    ],
    'delete' => [
        'label' => 'Elimina',
        'modal_heading' => 'Elimina elemento',
        'modal_description' => 'Sei sicuro di voler eliminare questo elemento? Questa azione è irreversibile.',
        'success' => 'Elemento eliminato con successo',
        'error' => 'Si è verificato un errore durante l\'eliminazione',
        'confirmation' => 'Sei sicuro di voler eliminare questo elemento? Questa azione è irreversibile.',
        'buttons' => [
            'confirm' => 'Elimina',
            'cancel' => 'Annulla',
        ],
    ],
    'view' => [
        'label' => 'Visualizza',
        'modal_heading' => 'Dettagli elemento',
    ],
    'bulk_actions' => [
        'delete' => [
            'label' => 'Elimina selezionati',
            'modal_heading' => 'Elimina elementi selezionati',
            'modal_description' => 'Sei sicuro di voler eliminare gli elementi selezionati? Questa azione è irreversibile.',
            'success' => 'Elementi eliminati con successo',
            'error' => 'Si è verificato un errore durante l\'eliminazione',
        ],
    ],
    'custom_action' => [
        'label' => 'Azione personalizzata',
        'modal_heading' => 'Conferma azione personalizzata',
        'modal_description' => 'Stai per eseguire un\'azione personalizzata. Confermi?',
        'success' => 'Azione completata con successo',
        'error' => 'Si è verificato un errore durante l\'esecuzione dell\'azione',
        'confirmation' => 'Confermi di voler eseguire questa azione?',
        'fields' => [
            'note' => [
                'label' => 'Nota',
                'placeholder' => 'Inserisci una nota opzionale',
                'help' => 'La nota verrà registrata insieme all\'azione',
            ],
        ],
    ],
];
```

### Pattern Corretto per Widget e Componenti
```php
<?php

// Modules/ModuleName/lang/it/widgets.php
return [
    'stats_overview' => [
        'title' => 'Panoramica statistiche',
        'description' => 'Visualizza le statistiche principali',
        'stats' => [
            'total_users' => [
                'label' => 'Utenti totali',
                'description' => 'Numero totale di utenti registrati',
            ],
            'active_users' => [
                'label' => 'Utenti attivi',
                'description' => 'Utenti attivi nell\'ultimo mese',
            ],
            'new_users' => [
                'label' => 'Nuovi utenti',
                'description' => 'Utenti registrati nell\'ultima settimana',
            ],
        ],
    ],
    'recent_activity' => [
        'title' => 'Attività recenti',
        'description' => 'Ultime attività registrate',
        'empty_state' => 'Nessuna attività recente',
        'view_all' => 'Visualizza tutte',
    ],
    'chart' => [
        'title' => 'Grafico andamento',
        'description' => 'Andamento negli ultimi 30 giorni',
        'labels' => [
            'x_axis' => 'Data',
            'y_axis' => 'Valore',
        ],
        'filters' => [
            'day' => 'Giorno',
            'week' => 'Settimana',
            'month' => 'Mese',
            'year' => 'Anno',
        ],
    ],
];
```

### Pattern Corretto per Messaggi e Validazione
```php
<?php

// Modules/ModuleName/lang/it/messages.php
return [
    'welcome' => 'Benvenuto nel sistema',
    'errors' => [
        'general' => 'Si è verificato un errore. Riprova più tardi.',
        'not_found' => 'La risorsa richiesta non è stata trovata.',
        'unauthorized' => 'Non sei autorizzato ad accedere a questa risorsa.',
        'validation' => 'Si sono verificati errori di validazione.',
    ],
    'notifications' => [
        'success' => 'Operazione completata con successo',
        'info' => 'Informazione importante',
        'warning' => 'Attenzione',
        'error' => 'Errore',
    ],
    'confirmations' => [
        'delete' => 'Sei sicuro di voler eliminare questo elemento?',
        'cancel' => 'Sei sicuro di voler annullare?',
        'discard' => 'Le modifiche non salvate andranno perse. Continuare?',
    ],
    'empty_states' => [
        'default' => 'Nessun elemento trovato',
        'users' => 'Nessun utente trovato',
        'search' => 'Nessun risultato trovato per la ricerca',
        'filtered' => 'Nessun elemento corrisponde ai filtri applicati',
    ],
];
```

## Utilizzo nelle View Blade

### ✅ Pattern Corretto

```blade
<x-filament::page>
    <h2>{{ __('modulename::pages.dashboard.title') }}</h2>

    <p>{{ __('modulename::pages.dashboard.description') }}</p>

    <x-filament::button
        wire:click="createItem"
    >
        {{ __('modulename::actions.create.label') }}
    </x-filament::button>

    @if($items->isEmpty())
        <div class="mt-4">
            <p>{{ __('modulename::messages.empty_states.default') }}</p>
        </div>
    @endif
</x-filament::page>
```

## Utilizzo nei Componenti Filament

### ✅ Pattern Corretto - Forms

```php
/**
 * @return array<int, \Filament\Forms\Components\Component>
 */
protected function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('name')
            ->label(__('modulename::fields.name.label'))
            ->placeholder(__('modulename::fields.name.placeholder'))
            ->helperText(__('modulename::fields.name.help'))
            ->required(),

        Forms\Components\Select::make('role')
            ->label(__('modulename::fields.role.label'))
            ->placeholder(__('modulename::fields.role.placeholder'))
            ->helperText(__('modulename::fields.role.help'))
            ->options([
                'admin' => __('modulename::fields.role.options.admin'),
                'user' => __('modulename::fields.role.options.user'),
                'guest' => __('modulename::fields.role.options.guest'),
            ])
            ->required(),
    ];
}
```

### ✅ Pattern Corretto - Tables

```php
/**
 * @param \Filament\Tables\Table $table
 * @return \Filament\Tables\Table
 */
public function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label(__('modulename::fields.name.label'))
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('role')
                ->label(__('modulename::fields.role.label'))
                ->formatStateUsing(fn (string $state): string => __("modulename::fields.role.options.{$state}")),
        ])
        ->emptyStateHeading(__('modulename::messages.empty_states.default'))
        ->filters([
            // ...
        ])
        ->actions([
            Tables\Actions\EditAction::make()
                ->label(__('modulename::actions.edit.label')),

            Tables\Actions\DeleteAction::make()
                ->label(__('modulename::actions.delete.label'))
                ->modalHeading(__('modulename::actions.delete.modal_heading'))
                ->modalDescription(__('modulename::actions.delete.modal_description'))
                ->successNotificationTitle(__('modulename::actions.delete.success')),
        ]);
}
```

## Anti-pattern da Evitare

### ❌ NO: Stringhe Hardcoded

```php
// ❌ MAI usare stringhe hardcoded
Forms\Components\TextInput::make('name')->label('Nome')
Select::make('role')->placeholder('Seleziona ruolo')
```

### ❌ NO: Struttura Piatta

```php
// ❌ MAI usare struttura piatta
// Modules/ModuleName/lang/it/fields.php
return [
    'name_label' => 'Nome',
    'name_placeholder' => 'Inserisci il nome',
    'name_help' => 'Inserisci il nome completo',

    'email_label' => 'Email',
    'email_placeholder' => 'Inserisci l\'indirizzo email',
    'email_help' => 'L\'email verrà utilizzata per accedere al sistema',
];
```

### ❌ NO: Traduzioni Dirette senza Contesto

```php
// ❌ MAI mischiare domini di traduzione
__('Nome')  // NO: manca il file di traduzione
__('auth.fields.name')  // NO: riferimento a file di traduzione non del modulo
```

## Norme per la Creazione e Manutenzione

1. **Organizzazione**
   - Suddividere le traduzioni in file separati per contesto (fields, actions, messages, ecc.)
   - Mantenere una struttura coerente tra i diversi moduli
   - Utilizzare nomi di chiavi coerenti per concetti simili

2. **Completezza**
   - Includere sempre label, placeholder e help text per ogni campo
   - Includere messaggi per tutti gli stati (success, error, empty, ecc.)
   - Documentare opzioni per campi select e similari

3. **Manutenzione**
   - Aggiornare le traduzioni quando si modificano le funzionalità
   - Rimuovere le traduzioni non più utilizzate
   - Verificare regolarmente la coerenza tra le traduzioni

4. **Pluralizzazione e Numeri**
   - Utilizzare la funzione `trans_choice` per pluralizzazione
   - Formattare numeri e date secondo le convenzioni locali

```php
// Esempio di pluralizzazione
// Modules/ModuleName/lang/it/messages.php
return [
    'items_count' => '{0} Nessun elemento|{1} Un elemento|[2,*] :count elementi',
];

// Utilizzo
{{ trans_choice('modulename::messages.items_count', $count, ['count' => $count]) }}
```

## Errori Comuni e Soluzioni

### Problema: Chiave di Traduzione Non Trovata

**Sintomo**: Viene visualizzata la chiave di traduzione anziché il testo tradotto

**Soluzioni**:
1. Verificare il namespace del modulo nella chiamata `__('modulename::path.to.key')`
2. Controllare che il file di traduzione esista nel percorso corretto
3. Controllare che la chiave esista nel file di traduzione
4. Eseguire `php artisan cache:clear` per ripulire la cache

### Problema: Incoerenza Nelle Traduzioni

**Sintomo**: Interfaccia con mix di lingue o stili diversi

**Soluzioni**:
1. Standardizzare i nomi delle chiavi in tutti i moduli
2. Utilizzare editor con supporto per ricerca in più file
3. Creare una documentazione di riferimento per le traduzioni comuni

## Best Practice per la Tipizzazione

```php
<?php

/**
 * File di traduzione per campi del modulo.
 *
 * @return array<string, array<string, string|array<string, string>>>
 */
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Inserisci il nome completo',
    ],
    // Altri campi...
];
```

## Verifica e Manutenzione

Eseguire regolarmente questi controlli:

1. **Verifica Chiavi Mancanti**
   ```bash
   php artisan translation:missing-keys --module=ModuleName
   ```

2. **Verifica Traduzioni Non Utilizzate**
   ```bash
   php artisan translation:unused-keys --module=ModuleName
   ```

3. **Sincronizzazione Lingue**
   ```bash
   php artisan translation:sync-keys --module=ModuleName
   ```

## Collegamenti

- [Coding Standards](coding-standards.md)
- [Best Practices](best-practices.md)
- [Filament Guidelines](filament.md)

---

*Ultimo aggiornamento: 2025-08-04*
*Modulo: Xot*
*Categoria: Traduzioni*
