# Gestione delle Traduzioni con LangServiceProvider

## Collegamenti Bidirezionali
- [Best Practices UI](../best-practices.md)
- [Errori Comuni UI](../filament-components-errors.md)
- [Form Schema Rules](../form-schema-rules.md)
- [Convenzioni di Naming](../convenzioni-naming-campi.md)

## Regola: No Label Method

### ❌ NON FARE
```php
Forms\Components\TextInput::make('first_name')
    ->label('Nome')  // ❌ Non usare il metodo label()
    ->placeholder('Inserisci il nome');

Forms\Components\TextInput::make('first_name')
    ->label(trans('prefix.fields.first_name.label'))  // ❌ Non usare neanche trans()
    ->placeholder('Inserisci il nome');
```

### ✅ FARE
```php
Forms\Components\TextInput::make('first_name')  // ✅ Il LangServiceProvider gestirà automaticamente la label
    ->placeholder('Inserisci il nome');
```

## Struttura File di Traduzione

```php
// lang/it/module-name.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Inserisci il tuo nome di battesimo',
        ],
    ],
];
```

## Motivazioni

1. **Centralizzazione**:
   - Tutte le traduzioni sono gestite centralmente
   - Evita duplicazione di stringhe
   - Facilita la manutenzione

2. **Convenzioni**:
   - Struttura standardizzata dei file di traduzione
   - Naming consistente delle chiavi
   - Pattern predefiniti per i campi

3. **Automazione**:
   - LangServiceProvider gestisce automaticamente le label
   - Riduce il codice boilerplate
   - Previene errori di inconsistenza

4. **Internazionalizzazione**:
   - Supporto multilingua semplificato
   - Gestione coerente delle traduzioni
   - Facilità di aggiunta nuove lingue

## Come Funziona

1. **Registrazione Automatica**:
   - LangServiceProvider registra i file di traduzione
   - Scansiona le directory dei moduli
   - Carica le traduzioni in base alla lingua corrente

2. **Convenzioni di Naming**:
   - `fields.{field_name}.label`: Label del campo
   - `fields.{field_name}.placeholder`: Placeholder del campo
   - `fields.{field_name}.help`: Testo di aiuto
   - `fields.{field_name}.hint`: Suggerimento

3. **Risoluzione Label**:
   - Campo: `first_name`
   - Modulo: `Patient`
   - File: `Patient/lang/it/doctor-resource.php`
   - Chiave: `fields.first_name.label`

## Best Practices

1. **Struttura File**:
   - Un file per risorsa
   - Organizzazione gerarchica delle chiavi
   - Documentazione delle chiavi complesse

2. **Naming**:
   - Chiavi in snake_case
   - Nomi descrittivi e coerenti
   - Evitare abbreviazioni

3. **Manutenzione**:
   - Aggiornare tutte le lingue insieme
   - Mantenere le chiavi ordinate
   - Documentare i cambiamenti

## Esempi di Implementazione

```php
// Modules/Patient/lang/it/doctor-resource.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome di battesimo del medico',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del medico',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Medico',
            'success' => 'Medico creato con successo',
        ],
    ],
];

// Modules/Patient/Filament/Resources/DoctorResource.php
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('first_name'),  // La label viene gestita automaticamente
        Forms\Components\TextInput::make('last_name'),   // La label viene gestita automaticamente
    ];
}
```

## Note Importanti

1. Mai usare il metodo `label()`
2. Mantenere i file di traduzione aggiornati
3. Seguire le convenzioni di naming
4. Documentare le chiavi di traduzione

## Collegamenti Correlati

- [Laravel Localization](https://laravel.com/docs/localization)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Best Practices Internazionalizzazione](../../../docs/i18n/best-practices.md)
