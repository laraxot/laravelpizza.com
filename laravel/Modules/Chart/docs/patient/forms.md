# Form e Campi JSON

## Regole Generali

1. I campi JSON devono essere sempre definiti come `json` o `jsonb` nel database
2. I campi JSON devono essere sempre castati nel modello usando `casts`
3. I campi JSON devono essere sempre validati nel form usando `array()`
4. I campi JSON devono essere sempre inizializzati come array vuoto nel modello

## Esempio di Implementazione

```php
// Migration
Schema::table('users', function (Blueprint $table) {
    $table->json('certifications')->nullable();
});

// Model
protected $casts = [
    'certifications' => 'array'
];

protected $attributes = [
    'certifications' => '[]'
];

// Form
Forms\Components\Repeater::make('certifications')
    ->schema([
        // ... campi del repeater
    ])
    ->array()
```

## Errori Comuni

1. **Errore**: Column not found: 1054 Unknown column 'certifications' in 'field list'
   **Soluzione**: Verificare che la colonna esista nel database e sia di tipo `json` o `jsonb`

2. **Errore**: Array to string conversion
   **Soluzione**: Assicurarsi di usare `->array()` nel form e il cast corretto nel modello

3. **Errore**: Invalid JSON
   **Soluzione**: Inizializzare sempre il campo come array vuoto nel modello

## Best Practices

1. **Validazione**:
   - Usare sempre `array()` nel form
   - Definire regole di validazione per ogni campo del repeater
   - Validare la struttura JSON nel form

2. **Inizializzazione**:
   - Inizializzare sempre i campi JSON come array vuoto
   - Usare il cast corretto nel modello
   - Gestire i casi null

3. **Sicurezza**:
   - Sanitizzare i dati in ingresso
   - Validare la struttura JSON
   - Gestire i permessi di accesso

## Collegamenti

- [Gestione Campi JSON](../xot/forms.md#campi-json)
- [Validazione Form](../xot/forms.md#validazione)
- [Best Practices](../xot/forms.md#best-practices) 