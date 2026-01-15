# UI/UX Enhancements per i Campi `name` e `slug` in MailTemplateResource

## Introduzione

Questo documento esplora i componenti Filament che possono migliorare l'esperienza utente per i campi `name` e `slug` nel form di gestione dei template email. I miglioramenti proposti seguono le convenzioni del progetto , mantenendo la coerenza visiva e migliorando l'usabilità.
Questo documento esplora i componenti Filament che possono migliorare l'esperienza utente per i campi `name` e `slug` nel form di gestione dei template email. I miglioramenti proposti seguono le convenzioni del progetto <nome progetto>, mantenendo la coerenza visiva e migliorando l'usabilità.

## Componenti per il Campo `name`

### 1. TextInput con Icona Prefissa

```php
'name' => Forms\Components\TextInput::make('name')
    ->required()
    ->maxLength(255)
    ->prefixIcon('heroicon-o-document-text')
    ->placeholder('Nome del template (es. Email di Benvenuto)')
    ->autofocus(),
```

**Vantaggi UI/UX:**
- L'icona contestualizza visivamente il campo
- Il placeholder fornisce un esempio chiaro
- Il focus automatico velocizza l'inserimento

### 2. TextInput con Contatore di Caratteri

```php
'name' => Forms\Components\TextInput::make('name')
    ->required()
    ->maxLength(255)
    ->extraInputAttributes(['maxlength' => 255])
    ->placeholder('Nome del template')
    ->suffixAction(
        Forms\Components\Actions\Action::make('nameInfo')
            ->icon('heroicon-o-information-circle')
            ->tooltip('Questo nome verrà utilizzato per generare lo slug')
    ),
```

**Vantaggi UI/UX:**
- Il contatore di caratteri comunica visivamente i limiti
- L'azione suffissa con tooltip fornisce informazioni contestuali
- Mantiene l'interfaccia pulita mentre offre informazioni aggiuntive

### 3. TextInput con Validazione Visiva Istantanea

```php
'name' => Forms\Components\TextInput::make('name')
    ->required()
    ->maxLength(255)
    ->live()
    ->unique(ignoreRecord: true)
    ->validateFor('slug')
    ->helperText('Il nome deve essere unico e sarà utilizzato per generare lo slug'),
```

**Vantaggi UI/UX:**
- Validazione in tempo reale con feedback visivo
- Il testo di aiuto fornisce contesto sulla relazione con lo slug
- L'attributo `live` permette interazioni dinamiche con altri campi

## Componenti per il Campo `slug`

### 1. TextInput con Generazione Automatica e Indicatore di Copia

```php
'slug' => Forms\Components\TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->maxLength(255)
    ->afterStateUpdated(fn (string $context, $state, callable $set) =>
        $context === 'create' ? $set('slug', Str::slug($state)) : null)
    ->helperText('Identificatore unico utilizzato nel codice')
    ->prefixIcon('heroicon-o-link')
    ->suffixAction(
        Forms\Components\Actions\Action::make('copySlug')
            ->icon('heroicon-o-clipboard-copy')
            ->tooltip('Copia negli appunti')
            ->extraAttributes([
                'x-on:click' => 'navigator.clipboard.writeText($wire.$get(\'slug\'))'
            ])
    ),
```

**Vantaggi UI/UX:**
- Generazione automatica che mantiene la coerenza
- Icona di link che comunica visivamente lo scopo del campo
- Azione di copia che facilita l'utilizzo del valore in altri contesti

### 2. TextInput con Sincronizzazione Live dal Campo Name

```php
'slug' => Forms\Components\TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->maxLength(255)
    ->disabled()
    ->dehydrated()
    ->live()
    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
        if (!$state || $get('generateSlug')) {
            $set('slug', Str::slug($get('name')));
        }
    })
    ->suffixAction(
        Forms\Components\Actions\Action::make('regenerateSlug')
            ->icon('heroicon-o-arrow-path')
            ->tooltip('Rigenera dallo slug dal nome')
            ->action(fn (Forms\Get $get, Forms\Set $set) =>
                $set('slug', Str::slug($get('name'))))
    ),
```

**Vantaggi UI/UX:**
- Campo inizialmente disabilitato per prevenire errori
- Sincronizzazione automatica con il campo nome
- Pulsante per rigenerare lo slug in caso di modifiche al nome
- Visualizzazione chiara che lo slug è derivato dal nome

### 3. Soluzione Completa con Toggle per Personalizzazione

```php
Forms\Components\Group::make([
    'name' => Forms\Components\TextInput::make('name')
        ->required()
        ->maxLength(255)
        ->live(onBlur: true)
        ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, string $context, ?string $state) {
            if ($context === 'create' && $get('generateSlug')) {
                $set('slug', Str::slug($state));
            }
        }),

    Forms\Components\Grid::make(2)
        ->schema([
            'generateSlug' => Forms\Components\Toggle::make('generateSlug')
                ->label('Genera slug automaticamente')
                ->default(true)
                ->live()
                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, bool $state) {
                    if ($state) {
                        $set('slug', Str::slug($get('name')));
                    }
                }),

            'slug' => Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255)
                ->disabled(fn (Forms\Get $get): bool => $get('generateSlug'))
                ->dehydrated()
                ->prefixIcon('heroicon-o-link')
                ->suffixAction(
                    Forms\Components\Actions\Action::make('copySlug')
                        ->icon('heroicon-o-clipboard-copy')
                        ->tooltip('Copia negli appunti')
                )
        ])
])->columnSpanFull(),
```

**Vantaggi UI/UX:**
- Toggle per scegliere tra generazione automatica e personalizzazione
- Disabilitazione condizionale del campo slug
- Layout a griglia che ottimizza lo spazio
- Feedback visivo completo con icone e azioni

## Esempio con Preview dello Slug

```php
'slug' => Forms\Components\TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->maxLength(255)
    ->helperText(function (Forms\Get $get): string {
        $slug = Str::slug($get('name'));
        return "Preview: {$slug}";
    })
    ->hintIcon('heroicon-o-information-circle')
    ->hintIconTooltip('Lo slug è un identificatore univoco utilizzato nelle API e nei riferimenti al template'),
```

**Vantaggi UI/UX:**
- Preview in tempo reale dello slug generato
- Icona di informazione con tooltip per spiegazioni aggiuntive
- Aiuto contestuale che mostra il risultato della trasformazione

## Considerazioni sulla Localizzazione

Tutti i testi visualizzati (etichette, placeholder, tooltip) devono essere gestiti attraverso il sistema di traduzione:

```php
// In /lang/{locale}/notify.php
return [
    'resources' => [
        'mail_template' => [
            'fields' => [
                'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Nome del template (es. Email di Benvenuto)',
                    'helper' => 'Il nome deve essere unico e descrittivo',
                ],
                'slug' => [
                    'label' => 'Slug',
                    'helper' => 'Identificatore unico utilizzato nel codice',
                    'auto_generate' => 'Genera slug automaticamente',
                    'copy_tooltip' => 'Copia negli appunti',
                    'regenerate_tooltip' => 'Rigenera dallo slug dal nome',
                ],
            ],
        ],
    ],
];
```

## Conformità con gli Standard
## Conformità con gli Standard <nome progetto>

Tutti i componenti proposti:
1. Non utilizzano il metodo `->label()` sui componenti Filament
2. Restituiscono un array associativo con chiavi stringhe in `getFormSchema()`
3. Utilizzano i componenti nativi di Filament
4. Evitano l'uso di componenti deprecati come `Card` e `Section`

## Conclusioni

I miglioramenti UI/UX proposti per i campi `name` e `slug` si concentrano su:
1. **Feedback visivo** tramite icone e indicatori
2. **Automazione intelligente** per ridurre gli errori di input
3. **Azioni contestuali** che facilitano operazioni comuni
4. **Relazioni intuitive** tra campi correlati

L'implementazione di questi miglioramenti rispetta le convenzioni del progetto  mentre offre un'esperienza utente significativamente migliorata nella gestione dei template email.
L'implementazione di questi miglioramenti rispetta le convenzioni del progetto <nome progetto> mentre offre un'esperienza utente significativamente migliorata nella gestione dei template email.

## Riferimenti

- [Documentazione Filament Forms](https://filamentphp.com/docs/forms/fields/text-input)
- [Implementazione Modello con Slug](./MODEL_SLUG_IMPLEMENTATION.md)
- [Implementazione Risorsa con Slug](./RESOURCE_SLUG_IMPLEMENTATION.md)
# UI/UX Enhancements per i Campi `name` e `slug` in MailTemplateResource

## Introduzione

Questo documento esplora i componenti Filament che possono migliorare l'esperienza utente per i campi `name` e `slug` nel form di gestione dei template email. I miglioramenti proposti seguono le convenzioni del progetto <main module>, mantenendo la coerenza visiva e migliorando l'usabilità.

## Componenti per il Campo `name`

### 1. TextInput con Icona Prefissa

```php
'name' => Forms\Components\TextInput::make('name')
    ->required()
    ->maxLength(255)
    ->prefixIcon('heroicon-o-document-text')
    ->placeholder('Nome del template (es. Email di Benvenuto)')
    ->autofocus(),
```

**Vantaggi UI/UX:**
- L'icona contestualizza visivamente il campo
- Il placeholder fornisce un esempio chiaro
- Il focus automatico velocizza l'inserimento

### 2. TextInput con Contatore di Caratteri

```php
'name' => Forms\Components\TextInput::make('name')
    ->required()
    ->maxLength(255)
    ->extraInputAttributes(['maxlength' => 255])
    ->placeholder('Nome del template')
    ->suffixAction(
        Forms\Components\Actions\Action::make('nameInfo')
            ->icon('heroicon-o-information-circle')
            ->tooltip('Questo nome verrà utilizzato per generare lo slug')
    ),
```

**Vantaggi UI/UX:**
- Il contatore di caratteri comunica visivamente i limiti
- L'azione suffissa con tooltip fornisce informazioni contestuali
- Mantiene l'interfaccia pulita mentre offre informazioni aggiuntive

### 3. TextInput con Validazione Visiva Istantanea

```php
'name' => Forms\Components\TextInput::make('name')
    ->required()
    ->maxLength(255)
    ->live()
    ->unique(ignoreRecord: true)
    ->validateFor('slug')
    ->helperText('Il nome deve essere unico e sarà utilizzato per generare lo slug'),
```

**Vantaggi UI/UX:**
- Validazione in tempo reale con feedback visivo
- Il testo di aiuto fornisce contesto sulla relazione con lo slug
- L'attributo `live` permette interazioni dinamiche con altri campi

## Componenti per il Campo `slug`

### 1. TextInput con Generazione Automatica e Indicatore di Copia

```php
'slug' => Forms\Components\TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->maxLength(255)
    ->afterStateUpdated(fn (string $context, $state, callable $set) =>
        $context === 'create' ? $set('slug', Str::slug($state)) : null)
    ->helperText('Identificatore unico utilizzato nel codice')
    ->prefixIcon('heroicon-o-link')
    ->suffixAction(
        Forms\Components\Actions\Action::make('copySlug')
            ->icon('heroicon-o-clipboard-copy')
            ->tooltip('Copia negli appunti')
            ->extraAttributes([
                'x-on:click' => 'navigator.clipboard.writeText($wire.$get(\'slug\'))'
            ])
    ),
```

**Vantaggi UI/UX:**
- Generazione automatica che mantiene la coerenza
- Icona di link che comunica visivamente lo scopo del campo
- Azione di copia che facilita l'utilizzo del valore in altri contesti

### 2. TextInput con Sincronizzazione Live dal Campo Name

```php
'slug' => Forms\Components\TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->maxLength(255)
    ->disabled()
    ->dehydrated()
    ->live()
    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
        if (!$state || $get('generateSlug')) {
            $set('slug', Str::slug($get('name')));
        }
    })
    ->suffixAction(
        Forms\Components\Actions\Action::make('regenerateSlug')
            ->icon('heroicon-o-arrow-path')
            ->tooltip('Rigenera dallo slug dal nome')
            ->action(fn (Forms\Get $get, Forms\Set $set) =>
                $set('slug', Str::slug($get('name'))))
    ),
```

**Vantaggi UI/UX:**
- Campo inizialmente disabilitato per prevenire errori
- Sincronizzazione automatica con il campo nome
- Pulsante per rigenerare lo slug in caso di modifiche al nome
- Visualizzazione chiara che lo slug è derivato dal nome

### 3. Soluzione Completa con Toggle per Personalizzazione

```php
Forms\Components\Group::make([
    'name' => Forms\Components\TextInput::make('name')
        ->required()
        ->maxLength(255)
        ->live(onBlur: true)
        ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, string $context, ?string $state) {
            if ($context === 'create' && $get('generateSlug')) {
                $set('slug', Str::slug($state));
            }
        }),

    Forms\Components\Grid::make(2)
        ->schema([
            'generateSlug' => Forms\Components\Toggle::make('generateSlug')
                ->label('Genera slug automaticamente')
                ->default(true)
                ->live()
                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, bool $state) {
                    if ($state) {
                        $set('slug', Str::slug($get('name')));
                    }
                }),

            'slug' => Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255)
                ->disabled(fn (Forms\Get $get): bool => $get('generateSlug'))
                ->dehydrated()
                ->prefixIcon('heroicon-o-link')
                ->suffixAction(
                    Forms\Components\Actions\Action::make('copySlug')
                        ->icon('heroicon-o-clipboard-copy')
                        ->tooltip('Copia negli appunti')
                )
        ])
])->columnSpanFull(),
```

**Vantaggi UI/UX:**
- Toggle per scegliere tra generazione automatica e personalizzazione
- Disabilitazione condizionale del campo slug
- Layout a griglia che ottimizza lo spazio
- Feedback visivo completo con icone e azioni

## Esempio con Preview dello Slug

```php
'slug' => Forms\Components\TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true)
    ->maxLength(255)
    ->helperText(function (Forms\Get $get): string {
        $slug = Str::slug($get('name'));
        return "Preview: {$slug}";
    })
    ->hintIcon('heroicon-o-information-circle')
    ->hintIconTooltip('Lo slug è un identificatore univoco utilizzato nelle API e nei riferimenti al template'),
```

**Vantaggi UI/UX:**
- Preview in tempo reale dello slug generato
- Icona di informazione con tooltip per spiegazioni aggiuntive
- Aiuto contestuale che mostra il risultato della trasformazione

## Considerazioni sulla Localizzazione

Tutti i testi visualizzati (etichette, placeholder, tooltip) devono essere gestiti attraverso il sistema di traduzione:

```php
// In /lang/{locale}/notify.php
return [
    'resources' => [
        'mail_template' => [
            'fields' => [
                'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Nome del template (es. Email di Benvenuto)',
                    'helper' => 'Il nome deve essere unico e descrittivo',
                ],
                'slug' => [
                    'label' => 'Slug',
                    'helper' => 'Identificatore unico utilizzato nel codice',
                    'auto_generate' => 'Genera slug automaticamente',
                    'copy_tooltip' => 'Copia negli appunti',
                    'regenerate_tooltip' => 'Rigenera dallo slug dal nome',
                ],
            ],
        ],
    ],
];
```

## Conformità con gli Standard <main module>

Tutti i componenti proposti:
1. Non utilizzano il metodo `->label()` sui componenti Filament
2. Restituiscono un array associativo con chiavi stringhe in `getFormSchema()`
3. Utilizzano i componenti nativi di Filament
4. Evitano l'uso di componenti deprecati come `Card` e `Section`

## Conclusioni

I miglioramenti UI/UX proposti per i campi `name` e `slug` si concentrano su:
1. **Feedback visivo** tramite icone e indicatori
2. **Automazione intelligente** per ridurre gli errori di input
3. **Azioni contestuali** che facilitano operazioni comuni
4. **Relazioni intuitive** tra campi correlati

L'implementazione di questi miglioramenti rispetta le convenzioni del progetto <main module> mentre offre un'esperienza utente significativamente migliorata nella gestione dei template email.

## Riferimenti

- [Documentazione Filament Forms](https://filamentphp.com/docs/forms/fields/text-input)
- [Implementazione Modello con Slug](./MODEL_SLUG_IMPLEMENTATION.md)
- [Implementazione Risorsa con Slug](./RESOURCE_SLUG_IMPLEMENTATION.md)
