# Filament VSCode Extension

## Panoramica

L'estensione VSCode per Filament fornisce un set completo di strumenti per sviluppare applicazioni Filament in modo più efficiente.

## Caratteristiche

### 1. Snippets

#### Form Components
- `fil-text` → TextInput
- `fil-select` → Select
- `fil-textarea` → Textarea
- `fil-checkbox` → Checkbox
- `fil-toggle` → Toggle
- `fil-date` → DatePicker
- `fil-time` → TimePicker
- `fil-file` → FileUpload
- `fil-rich` → RichEditor

#### Table Components
- `fil-table` → Table Builder
- `fil-col` → Table Column
- `fil-action` → Table Action
- `fil-bulk` → Bulk Action

#### Layout Components
- `fil-card` → Card
- `fil-grid` → Grid
- `fil-section` → Section
- `fil-tabs` → Tabs
- `fil-wizard` → Wizard

### 2. Autocompletamento

- Nomi dei componenti Filament
- Proprietà dei componenti
- Metodi disponibili
- Eventi
- Slot

### 3. Hover Information

Mostra documentazione al passaggio del mouse su:
- Componenti
- Metodi
- Proprietà

### 4. Diagnostica

- Validazione della sintassi
- Controllo dei tipi
- Verifica delle dipendenze

## Installazione

1. Aprire VSCode
2. Premere `Ctrl+P`
3. Incollare `ext install doonfrs.filament-snippets`
4. Premere `Enter`

## Configurazione

```json
{
    "filament.snippets.enable": true,
    "filament.hover.enable": true,
    "filament.diagnostics.enable": true,
    "filament.completion.enable": true
}
```

## Esempi di Utilizzo

### Form Builder

```php
// Digitare 'fil-form' e premere Tab
public static function form(Form $form): Form
public static function form(Form $form): Form
public static function form(Form $form): Form
{
    return $form->schema([
        // Digitare 'fil-text' e premere Tab
        TextInput::make('title')
            ->required()
            ->maxLength(255),

        // Digitare 'fil-select' e premere Tab
        Select::make('status')
            ->options([
                'draft' => 'Draft',
                'published' => 'Published',
            ])
            ->required(),

        // Digitare 'fil-rich' e premere Tab
        RichEditor::make('content')
            ->required()
            ->columnSpanFull(),
    ]);
}
```

### Table Builder

```php
// Digitare 'fil-table' e premere Tab
public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Digitare 'fil-col' e premere Tab
            TextColumn::make('title')
                ->searchable()
                ->sortable(),

            // Digitare 'fil-col' e premere Tab
            IconColumn::make('status')
                ->boolean(),
        ])
        ->filters([
            // Digitare 'fil-filter' e premere Tab
            SelectFilter::make('status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                ]),
        ])
        ->actions([
            // Digitare 'fil-action' e premere Tab
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            // Digitare 'fil-bulk' e premere Tab
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}
```

### Layout Components

```php
// Digitare 'fil-wizard' e premere Tab
Forms\Components\Wizard::make([
    Forms\Components\Wizard\Step::make('Personal Information')
        ->schema([
            // Digitare 'fil-grid' e premere Tab
            Forms\Components\Grid::make(2)
                ->schema([
                    // Digitare 'fil-text' e premere Tab
                    Forms\Components\TextInput::make('first_name')
                        ->required(),

                    Forms\Components\TextInput::make('last_name')
                        ->required(),
                ]),
        ]),
]);
```

## Best Practices

1. **Organizzazione del Codice**
   - Usare gli snippet per mantenere una struttura consistente
   - Raggruppare componenti correlati in sezioni
   - Utilizzare i commenti per documentare la logica complessa

2. **Autocompletamento**
   - Sfruttare l'autocompletamento per esplorare le API disponibili
   - Verificare i tipi di dati supportati
   - Controllare i metodi disponibili

3. **Diagnostica**
   - Prestare attenzione agli avvisi dell'estensione
   - Correggere gli errori segnalati
   - Seguire le best practices suggerite

## Scorciatoie da Tastiera

| Comando | Descrizione |
|---------|-------------|
| `Ctrl+Space` | Attiva l'autocompletamento |
| `Ctrl+Shift+Space` | Mostra la firma del metodo |
| `F12` | Vai alla definizione |
| `Alt+F12` | Mostra la definizione |
| `Shift+F12` | Mostra tutti i riferimenti |

## Troubleshooting

1. **Gli snippet non funzionano**
   - Verificare che l'estensione sia installata
   - Controllare che il file sia riconosciuto come PHP
   - Riavviare VSCode

2. **Autocompletamento non funziona**
   - Verificare che il progetto abbia le dipendenze Filament
   - Controllare che il file `composer.json` sia valido
   - Rigenerare l'autoload di Composer

3. **Errori di diagnostica errati**
   - Pulire la cache di VSCode
   - Aggiornare l'estensione
   - Verificare la versione di PHP

## Vedi Anche

- [Filament Documentation](https://filamentphp.com)
- [VSCode PHP Extension](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
- [Laravel Extension Pack](https://marketplace.visualstudio.com/items?itemName=onecentlin.laravel-extension-pack)
# Filament VSCode Extension

## Panoramica

L'estensione VSCode per Filament fornisce un set completo di strumenti per sviluppare applicazioni Filament in modo più efficiente.

## Caratteristiche

### 1. Snippets

#### Form Components
- `fil-text` → TextInput
- `fil-select` → Select
- `fil-textarea` → Textarea
- `fil-checkbox` → Checkbox
- `fil-toggle` → Toggle
- `fil-date` → DatePicker
- `fil-time` → TimePicker
- `fil-file` → FileUpload
- `fil-rich` → RichEditor

#### Table Components
- `fil-table` → Table Builder
- `fil-col` → Table Column
- `fil-action` → Table Action
- `fil-bulk` → Bulk Action

#### Layout Components
- `fil-card` → Card
- `fil-grid` → Grid
- `fil-section` → Section
- `fil-tabs` → Tabs
- `fil-wizard` → Wizard

### 2. Autocompletamento

- Nomi dei componenti Filament
- Proprietà dei componenti
- Metodi disponibili
- Eventi
- Slot

### 3. Hover Information

Mostra documentazione al passaggio del mouse su:
- Componenti
- Metodi
- Proprietà

### 4. Diagnostica

- Validazione della sintassi
- Controllo dei tipi
- Verifica delle dipendenze

## Installazione

1. Aprire VSCode
2. Premere `Ctrl+P`
3. Incollare `ext install doonfrs.filament-snippets`
4. Premere `Enter`

## Configurazione

```json
{
    "filament.snippets.enable": true,
    "filament.hover.enable": true,
    "filament.diagnostics.enable": true,
    "filament.completion.enable": true
}
```

## Esempi di Utilizzo

### Form Builder

```php
// Digitare 'fil-form' e premere Tab
public static function form(Form $form): Form
public static function form(Form $form): Form
{
    return $form->schema([
        // Digitare 'fil-text' e premere Tab
        TextInput::make('title')
            ->required()
            ->maxLength(255),

        // Digitare 'fil-select' e premere Tab
        Select::make('status')
            ->options([
                'draft' => 'Draft',
                'published' => 'Published',
            ])
            ->required(),

        // Digitare 'fil-rich' e premere Tab
        RichEditor::make('content')
            ->required()
            ->columnSpanFull(),
    ]);
}
```

### Table Builder

```php
// Digitare 'fil-table' e premere Tab
public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Digitare 'fil-col' e premere Tab
            TextColumn::make('title')
                ->searchable()
                ->sortable(),

            // Digitare 'fil-col' e premere Tab
            IconColumn::make('status')
                ->boolean(),
        ])
        ->filters([
            // Digitare 'fil-filter' e premere Tab
            SelectFilter::make('status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                ]),
        ])
        ->actions([
            // Digitare 'fil-action' e premere Tab
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            // Digitare 'fil-bulk' e premere Tab
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}
```

### Layout Components

```php
// Digitare 'fil-wizard' e premere Tab
Forms\Components\Wizard::make([
    Forms\Components\Wizard\Step::make('Personal Information')
        ->schema([
            // Digitare 'fil-grid' e premere Tab
            Forms\Components\Grid::make(2)
                ->schema([
                    // Digitare 'fil-text' e premere Tab
                    Forms\Components\TextInput::make('first_name')
                        ->required(),

                    Forms\Components\TextInput::make('last_name')
                        ->required(),
                ]),
        ]),
]);
```

## Best Practices

1. Organizzazione del codice
