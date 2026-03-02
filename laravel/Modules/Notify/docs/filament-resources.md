# Risorse Filament del Modulo Notify

### Versione HEAD

## NotificationTemplateResource

### Panoramica
NotificationTemplateResource gestisce i template delle notifiche nel sistema. Estende `XotBaseResource` e implementa le funzionalità base per la gestione dei template.

### Versione Incoming

## MailTemplateResource

### Panoramica
MailTemplateResource gestisce i template delle email nel sistema. Estende `XotBaseResource` e implementa le funzionalità base per la gestione dei template.

---


### Schema del Form

```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Card::make()
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

### Versione HEAD


### Versione Incoming

                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),


---

                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255),

### Versione HEAD

                Forms\Components\Textarea::make('body_text')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpan(['lg' => 3]),

                Forms\Components\Textarea::make('body_html')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpan(['lg' => 3]),

                Forms\Components\Textarea::make('preview_data')
                    ->json()
                    ->columnSpan(['lg' => 3]),
            ])
            ->columns(['lg' => 3])

### Versione Incoming

                Forms\Components\RichEditor::make('body_html')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('body_text')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Forms\Components\Select::make('channels')
                    ->multiple()
                    ->options(fn () => collect(__('notify::mail.template.fields.channels.options'))
                        ->map(fn ($option) => $option['label'])
                        ->toArray())
                    ->required(),

                Forms\Components\KeyValue::make('variables')
                    ->columnSpanFull()
                    ->json()
                    ->validate([
                        'key' => 'required|string',
                        'value' => 'required|string'
                    ]),

                Forms\Components\KeyValue::make('conditions')
                    ->columnSpanFull()
                    ->json()
                    ->validate([
                        'key' => 'required|string',
                        'value' => 'required|string'
                    ]),

                Forms\Components\KeyValue::make('preview_data')
                    ->columnSpanFull()
                    ->json()
                    ->validate([
                        'key' => 'required|string',
                        'value' => 'required|string'
                    ]),

                Forms\Components\TextInput::make('category')
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ])
            ->columns(2),

---

    ];
}
```

### Colonne della Tabella

```php
public static function getTableColumns(): array
{
    return [
### Versione HEAD

        Tables\Columns\TextColumn::make('name'),
        Tables\Columns\TextColumn::make('subject'),
        Tables\Columns\TextColumn::make('created_at')
            ->dateTime(),
        Tables\Columns\TextColumn::make('updated_at')
            ->dateTime(),

### Versione Incoming

        Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),

        Tables\Columns\TextColumn::make('code')
            ->searchable()
            ->sortable(),

        Tables\Columns\TextColumn::make('category')
            ->searchable()
            ->sortable(),

        Tables\Columns\IconColumn::make('is_active')
            ->boolean()
            ->sortable(),

        Tables\Columns\TextColumn::make('created_at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\TextColumn::make('updated_at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true),
    ];
}
```

### Filtri della Tabella

```php
public static function getTableFilters(): array
{
    return [
        Tables\Filters\SelectFilter::make('category')
            ->options(fn () => collect(__('notify::mail.template.filters.category.options'))
                ->map(fn ($option) => $option['label'])
                ->toArray()),

        Tables\Filters\TernaryFilter::make('is_active'),
    ];
}
```

### Azioni della Tabella

```php
public static function getTableActions(): array
{
    return [
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
        Tables\Actions\Action::make('preview')
            ->icon('heroicon-o-eye')
            ->color('success')
            ->url(fn (MailTemplate $record): string => route('filament.resources.mail-templates.preview', $record)),

---

    ];
}
```

### Best Practices Seguite

1. **Estensione Corretta**
   - Estende `XotBaseResource`
   - Non sovrascrive metodi `final`
   - Implementa correttamente i metodi astratti

2. **Gestione Label**
   - Utilizza file di traduzione per le label
   - Non usa `->label()` direttamente
   - Segue le convenzioni di traduzione

3. **Struttura del Form**
   - Organizzazione logica dei campi
   - Validazione appropriata
   - Gestione responsive con columnSpan

### Versione HEAD


### Versione Incoming

4. **Validazione JSON**
   - Validazione per campi KeyValue
   - Struttura JSON definita
   - Regole di validazione chiare

5. **Gestione Traduzioni**
   - Tutte le traduzioni in file dedicati
   - Struttura gerarchica delle traduzioni
   - Supporto per tooltip e placeholder


---

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura Filament](../../../../project_docs/architecture/filament.md)
- [Gestione Notifiche](../../../../project_docs/architecture/notifications.md)

### Collegamenti ai Moduli
- [XotBaseResource](../../Xot/project_docs/XotBaseResource.md)
- [Architettura Filament](../../../../docs/architecture/filament.md)
- [Gestione Notifiche](../../../../docs/architecture/notifications.md)

### Collegamenti ai Moduli
- [XotBaseResource](../../Xot/docs/XotBaseResource.md)
- [Gestione Template](../template-management.md)

## Note Importanti

1. Tutti i testi sono gestiti tramite file di traduzione
2. La validazione è implementata a livello di form
3. I campi sono organizzati in modo logico e responsive
4. Le azioni della tabella seguono le convenzioni standard
### Versione HEAD

5. Non ci sono override non necessari di metodi 

### Versione Incoming

5. Non ci sono override non necessari di metodi
6. I campi JSON sono validati correttamente
7. Le traduzioni seguono la struttura corretta 
## Collegamenti tra versioni di filament-resources.md
* [filament-resources.md](../../../../project_docs/tecnico/filament/filament-resources.md)
* [filament-resources.md](../../../../project_docs/regole/filament-resources.md)
* [filament-resources.md](../../Gdpr/project_docs/filament-resources.md)
* [filament-resources.md](../../Xot/project_docs/filament-resources.md)
* [filament-resources.md](../../Patient/project_docs/filament-resources.md)
* [filament-resources.md](../../Cms/project_docs/filament-resources.md)
* [filament-resources.md](../../../../docs/tecnico/filament/filament-resources.md)
* [filament-resources.md](../../../../docs/regole/filament-resources.md)
* [filament-resources.md](../../Gdpr/docs/filament-resources.md)
* [filament-resources.md](../../Xot/docs/filament-resources.md)
* [filament-resources.md](../../Patient/docs/filament-resources.md)
* [filament-resources.md](../../Cms/docs/filament-resources.md)


---

