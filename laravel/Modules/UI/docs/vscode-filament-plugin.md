# Plugin VSCode per Filament

## Overview

Il plugin VSCode per Filament fornisce funzionalità avanzate per lo sviluppo di interfacce Filament, con snippet, autocompletamento e validazione in tempo reale.

## Installazione

1. Apri VSCode
2. Vai al pannello Extensions (Ctrl+Shift+X)
3. Cerca "Filament PHP"
4. Installa il plugin di doonfrs

## Funzionalità Principali

### 1. Snippet per Form Components
```php
// Digita 'fil-text' e premi Tab
TextInput::make('field_name')
    ->required()
    ->maxLength(255)

// Digita 'fil-select' e premi Tab
Select::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published'
    ])
    ->required()

// Digita 'fil-date' e premi Tab
DatePicker::make('published_at')
    ->format('Y-m-d')
    ->required()
```

### 2. Snippet per Table Columns
```php
// Digita 'fil-col-text' e premi Tab
TextColumn::make('title')
    ->searchable()
    ->sortable()

// Digita 'fil-col-bool' e premi Tab
IconColumn::make('is_published')
    ->boolean()
    ->sortable()
```

### 3. Snippet per Actions
```php
// Digita 'fil-action' e premi Tab
Action::make('approve')
    ->label('Approve')
    ->requiresConfirmation()
    ->action(fn () => $this->approve())

// Digita 'fil-bulk' e premi Tab
BulkAction::make('delete')
    ->label('Delete Selected')
    ->requiresConfirmation()
    ->action(fn (Collection $records) => $records->each->delete())
```

## Best Practices

### 1. Organizzazione Form
```php
// Raggruppa campi correlati
Section::make('Personal Information')
    ->schema([
        $this->getPersonalInfoFields(),    // ✅ Metodo separato
        $this->getContactFields(),         // ✅ Metodo separato
    ])

// Invece di
Section::make('Personal Information')      // ❌ Troppi campi inline
    ->schema([
        TextInput::make('name'),
        TextInput::make('email'),
        TextInput::make('phone'),
        // ... altri 10 campi
    ])
```

### 2. Validazione
```php
// Usa i metodi di validazione suggeriti
TextInput::make('email')
    ->email()                // ✅ Validazione specifica
    ->required()
    ->unique(ignoreRecord: true)

// Invece di
TextInput::make('email')    // ❌ Validazione generica
    ->rules(['email', 'required', 'unique:users,email'])
```

### 3. Relazioni
```php
// Usa i metodi relationship suggeriti
Select::make('category_id')
    ->relationship('category', 'name')  // ✅ Metodo relationship
    ->searchable()
    ->preload()

// Invece di
Select::make('category_id')            // ❌ Query manuale
    ->options(Category::pluck('name', 'id'))
```

## Scorciatoie da Tastiera

| Scorciatoia | Descrizione |
|-------------|-------------|
| `fil-text→` | TextInput component |
| `fil-select→` | Select component |
| `fil-date→` | DatePicker component |
| `fil-col→` | Table Column |
| `fil-action→` | Action |
| `fil-bulk→` | Bulk Action |
| `fil-section→` | Form Section |
| `fil-grid→` | Grid Layout |
| `fil-card→` | Card Layout |

## Validazione in Tempo Reale

Il plugin fornisce:
- Evidenziazione errori sintassi
- Suggerimenti metodi disponibili
- Validazione tipi di dati
- Controllo namespace

## Integrazione con il Nostro Workflow

### 1. Convenzioni di Naming
```php
// Il plugin suggerisce i nostri prefissi standard
TextInput::make('full_name')    // ✅ Naming convention corretta
    ->required()

TextInput::make('nome')         // ❌ Non segue convenzioni
    ->required()
```

### 2. Struttura Form
```php
// Organizzazione suggerita per i nostri form
Forms\Components\Wizard::make([
    $this->getPersonalInfoStep(),     // ✅ Metodi separati per step
    $this->getContactsStep(),
])
->skippable(false)
```

### 3. Traduzioni
```php
// Supporto per il nostro sistema di traduzioni
TextInput::make('full_name')
    // Il plugin suggerisce l'uso di trans()
    ->placeholder(trans("$prefix.fields.full_name.placeholder"))
```

## Configurazione Raccomandata

```json
// .vscode/settings.json
{
    "filamentphp.snippets.enabled": true,
    "filamentphp.validation.enabled": true,
    "filamentphp.intelephense.enabled": true,
    "filamentphp.format.enabled": true,
    "editor.snippetSuggestions": "top"
}
```

## Troubleshooting

### Problemi Comuni

1. **Snippet non funzionano**
   - Verifica che il file sia riconosciuto come PHP
   - Controlla che i suggerimenti snippet siano abilitati
   - Riavvia VSCode

2. **Validazione non funziona**
   - Verifica che intelephense sia installato
   - Controlla che il workspace sia trusted
   - Aggiorna il plugin

3. **Autocompletamento lento**
   - Riduci la dimensione del workspace
   - Aumenta la memoria disponibile per VSCode
   - Disabilita temporaneamente altre estensioni

## Collegamenti
- [Form Components](form-components.md)
- [Naming Conventions](naming-conventions.md)
- [Translation System](../../Lang/docs/translation-system.md)

## Vedi Anche
- [VSCode PHP Setup](vscode-php-setup.md)
- [Development Tools](development-tools.md)
- [Filament Documentation](https://filamentphp.com/docs)
# Plugin VSCode per Filament

## Overview

Il plugin VSCode per Filament fornisce funzionalità avanzate per lo sviluppo di interfacce Filament, con snippet, autocompletamento e validazione in tempo reale.

## Installazione

1. Apri VSCode
2. Vai al pannello Extensions (Ctrl+Shift+X)
3. Cerca "Filament PHP"
4. Installa il plugin di doonfrs

## Funzionalità Principali

### 1. Snippet per Form Components
```php
// Digita 'fil-text' e premi Tab
TextInput::make('field_name')
    ->required()
    ->maxLength(255)

// Digita 'fil-select' e premi Tab
Select::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published'
    ])
    ->required()

// Digita 'fil-date' e premi Tab
DatePicker::make('published_at')
    ->format('Y-m-d')
    ->required()
```

### 2. Snippet per Table Columns
```php
// Digita 'fil-col-text' e premi Tab
TextColumn::make('title')
    ->searchable()
    ->sortable()

// Digita 'fil-col-bool' e premi Tab
IconColumn::make('is_published')
    ->boolean()
    ->sortable()
```

### 3. Snippet per Actions
```php
// Digita 'fil-action' e premi Tab
Action::make('approve')
    ->label('Approve')
    ->requiresConfirmation()
    ->action(fn () => $this->approve())

// Digita 'fil-bulk' e premi Tab
BulkAction::make('delete')
    ->label('Delete Selected')
    ->requiresConfirmation()
    ->action(fn (Collection $records) => $records->each->delete())
```

## Best Practices

### 1. Organizzazione Form
```php
// Raggruppa campi correlati
Section::make('Personal Information')
    ->schema([
        $this->getPersonalInfoFields(),    // ✅ Metodo separato
        $this->getContactFields(),         // ✅ Metodo separato
    ])

// Invece di
Section::make('Personal Information')      // ❌ Troppi campi inline
    ->schema([
        TextInput::make('name'),
        TextInput::make('email'),
        TextInput::make('phone'),
        // ... altri 10 campi
    ])
```

### 2. Validazione
```php
// Usa i metodi di validazione suggeriti
TextInput::make('email')
    ->email()                // ✅ Validazione specifica
    ->required()
    ->unique(ignoreRecord: true)

// Invece di
TextInput::make('email')    // ❌ Validazione generica
    ->rules(['email', 'required', 'unique:users,email'])
```

### 3. Relazioni
```php
// Usa i metodi relationship suggeriti
Select::make('category_id')
    ->relationship('category', 'name')  // ✅ Metodo relationship
    ->searchable()
    ->preload()

// Invece di
Select::make('category_id')            // ❌ Query manuale
    ->options(Category::pluck('name', 'id'))
```

## Scorciatoie da Tastiera

| Scorciatoia | Descrizione |
|-------------|-------------|
| `fil-text→` | TextInput component |
| `fil-select→` | Select component |
| `fil-date→` | DatePicker component |
| `fil-col→` | Table Column |
| `fil-action→` | Action |
| `fil-bulk→` | Bulk Action |
| `fil-section→` | Form Section |
| `fil-grid→` | Grid Layout |
| `fil-card→` | Card Layout |

## Validazione in Tempo Reale

Il plugin fornisce:
- Evidenziazione errori sintassi
- Suggerimenti metodi disponibili
- Validazione tipi di dati
- Controllo namespace

## Integrazione con il Nostro Workflow

### 1. Convenzioni di Naming
```php
// Il plugin suggerisce i nostri prefissi standard
TextInput::make('full_name')    // ✅ Naming convention corretta
    ->required()

TextInput::make('nome')         // ❌ Non segue convenzioni
    ->required()
```

### 2. Struttura Form
```php
// Organizzazione suggerita per i nostri form
Forms\Components\Wizard::make([
    $this->getPersonalInfoStep(),     // ✅ Metodi separati per step
    $this->getContactsStep(),
])
->skippable(false)
```

### 3. Traduzioni
```php
// Supporto per il nostro sistema di traduzioni
TextInput::make('full_name')
    // Il plugin suggerisce l'uso di trans()
    ->placeholder(trans("$prefix.fields.full_name.placeholder"))
```

## Configurazione Raccomandata

```json
// .vscode/settings.json
{
    "filamentphp.snippets.enabled": true,
    "filamentphp.validation.enabled": true,
    "filamentphp.intelephense.enabled": true,
    "filamentphp.format.enabled": true,
    "editor.snippetSuggestions": "top"
}
```

## Troubleshooting

### Problemi Comuni

1. **Snippet non funzionano**
   - Verifica che il file sia riconosciuto come PHP
   - Controlla che i suggerimenti snippet siano abilitati
   - Riavvia VSCode

2. **Validazione non funziona**
   - Verifica che intelephense sia installato
   - Controlla che il workspace sia trusted
   - Aggiorna il plugin

3. **Autocompletamento lento**
   - Riduci la dimensione del workspace
   - Aumenta la memoria disponibile per VSCode
   - Disabilita temporaneamente altre estensioni

## Collegamenti
- [Form Components](form-components.md)
- [Naming Conventions](naming-conventions.md)
- [Translation System](../../Lang/project_docs/translation-system.md)
- [Translation System](../../Lang/project_docs/translation-system.md)
- [Translation System](../../Lang/project_docs/translation-system.md)

## Vedi Anche
- [VSCode PHP Setup](vscode-php-setup.md)
- [Development Tools](development-tools.md)
- [Filament Documentation](https://filamentphp.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
