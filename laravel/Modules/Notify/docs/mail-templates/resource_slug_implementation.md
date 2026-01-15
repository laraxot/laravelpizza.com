# Implementazione del Campo `slug` in MailTemplateResource

## Panoramica

Questo documento descrive l'implementazione del campo `slug` nella risorsa Filament `MailTemplateResource`, rispettando le convenzioni e gli standard del progetto SaluteOra.

## Implementazione nel Form Schema

L'aggiunta del campo `slug` al form schema di `MailTemplateResource` segue le convenzioni del progetto che richiedono un array associativo con chiavi stringhe:

```php
/**
 * Campo slug in getFormSchema()
 */
public static function getFormSchema(): array
{
    return [
        'name' => Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
            
        'slug' => Forms\Components\TextInput::make('slug')
            ->required()
            ->unique(ignoreRecord: true)
            ->maxLength(255)
            ->afterStateUpdated(fn (string $context, $state, callable $set) => 
                $context === 'create' ? $set('slug', Str::slug($state)) : null),
            
        'mailable' => Forms\Components\TextInput::make('mailable')
            ->required()
            ->maxLength(255),
        
        // Altri campi...
    ];
}
```

### Caratteristiche Implementate

1. **Chiavi Stringhe**: In conformità con la regola che impone di usare array associativi con chiavi stringhe.
2. **Campo Obbligatorio**: Il campo slug è marcato come `required()`.
3. **Validazione Unicità**: L'opzione `unique(ignoreRecord: true)` garantisce unicità, escludendo il record corrente durante l'aggiornamento.
4. **Generazione Automatica**: La callback `afterStateUpdated()` genera automaticamente lo slug dal nome quando si crea un nuovo record.

## Conformità con gli Standard SaluteOra

Questa implementazione aderisce a diversi standard chiave del progetto:

1. **XotBaseResource**: La risorsa estende `XotBaseResource` e quindi non definisce proprietà di navigazione come `$navigationIcon`.

2. **Array Associativo**: Il metodo `getFormSchema()` restituisce un array associativo con chiavi stringhe, non un array numerico, come richiesto dalla documentazione.

3. **Nessun `Card` o `Section`**: Non utilizza i componenti deprecati `Forms\Components\Card` e `Forms\Components\Section`.

4. **Nessun `label()`**: Non usa il metodo `->label()` sui componenti Filament, poiché le etichette sono gestite automaticamente dal `LangServiceProvider`.

## Implementazione nelle Tabelle

Il campo `slug` è anche implementato nelle colonne della tabella di visualizzazione:

```php
/**
 * Campo slug in getListTableColumns()
 */
public static function getListTableColumns(): array
{
    return [
        'id' => Tables\Columns\TextColumn::make('id')
            ->sortable(),
            
        'name' => Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
            
        'slug' => Tables\Columns\TextColumn::make('slug')
            ->searchable()
            ->sortable()
            ->copyable(),
            
        // Altri campi...
    ];
}
```

L'opzione `->copyable()` è stata aggiunta per facilitare il copia-incolla degli slug.

## Ricerca e Filtraggio

L'aggiunta del campo `slug` migliora anche le capacità di ricerca e filtraggio:

```php
/**
 * Metodo getGlobalSearchAttributes()
 */
public static function getGlobalSearchAttributes(): array
{
    return ['name', 'slug', 'mailable'];
}

/**
 * Metodo getTableFilters()
 */
public static function getTableFilters(): array
{
    return [
        // Altri filtri...
        
        'slug' => Tables\Filters\TextFilter::make('slug')
    ];
}
```

## Modifiche alle Traduzioni

In conformità con le regole di localizzazione del progetto, le chiavi di traduzione sono strutturate gerarchicamente:

```php
// In /laravel/lang/{locale}/notify.php
return [
    'resources' => [
        'mail_template' => [
            'fields' => [
                'name' => [
                    'label' => 'Nome',
                ],
                'slug' => [
                    'label' => 'Slug',
                    'helper' => 'Identificatore univoco utilizzato nel codice',
                ],
                // Altri campi...
            ],
        ],
    ],
];
```

## Migliori Pratiche per Sviluppatori

1. **Accedere ai Template**:
   ```php
   // Usare il campo slug nei link
   <x-filament::link :href="route('filament.resources.mail-templates.edit', ['record' => $template->slug])">
       {{ $template->name }}
   </x-filament::link>
   ```

2. **Ordinamento e Ricerca**:
   ```php
   // Ordinare i template per slug
   MailTemplate::query()->orderBy('slug')->get();
   
   // Cercare template per slug parziale
   MailTemplate::query()->where('slug', 'like', 'welcome-%')->get();
   ```

3. **Validazione**:
   ```php
   // Validare i dati in ingresso
   $request->validate([
       'slug' => ['required', 'string', 'max:255', Rule::unique('mail_templates')->ignore($id)],
   ]);
   ```

## Riferimenti

- [Implementazione del Modello](./MODEL_SLUG_IMPLEMENTATION.md)
- [Struttura della Migrazione](./MIGRATION_STRUCTURE.md)
- [Guida alla Migrazione](../MAIL_TEMPLATE_MIGRATION_GUIDE.md)
- [Convenzioni Filament](../../../../docs/FILAMENT_CONVENTIONS.md)
- [Regole per Filament](../../../../docs/FILAMENT_RULES.md)
