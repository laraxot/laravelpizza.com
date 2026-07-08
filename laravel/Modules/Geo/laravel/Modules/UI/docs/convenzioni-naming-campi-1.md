# Convenzioni di Naming dei Campi

## Collegamenti Bidirezionali
- [Best Practices UI](../best-practices.md)
- [Errori Comuni UI](../filament-components-errors.md)
- [Implementazione Corretta](../examples/correct-implementation.md)

## Campi Nome e Cognome

### ❌ NON FARE
```php
TextInput::make('name')  // ❌ Ambiguo: potrebbe essere solo nome o nome completo
TextInput::make('surname')
```

### ✅ FARE - Caso 1: Campi Separati
```php
TextInput::make('first_name')  // ✅ Chiaro: solo nome
TextInput::make('last_name')   // ✅ Chiaro: solo cognome
```

### ✅ FARE - Caso 2: Campo Unico
```php
TextInput::make('full_name')   // ✅ Chiaro: nome completo (nome + cognome)
```

## Motivazioni

1. **Standardizzazione**:
   - `first_name` e `last_name` sono standard internazionali per campi separati
   - `full_name` è lo standard per il nome completo in un unico campo
   - Facilita l'integrazione con API esterne
   - Migliora la compatibilità con sistemi di terze parti

2. **Chiarezza Semantica**:
   - `first_name`: indica chiaramente il nome di battesimo
   - `last_name`: indica chiaramente il cognome
   - `full_name`: indica chiaramente che contiene nome e cognome insieme
   - Evita ambiguità in contesti multilingua

3. **Consistenza del Database**:
   - Facilita le query SQL
   - Migliora la leggibilità del database
   - Standardizza le relazioni tra tabelle

4. **Validazione e Formattazione**:
   - Permette validazioni specifiche per tipo di nome
   - Facilita la formattazione corretta
   - Migliora la gestione dei casi speciali

## Best Practices

1. **Naming**:
   - Usare `first_name` per il nome quando separato
   - Usare `last_name` per il cognome quando separato
   - Usare `full_name` per nome e cognome insieme
   - Evitare variazioni come `name`, `surname`, `given_name`

2. **Scelta del Tipo di Campo**:
   - Campi separati (`first_name`/`last_name`): quando serve manipolare nome e cognome separatamente
   - Campo unico (`full_name`): quando il nome completo è sufficiente e non serve separarlo

3. **Validazione**:
   - Implementare regole specifiche per ogni tipo di campo
   - Considerare le regole di formattazione per paese
   - Adattare le validazioni al contesto d'uso

## Esempi di Implementazione

### Campi Separati
```php
TextInput::make('first_name')
    ->label('Nome')
    ->required()
    ->maxLength(255)
    ->rules(['alpha', 'min:2'])

TextInput::make('last_name')
    ->label('Cognome')
    ->required()
    ->maxLength(255)
    ->rules(['alpha', 'min:2'])
```

### Campo Unico
```php
TextInput::make('full_name')
    ->label('Nome e Cognome')
    ->required()
    ->maxLength(255)
    ->rules(['string', 'min:5'])
```

## Note Importanti

1. Questa convenzione è obbligatoria per tutto il progetto
2. Applicare a tutti i moduli e componenti
3. Mantenere coerenza in database, API e UI
4. Considerare le implicazioni per l'internazionalizzazione

## Collegamenti Correlati

- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/fields/text-input)
- [Best Practices Database](../../../docs/database/best-practices.md)
- [Convenzioni API](../../../docs/api/convenzioni.md)
## Collegamenti tra versioni di convenzioni-naming-campi.md
* [convenzioni-naming-campi.md](../../../../docs/convenzioni-naming-campi.md)
